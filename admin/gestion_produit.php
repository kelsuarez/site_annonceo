<?php
require_once('../include/init.php');

if (!internauteConnecteAdmin()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

// pagination selon produits

// si un indice page existe dans l'URL et qu'on trouve une valeur dedans
// if(isset($_GET['page']) && !empty($_GET['page'])){
    // alors on declare une variable $pageCourante ($currentPage) à laquelle on va affecter la valeur véhiculée par l'indice page dans l'URL
    // protection de ce qui sera véhiculé dans l'URL avec strip_tags ou htmlspecialchars, plus on force le typage de l'information dans l'URL avec (int) pour indiquer qu'on ne veut pas recevoir autre chose qu'un nombre entier
    // $pageCourante = (int) strip_tags($_GET['page']);
// }else{
    // dans le cas ou aucune information n'a transité dans l'URL, $pageCourante prendra la valeur par défaut de 1 (nous sommes sur la première page)
    // $pageCourante = 1;
// }

// je dois connaitre le nombre de produits en BDD pour établir mon système de pagination
// je connais déjà ce nombre (voir en haut) avec un rowCount. La syntaxe qui va suivre est plus longue et compliqué (voir différentes manières de faire) mais elle sera plus rapide à l'exécution que rowCount (intéressant si le nb de produits se compte en milliers)
// $queryProduits = $pdo->query(" SELECT COUNT(id_produit) AS nombreProduits FROM produit ");
// le fetch après le query pour récupérer le nombre (pas besoin de fetch_assoc ou autre, je ne vais cibler aucune colonne, je veux récupérer un nombre total)
// $resultatProduits = $queryProduits->fetch();
// $nombreProduits = (int) $resultatProduits['nombreProduits'];
// echo debug($nombreProduits);

// je veux que sur chaque page, ne s'affiche dans le tableau que 10 produits
// $parPage = 10;
// calcul pour savoir combien de pages devront etre générées (nb évolutif, dynamique, le nombre de pages dont j'ai besoin aujourd'hui sera insuffisant dans un an)
// utilisation de ceil(), fonction prédéfinie qui arrondi à l'unité supérieur si le résultat de la division est un chiffre à virgule ( il n'existe 3,5 pages, on a besoin de 4 pages)
// $nombrePages = ceil($nombreProduits / $parPage);
// définir le premier produit qui va s'afficher à chaque nouvelle page (on va le cibler grace à l'indice qu'il occupe dans le tableau)
// $premierProduit = ($pageCourante - 1) * $parPage;

// fin de pagination

if (isset($_GET['action'])) {

    if ($_POST) {
        // TITRE
        if (!isset($_POST['titre']) || !preg_match('#^[a-zA-Z0-9 -._]{5,50}$#', $_POST['titre'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format titre !</div>';
        }
        // DESCRIPTION COURTE
        if (!isset($_POST['description_courte']) || !preg_match('#^[a-zA-Z0-9 -._]{5,100}$#', $_POST['description_courte'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format de description courte !</div>';
        }
        // DESCRIPTION LONGUE
        if (!isset($_POST['description_longue']) || !preg_match('#^[a-zA-Z0-9 -._]{5,200}$#', $_POST['description_longue'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format de description longue !</div>';
        }
        // PRIX
        if (!isset($_POST['prix']) || !preg_match('#^[0-9]{1,9}$#', $_POST['prix'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format prix !</div>';
        }
        // --------------------------------------------------------
        // PHOTO
        // --------------------------------------------------------
        // --------------------------------------------------------
        // PAYS
        // --------------------------------------------------------
        // VILLE
        if(!isset($_POST['ville']) || strlen($_POST['ville']) < 2 || strlen($_POST['ville']) > 30 ){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format ville !</div>';
        }
        // ADRESSE
        if(!isset($_POST['adresse']) || strlen($_POST['adresse']) < 5 || strlen($_POST['adresse']) > 50 ){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format adresse !</div>';
        }
        // CODE POSTAL
        if(!isset($_POST['code_postal']) || !preg_match('#^[0-9]{5}$#', $_POST['code_postal'])){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format code postal !</div>';
        }
        // $photo_bdd = "";
        // if($_GET['action'] == 'update'){
        //     $photo_bdd = $_POST['photoActuelle'];
        // }
        // if(!empty($_FILES['photo']['name'])){
        //     $photo_nom = $_POST['titre'] . '_' . $_FILES['photo']['name'];
        //     $photo_bdd = "$photo_nom";
        //     $photo_dossier = RACINE_SITE . "img/$photo_nom";
        //     copy($_FILES['photo']['tmp_name'], $photo_dossier);
        // }




        // if (!isset($_POST['couleur']) || $_POST['couleur'] != 'bleu' && $_POST['couleur'] != 'rouge' && $_POST['couleur'] != 'vert' && $_POST['couleur'] != 'jaune' && $_POST['couleur'] != 'blanc' && $_POST['couleur'] != 'noir' && $_POST['couleur'] != 'marron') {
        //     $erreur .= '<div class="alert alert-danger" role="alert">Erreur format couleur !</div>';
        // }

        // if (!isset($_POST['taille']) || $_POST['taille'] != 'small' && $_POST['taille'] != 'medium' && $_POST['taille'] != 'large' && $_POST['taille'] != 'xlarge') {
        //     $erreur .= '<div class="alert alert-danger" role="alert">Erreur format taille !</div>';
        // }

        // if (!isset($_POST['public']) || $_POST['public'] != 'enfant' && $_POST['public'] != 'femme' && $_POST['public'] != 'homme' && $_POST['public'] != 'mixte') {
        //     $erreur .= '<div class="alert alert-danger" role="alert">Erreur format public !</div>';
        // }

        // condition pour modifier une photo
        // if($_GET['action'] == 'update'){
            // A mettre en relation avec la nouvelle photo que l'on veut insérer en BDD pour remplacer l'ancienne
            // $photo_bdd = $_POST['photoActuelle'];
        // }


        // if(!empty($_FILES['photo']['name'])){
            // je donne un nom à la photo que je vais ajouter en concaténant le nom de la référence du produit, avec le nom du fichier photo d'origine (les deux étant séparés d'un underscore ( _ ) )
            // $photo_nom = $_POST['reference'] . '_' . $_FILES['photo']['name'];
            // utilisation de la variable photo_bdd pour lui affecter la valeur de photo_nom, sous forme de chaine de caractères (pour les bindValue)
            // $photo_bdd = "$photo_nom";
            // declaration d'une variable qui va enregistrer le chemin ou uploader notre fichier (les photos vont aller dans le dossier img de notre projet, en local comme en ligne lorsque le site sera hébergé)
            // $photo_dossier = RACINE_SITE . "img/$photo_nom";
            // processus d'envoi du fichier vers le dossier img, en passant par la fonction prédéfinie copy qui va donner un nom temporaire au fichier, avec de l'uploader dans le dossier img avec son nom définitif ($photo_nom)
        //     copy($_FILES['photo']['tmp_name'], $photo_dossier);
        // }

        // fin traitement pour la photo

        if (empty($erreur)) {
            if ($_GET['action'] == 'update') {
                $modifAnnonce = $pdo->prepare(" UPDATE annonce SET id_annonce  = :id_annonce  , titre = :titre, description_courte = :description_courte, description_longue = :description_longue, prix = :prix, photo = :photo, pays = :pays, ville = :ville, adresse	 = :adresse	, cp = :cp WHERE id_annonce = :id_annonce ");
                $modifAnnonce->bindValue(':id_annonce', $_POST['id_annonce'], PDO::PARAM_INT);
                $modifAnnonce->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':description_courte', $_POST['description_courte'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':description_longue', $_POST['description_longue'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':prix', $_POST['prix'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':photo', $_POST['photo'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
                // $modifAnnonce->bindValue(':ville', $photo_bdd, PDO::PARAM_STR);
                $modifAnnonce->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':cp', $_POST['cp'], PDO::PARAM_INT);
                $modifAnnonce->execute();

                $queryProduit = $pdo->query(" SELECT titre FROM produit WHERE id_produit = '$_GET[id_produit]' ");
                $produit = $queryProduit->fetch(PDO::FETCH_ASSOC);

                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> Modification du produit '. $produit['titre'] .' réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $inscrireAnnonce = $pdo->prepare(" INSERT INTO annonce (titre, description_courte, description_longue, prix, pays, ville, adresse) VALUES (:titre, :description_courte, :description_longue, :prix, :pays, :ville, :adresse) ");
                $inscrireAnnonce->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $inscrireAnnonce->bindValue(':description_courte', $_POST['description_courte'], PDO::PARAM_STR);
                $inscrireAnnonce->bindValue(':description_longue', $_POST['description_longue'], PDO::PARAM_STR);
                $inscrireAnnonce->bindValue(':prix', $_POST['prix'], PDO::PARAM_STR);
                // if (isset($_POST['photo'])) {
                    // $inscrireAnnonce->bindValue(':photo', $_POST['photo'], PDO::PARAM_STR);
                // } else {
                    // $inscrireAnnonce->bindValue(':photo', null, PDO::PARAM_NULL);
                // }
                $inscrireAnnonce->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);
                $inscrireAnnonce->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
                // pour le bindValue de la photo, on ne peut utiliser $_POST['photo'] pour le pointeur nommé :photo. On doit donner une chaine de caractères (affectée à $photo_bdd, voir plus en haut)
                // $inscrireProduit->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);
                $inscrireAnnonce->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_INT);
                // if (isset($_POST['cp'])) {
                //     $inscrireAnnonce->bindValue(':cp', $_POST['cp'], PDO::PARAM_INT);
                // } else {
                //     $inscrireAnnonce->bindValue(':cp', null, PDO::PARAM_NULL);
                // }
                $inscrireAnnonce->execute();
            }
        }
    }
    // REQUETE - RECUPERATION EN BDD POUR UN UPDATE
    if ($_GET['action'] == 'update') {
        $queryAnnonce = $pdo->query("SELECT * FROM annonce WHERE id_annonce = '$_GET[id_annonce]' ");
        $annonceActuel = $queryAnnonce->fetch(PDO::FETCH_ASSOC);
    }

    $id_annonce  = (isset($annonceActuel['id_annonce'])) ? $annonceActuel['id_annonce'] : "";
    $titre = (isset($annonceActuel['titre'])) ? $annonceActuel['titre'] : "";
    $description_courte = (isset($annonceActuel['description_courte'])) ? $annonceActuel['description_courte'] : "";
    $description_longue = (isset($annonceActuel['description_longue'])) ? $annonceActuel['description_longue'] : "";
    $prix = (isset($annonceActuel['prix'])) ? $annonceActuel['prix'] : "";
    $photo = (isset($annonceActuel['photo'])) ? $annonceActuel['photo'] : "";
    $pays = (isset($annonceActuel['pays'])) ? $annonceActuel['pays'] : "";
    $ville = (isset($annonceActuel['ville'])) ? $annonceActuel['ville'] : "";
    $adresse = (isset($annonceActuel['adresse'])) ? $annonceActuel['adresse'] : "";
    $codePostal = (isset($annonceActuel['cp'])) ? $annonceActuel['cp'] : "";

    if($_GET['action'] == 'delete'){
        $pdo->query(" DELETE FROM annonce WHERE id_annonce = '$_GET[id_annonce]' ");
    }
}

require_once('includeAdmin/header.php');
?>

<!-- $erreur .= '<div class="alert alert-danger" role="alert">Erreur format mot de passe !</div>'; -->

<!-- $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> Insertion du produit réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'; -->

<h1 class="text-center my-5">
    <div class="badge badge-warning text-wrap p-3">Gestion des produits</div>
</h1>

<?= $erreur ?>
<?= $content ?>
<!-- utilisation de la fonction personnalisée debug pour savoir ce qui a été récupéré avec $_POST, pour comprendre en cas de problème, ou se situe le problème -->
<!-- <?= debug($_POST) ?> -->

<?php if (!isset($_GET['action']) && !isset($_GET['page'])) : ?>
<div class="blockquote alert alert-dismissible fade show mt-5 shadow border border-warning rounded" role="alert">
    <p>Gérez ici votre base de données des produits</p>
    <p>Vous pouvez modifier leurs données, ajouter ou supprimer un produit</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<?php if(isset($_GET['action'])): ?>
<h2 class="pt-5">Formulaire <?= ($_GET['action'] == 'add') ? "d'ajout" : "de modification" ?> des produits</h2>

<!-- l'attribut enctype de la balise form permet l'envoi d'un fichier en upload, il est obligatoire, sinon on ne pourra envoyer le fichier image correspondant au produit -->
<form id="monForm" class="my-5" method="POST" action="" enctype="multipart/form-data">

    <input type="hidden" name="id_annonce " value="<?= $id_annonce  ?>">
    
    <div class="row mt-5">
        <!-- TITRE -->
        <div class="col-md-3">
            <label class="form-label" for="titre">
                <div class="badge badge-dark text-wrap">Titre</div>
            </label>
            <input class="form-control" type="text" name="titre" id="titre" placeholder="titre" value="<?= $titre ?>">
        </div>
        <!-- DESCRIPTION COURTE -->
        <div class="col-md-3">
            <label class="form-label" for="description_courte">
                <div class="badge badge-dark text-wrap">Description courte</div>
            </label>
            <input class="form-control" type="text" name="description_courte" id="description_courte" placeholder="Description courte"  value="<?= $description_courte ?>">
        </div>
        <!-- DESCRIPTION LONGUE -->
        <div class="col-md-6">
            <label class="form-label" for="description_longue">
                <div class="badge badge-dark text-wrap">Description longue</div>
            </label>
            <textarea class="form-control" name="description_longue" id="description_longue" placeholder="Description longue" rows="5"><?= $description_longue ?></textarea>
        </div>
    </div>

    <div class="row mt-5">
        <!-- PRIX -->
        <div class="col-md-4">
            <label class="form-label" for="prix">
                <div class="badge badge-dark text-wrap">Prix</div>
            </label>
            <input class="form-control" type="text" name="prix" id="prix" placeholder="Prix" value="<?= $prix ?>">
        </div>
        <!-- PHOTO -->
        <div class="col-md-4">
            <label class="form-label" for="photo">
                <div class="badge badge-dark text-wrap">Photo</div>
            </label>
            <input class="form-control" type="file" name="photo" id="photo" placeholder="Photo">
        </div>
    </div>

    <div class="row mt-5">
        <div class="row">
            <!-- PAYS -->
            <div class="col-md-4">
                <label class="form-label" for="pays">
                    <div class="badge badge-dark text-wrap">Pays</div>
                </label>
                <input class="form-control" type="text" name="pays" id="pays" placeholder="Photo">
            </div>
            <!-- VILLE -->
            <div class="col-md-4 mt-5">
                <label class="form-label" for="ville">
                    <div class="badge badge-dark text-wrap">Ville</div>
                </label>
                <input class="form-control" type="text" name="ville" id="ville"  placeholder="Ville" value="<?= $ville?>">
            </div>
            <!-- ADRESSE -->
            <div class="col-md-4 mt-5">
                <label class="form-label" for="adresse">
                    <div class="badge badge-dark text-wrap">Adresse</div>
                </label>
                <input class="form-control" type="text" name="adresse" id="adresse"  placeholder="Adresse" value="<?= $adresse?>">
            </div>
            <!-- CODE POSTAL -->
            <div class="col-md-4 mt-5">
                <label class="form-label" for="cp">
                    <div class="badge badge-dark text-wrap">Code Postal</div>
                </label>
                <input class="form-control" type="text" name="code_postal" id="cp"  placeholder="cp" value="<?= $codePostal?>">
            </div>
        </div>
    </div>
    <div class="col-md-1 mt-5">
        <button type="submit" class="btn btn-outline-dark btn-warning">Valider</button>
    </div>
</form>
<?php endif; ?>

<?php $queryProduits = $pdo->query(" SELECT id_annonce FROM annonce "); ?>
<h2 class="py-5 text-center">Nombre de produits en base de données: <?= $queryProduits->rowCount() ?></h2>

<div class="row justify-content-center py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-sm btn-outline-dark shadow rounded">
            <i class="bi bi-plus-circle-fill"></i> Ajouter un produit
        </button>
    </a>
</div>

<table class="table table-dark text-center">
    <!-- requete complétée pour n'afficher que 10 produits dans le tableau, le OFFSET détermine quel produit sera affiché en premier dans la nouvelle page -->

    <!-- ASC LIMIT $parPage OFFSET $premierProduit -->
    <?php $afficheProduits = $pdo->query("SELECT * FROM annonce ORDER BY date_enregistrement") ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $afficheProduits->columnCount(); $i++) :
                $colonne = $afficheProduits->getColumnMeta($i) ?>
                <th><?= $colonne['name'] ?></th>
            <?php endfor; ?>
            <th colspan=2>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($produit = $afficheProduits->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($produit as $key => $value) : ?>
                    <?php if ($key == 'prix') : ?>
                        <td><?= $value ?> €</td>
                    <?php elseif ($key == 'photo') : ?>
                        <td><img class="img-fluid" src="<?= URL . 'img/' . $value ?>" width="50" loading="lazy"></td>
                    <?php else : ?>
                        <td><?= $value ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td><a href='?action=update&id_produit=<?= $produit['id_produit'] ?>'><i class="bi bi-pen-fill text-warning"></i></a></td>
                <td><a data-href="?action=delete&id_produit=<?= $produit['id_produit'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger" style="font-size: 1.5rem;"></i></a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Début de pagination -->
<nav aria-label="">
    <ul class="pagination justify-content-end">
        <!-- dans la cas ou nous sommes sur la page 1, il ne faudra pas pouvoir cliquer sur l'onglet précedent, sinon, on sera expédié à la page 0 ! Il faut donc dans ce cas (voir la ternaire) si on est sur la page 1, que l'onglet soit non-cliquable, grace à la classe Bootstrap 'disabled' -->
        <li class="page-item">
        <!-- si on clique la fleche précédente, c'est pour aller à la page précédent
    dans ce cas, on soustrait à $pageCourante, la valeur de 1 (si pageCourante = 4, on retournera à la page 3) -->
            <a class="page-link text-dark" href="" aria-label="Previous">
                <span aria-hidden="true">précédente</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>

        <!-- affiche le nb de pages pour cliquer sur celle que l'on veut -->
        <?php //for($page = 1; $page <= $nombrePages; $page++): ?>
        <li class="mx-1 page-item">
            <a class="btn btn-outline-dark" href=""></a>
        </li>
        <?php //endfor; ?>
        <!-- fin affichage nb de pages -->

        <li class="page-item">
            <a class="page-link text-dark" href="" aria-label="Next">
                <span aria-hidden="true">suivante</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>
<!-- fin de pagination -->

<!-- <img class="img-fluid" src="" width="50"> -->

<!-- <td><a href=''><i class="bi bi-pen-fill text-warning"></i></a></td>-->
<!-- <td><a data-href="" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger" style="font-size: 1.5rem;"></i></a></td> -->

<!-- modal suppression codepen https://codepen.io/lowpez/pen/rvXbJq -->

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Supprimer article
            </div>
            <div class="modal-body">
                Etes-vous sur de vouloir retirer cet article de votre panier ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<!-- modal -->

<?php require_once('includeAdmin/footer.php'); ?>