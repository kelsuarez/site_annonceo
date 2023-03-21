<?php
require_once('../include/init.php');

// CONNEXION ADMIN
if (!internauteConnecteAdmin()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

// PAGINATION
if(isset($_GET['page']) && !empty($_GET['page'])){
    $pageCourante = (int) strip_tags($_GET['page']);
}else{
    $pageCourante = 1;
}
$queryNote = $pdo->query(" SELECT COUNT(id_note) AS nombreNotes FROM note");
$resultatNote = $queryNote->fetch();
$nombreNote = (int) $resultatNote['nombreNotes'];
$pagination = 5;
$nombrePages = ceil($nombreNote / $pagination);
$premierNote = ($pageCourante - 1) * $pagination;

// REQUETTE GET POUR TRAVAIILLER SUR L'URL
if (isset($_GET['action'])) {

    // REQUETTE DE UPDATE
    if($_GET['action'] == 'update'){
        $detailleNote = $pdo->query("SELECT * FROM note WHERE id_note = '$_GET[id_note]'");
        $noteActuel = $detailleNote->fetch(PDO::FETCH_ASSOC);
    }

    // REQUETTE DE RECUPERATION DE BDD PAR APPORT A LES DONNES EN FORM
    $membre_id1  = (isset($noteActuel['membre_id1 '])) ? $noteActuel['membre_id1 '] : "";
    $membre_id2  = (isset($noteActuel['membre_id2 '])) ? $noteActuel['membre_id2 '] : "";
    $note = (isset($noteActuel['note'])) ? $noteActuel['note'] : "";
    $date_enregistrement = (isset($noteActuel['date_enregistrement'])) ? $noteActuel['date_enregistrement'] : "";

    // REQUETE - DELETE
    if($_GET['action'] == 'delete'){
        $pdo->query(" DELETE FROM note WHERE id_note = '$_GET[id_note]' ");
    }
    
}

require_once('includeAdmin/header.php');
?>

<?= $erreur ?>
<?= $content ?>

<!-- TITLE GESTION -->
<h1 class="text-center display-4 my-5 text-wrap p-3">Gestion de notes</h1>

<!-- NOMBRE DE CATEGORIES EN BDD -->
<?php $nombreNotes = $pdo->query("SELECT id_note FROM note"); ?>
<h2 class="py-5 text-center">Notes en base de données:</h2>
<h3 class="text-center display-2 mb-5 p-3"><?= $nombreNotes->rowCount() ?></h3>

<!-- TABLEAU DE RESCUPERATION DONNES -->
<table class="table table-white text-center rounded-1">
    <?php $afficheNote = $pdo->query("SELECT * FROM note ORDER BY date_enregistrement ASC LIMIT $pagination OFFSET $premierNote "); ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $afficheNote->columnCount(); $i++) :
                $colonne = $afficheNote->getColumnMeta(($i)) ?>
                    <th class="p-3 text-uppercase"><?= $colonne['name'] ?></th>
            <?php endfor; ?>
            <th colspan=2 class="p-3 text-uppercase">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $afficheNote->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($user as $key => $value) : ?>
                        <td><?= $value ?></td>
                <?php endforeach; ?>
                <td><a data-href="?action=delete&id_note=<?= $user['id_note'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger" style="font-size: 1.5rem;"></i></a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- PAGINATION -->
<nav aria-label="">
    <ul class="pagination justify-content-end">
        <li class="page-item <?= ($pageCourante == 1) ? 'disabled' : "" ?> ">
            <a class="page-link text-dark" href="?page=<?= $pageCourante - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">précédente</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <?php for($page = 1; $page <= $nombrePages; $page++): ?>
        <li class="mx-1 page-item">
            <a class="btn btn-outline-success <?= ($pageCourante == $page) ? 'active' : "" ?>" href="?page=<?= $page ?>"><?= $page ?> </a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?= ($pageCourante == $nombrePages)? 'disabled' : '' ?>">
            <a class="page-link text-dark" href="?page=<?= $pageCourante + 1 ?>" aria-label="Next">
                <span aria-hidden="true">suivante</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>

<!-- MODAL DE SUP/MDF-->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Supprimer Categorie
            </div>
            <div class="modal-body">
                Etes-vous sur de vouloir retirer cette categorie de votre base de données ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL GESTION DES CATEGORIES -->
<?php if (!isset($_GET['action']) && !isset($_GET['page'])) : ?>
    <!-- modal infos -->
    <div class="modal fade" id="myModalUsers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger text-uppercase" id="exampleModalLabel">Gestion des notes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body col-8 mx-auto text-center">
                    <p>Gérez ici votre base de données des notes</p>
                    <p>Vous pouvez uniquement supprimer des notes, par exemple dans le cas de notes offensives</p>
                </div>
                <div class="modal-footer col-5 mx-auto">
                    <button type="button" class="btn btn-outline-success text-dark w-100" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
<?php endif; ?>

<?php require_once('includeAdmin/footer.php'); ?>