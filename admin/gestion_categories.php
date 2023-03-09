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
$queryCategories = $pdo->query(" SELECT COUNT(id_categorie) AS nombreCategories FROM categorie");
$resultatCategorie = $queryCategories->fetch();
$nombreCategories = (int) $resultatCategorie['nombreCategories'];
$pagination = 5;
$nombrePages = ceil($nombreCategories / $pagination);
$premierCategorie = ($pageCourante - 1) * $pagination;

// REQUETTE GET POUR TRAVAIILLER SUR L'URL
if (isset($_GET['action'])) {

    if ($_POST) {

        // REQUETTE DE CONTRAINTES
        if (!isset($_POST['titre']) || !preg_match('#^[a-zA-Zé]{3,30}$#', $_POST['titre'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format titre !</div>';
        }
        if (!isset($_POST['motscles']) || !preg_match('#^[a-zA-Z -_.é^ô]{3,150}$#', $_POST['motscles'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format motscles !</div>';
        }
        // REQUETTE DE SI PAS DE ERREUR ON PEUT CONTINUER
        if (empty($erreur)){
            if ($_GET['action'] == 'update') {
                $modifCategorie = $pdo->prepare("UPDATE categorie SET id_categorie = :id_categorie, titre = :titre, motscles = :motscles WHERE id_categorie = :id_categorie");
                $modifCategorie->bindValue(':id_categorie', $_POST['id_categorie'], PDO::PARAM_INT);
                $modifCategorie->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $modifCategorie->bindValue(':motscles', $_POST['motscles'], PDO::PARAM_STR);
                $modifCategorie->execute();

                // MESSAGE PERSONALISE A INTEGRER
            }else{
                $creationCategorie = $pdo->prepare(" INSERT INTO categorie (titre, motscles) VALUES (:titre, :motscles)");
                $creationCategorie->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $creationCategorie->bindValue(':motscles', $_POST['motscles'], PDO::PARAM_STR);
                $creationCategorie->execute();
            }
        }
    }
    if ($_GET['action'] == 'update'){
        $tousCategorie = $pdo->query("SELECT * FROM categorie WHERE id_categorie = '$_GET[id_categorie]' ");
        $categorieActuel = $tousCategorie->fetch(PDO::FETCH_ASSOC);
    }

    $id_categorie = (isset($categorieActuel['id_categorie'])) ? $categorieActuel['id_categorie'] : "";
    $titre = (isset($categorieActuel['titre'])) ? $categorieActuel['titre'] : "";
    $motsCles = (isset($categorieActuel['motscles'])) ? $categorieActuel['motscles'] : "";

    // REQUETE - DELETE
    if($_GET['action'] == 'delete'){
        $pdo->query(" DELETE FROM categorie WHERE id_categorie = '$_GET[id_categorie]' ");
    }
    
}

require_once('includeAdmin/header.php');
?>

<?= $erreur ?>
<?= $content ?>

<!-- TITLE GESTION -->
<h1 class="text-center my-5">
    <div class="badge badge-success text-wrap p-3">Gestion des catégories</div>
</h1>

<!-- FORMULAIRE -->
<?php if (isset($_GET['action'])) : ?>

    <!-- TITLE FORMULAIRE -->
    <h2 class="my-5 text-center"><u>Formulaire <?= ($_GET['action'] == 'add') ? "d'ajout" : "de modification" ?> des catégories</u></h2>


    <form class="my-5" method="POST" action="">
        
        <!-- HIDDEN -->
        <input type="" name="id_categorie" value="<?= $id_categorie ?>">


            <!-- TITRE -->
            <div class="col-md-4 mt-5 mx-auto">
                <label class="form-label" for="titre">
                    <div class="badge badge-dark text-wrap">Titre</div>
                </label>
                <input class="form-control" type="text" name="titre" id="titre" placeholder="Titre" title="caractères acceptés: majuscules et minuscules, entre trois et trente caractères." required value="<?= $titre ?>">
            </div>
            
            <!-- MOTS CLES -->
            <div class="col-md-4 mt-5 mx-auto">
                <label class="form-label" for="motscles">
                    <div class="badge badge-dark text-wrap">mots clés</div>
                </label>
                <input class="form-control" type="text" name="motscles" id="motscles" placeholder="Mots clés" title="caractères acceptés: majuscules et minuscules, chiffres, signes tels que: ^ - _ . , entre trois et cent cinquante caractères." required value="<?= $motsCles ?>">
            </div>


        <!-- VALIDATION -->
        <div class="col-md-3 mt-5 mx-auto">
            <button type="submit" class="btn btn-outline-dark btn-success w-100 text-white"><strong>Valider<strong></button>
        </div>

    </form>
<?php endif; ?>

<!-- NOMBRE DE CATEGORIES EN BDD -->
<?php $nombreCategories = $pdo->query("SELECT id_categorie FROM categorie"); ?>
<h2 class="py-5 text-center">Catégories en base de données:</h2>
<h3 class="text-center display-3">
    <div class="badge badge-success p-3"><?= $nombreCategories->rowCount() ?></div>
</h3>

<!-- BUTTON D'AJOUT -->
<div class=" col-3 mx-auto py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-sm btn-outline-dark btn-warning rounded w-100 p-3">
            <i class="bi bi-plus-circle-fill"></i> Ajouter une categorie
        </button>
    </a>
</div>

<!-- TABLEAU DE RESCUPERATION DONNES -->
<table class="table table-white text-center rounded-1">
    <?php $afficheCategorie = $pdo->query("SELECT * FROM categorie ORDER BY titre ASC LIMIT $pagination OFFSET $premierCategorie "); ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $afficheCategorie->columnCount(); $i++) :
                $colonne = $afficheCategorie->getColumnMeta(($i)) ?>
                    <th class="p-3 text-uppercase"><?= $colonne['name'] ?></th>
            <?php endfor; ?>
            <th colspan=2 class="p-3 text-uppercase">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $afficheCategorie->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($user as $key => $value) : ?>
                        <td><?= $value ?></td>
                <?php endforeach; ?>
                <td><a href='?action=update&id_categorie=<?= $user['id_categorie'] ?>'><i class="bi bi-pencil-square" style="font-size: 1.5rem;"></i></a></td>
                <td><a href='?action=see&id_categorie=<?= $user['id_categorie'] ?>'><i class="bi bi-eye" style="font-size: 1.5rem;"></i></a></td>
                <td><a data-href="?action=delete&id_categorie=<?= $user['id_categorie'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash" style="font-size: 1.5rem;"></i></a></td>
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
                    <h5 class="modal-title text-danger text-uppercase" id="exampleModalLabel">Gestion des catégories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body col-8 mx-auto text-center">
                    <p>Gérez ici votre base de données des catégories</p>
                    <p>Vous pouvez modifier leurs titre, ajouter ou supprimer une nouvelle catégorie</p>
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