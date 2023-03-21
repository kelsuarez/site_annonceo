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
$queryCommentaire = $pdo->query(" SELECT COUNT(id_commentaire) AS nombreCommentaires FROM commentaire");
$resultatCommentaire = $queryCommentaire->fetch();
$nombreCommentaire = (int) $resultatCommentaire['nombreCommentaires'];
$pagination = 5;
$nombrePages = ceil($nombreCommentaire / $pagination);
$premierCommentaire = ($pageCourante - 1) * $pagination;

// URL = ACTION
if (isset($_GET['action'])) {

    if ($_POST) {

        if (!isset($_POST['commentaire']) || iconv_strlen($_POST['commentaire']) < 3 || iconv_strlen($_POST['commentaire']) > 500) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format commentaire !</div>';
        }

        if (empty($erreur)){
            
            if ($_GET['action'] == 'update') {
                
                $modifCommentaire = $pdo->prepare("UPDATE commentaire SET id_commentaire  = :id_commentaire , membre_id = :membre_id, annonce_id  = :annonce_id, commentaire  = :commentaire WHERE id_commentaire = :id_commentaire");
                $modifCommentaire->bindValue(':id_commentaire', $_POST['id_commentaire'], PDO::PARAM_INT);
                $modifCommentaire->bindValue(':membre_id', $_POST['membre_id'], PDO::PARAM_INT);
                $modifCommentaire->bindValue(':annonce_id', $_POST['annonce_id'], PDO::PARAM_INT);
                $modifCommentaire->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);
                $modifCommentaire->execute();

            } else {

                $creationCommentaire = $pdo->prepare(" INSERT INTO commentaire (id_commentaire, membre_id, annonce_id, commentaire,date_enregistrement) VALUES (:id_commentaire, :membre_id, :annonce_id, :commentaire, NOW()) ");
                $creationCommentaire->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);
                $creationCommentaire->bindValue(':id_commentaire', $_POST['id_commentaire'], PDO::PARAM_STR);
                $creationCommentaire->bindValue(':membre_id', $_POST['membre_id'], PDO::PARAM_STR);
                $creationCommentaire->bindValue(':annonce_id', $_POST['annonce_id'], PDO::PARAM_STR);
                $creationCommentaire->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_INT);
                $creationCommentaire->execute();
            }
        }
    }

    if ($_GET['action'] == 'update') {
        $tousCommentaire = $pdo->query("SELECT * FROM commentaire WHERE commentaire = '$_GET[commentaire]' ");
        $commentaireActuel = $tousCommentaire->fetch(PDO::FETCH_ASSOC);
    }

    $commentaire = (isset($commentaireActuel['commentaire'])) ? $commentaireActuel['commentaire'] : "";
    
    // REQUETE - RECUPERATION EN BDD POUR UN UPDATE
    if ($_GET['action'] == 'update'){
        $tousCommentaire = $pdo->query("SELECT * FROM commentaire WHERE id_commentaire = '$_GET[id_commentaire]' ");
        $commentaireActuel = $tousCommentaire->fetch(PDO::FETCH_ASSOC);
    }

    $id_commentaire = (isset($commentaireActuel['id_commentaire'])) ? $commentaireActuel['id_commentaire'] : "";
    $membre_id  = (isset($commentaireActuel['membre_id '])) ? $commentaireActuel['membre_id '] : "";
    $annonce_id  = (isset($commentaireActuel['annonce_id '])) ? $commentaireActuel['annonce_id '] : "";
    $commentaire  = (isset($commentaireActuel['commentaire '])) ? $commentaireActuel['commentaire '] : "";

    // REQUETE - DELETE
    if($_GET['action'] == 'delete'){
        $pdo->query(" DELETE FROM commentaire WHERE id_commentaire = '$_GET[id_commentaire]' ");
    }
    
}

require_once('includeAdmin/header.php');
?>

<?= $erreur ?>
<?= $content ?>

<!-- TITLE GESTION -->
<h1 class="text-center display-4 my-5 text-wrap p-3">Gestion de commentaires</h1>

<!-- NOMBRE DE CATEGORIES EN BDD -->
<?php $nombreCommentaires = $pdo->query("SELECT id_commentaire FROM commentaire"); ?>
<h2 class="py-5 text-center">Commentaires en base de données:</h2>
<h3 class="text-center display-2 mb-5 p-3"><?= $nombreCommentaires->rowCount() ?></h3>

<!-- TABLEAU DE RESCUPERATION DONNES -->
<table class="table table-white text-center rounded-1">
    <?php $afficheCommentaire = $pdo->query("SELECT * FROM commentaire ORDER BY date_enregistrement ASC LIMIT $pagination OFFSET $premierCommentaire "); ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $afficheCommentaire->columnCount(); $i++) :
                $colonne = $afficheCommentaire->getColumnMeta(($i)) ?>
                    <th class="p-3 text-uppercase"><?= $colonne['name'] ?></th>
            <?php endfor; ?>
            <th colspan=2 class="p-3 text-uppercase">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $afficheCommentaire->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($user as $key => $value) : ?>
                        <td><?= $value ?></td>
                <?php endforeach; ?>
                <td><a data-href="?action=delete&id_commentaire=<?= $user['id_commentaire'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger" style="font-size: 1.5rem;"></i></a></td>
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
                    <h5 class="modal-title text-danger text-uppercase" id="exampleModalLabel">Gestion des commentaires</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body col-8 mx-auto text-center">
                    <p>Gérez ici votre base de données des commentaires</p>
                    <p>Vous pouvez uniquement supprimer des commentaires, par exemple dans le cas de commentaires offensives</p>
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