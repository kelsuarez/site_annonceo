<?php
require_once('include/init.php');

//REQUETE POUR RECUPERER TOUT 
if(!empty($_GET['id_annonce'])) {

    $recup_annonce = $pdo->prepare("SELECT annonce.*, membre.*, categorie.titre AS titre_categorie FROM annonce, categorie, membre WHERE id_membre = membre_id AND id_categorie = categorie_id AND id_annonce = :id_annonce");
    $recup_annonce->bindParam(':id_annonce', $_GET['id_annonce']);
    $recup_annonce->execute();

    // POUR RECUPERER LES PHOTOS
    if($recup_annonce->rowCount() > 0) {
        $infos_annonce = $recup_annonce->fetch(PDO::FETCH_ASSOC);

        $liste_photos_annexes = $pdo->prepare("SELECT * FROM photo WHERE id_photo = :id_photo");
        $liste_photos_annexes->bindParam(':id_photo', $infos_annonce['photo_id']);
        $liste_photos_annexes->execute();

        $infos_photos_annexes = $liste_photos_annexes->fetch(PDO::FETCH_ASSOC);
    } else {
        header('location:index.php');
    }

} else {
    header('location:index.php');
}

// $recup_commentaire = $pdo->query("SELECT * FROM commentaire");
if(internauteConnecte()){
    $id_membre = $_SESSION['membre']['id_membre'];
}
// $id_membre = $_SESSION['membre']['id_membre'];
$id_annonce = $infos_annonce['id_annonce'];
$membre_id2 = $infos_annonce['membre_id'];

// TITLE PAGE
$pageTitle = $infos_annonce['titre'];

    if ($_POST){
        // COMMENTAIRE
        if(!isset($_POST['commentaire']) || iconv_strlen($_POST['commentaire']) <1 || iconv_strlen($_POST['commentaire']) > 500 ){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format commentaire !</div>';
        }
        // RANKING
        if(!isset($_POST['note']) || $_POST['note'] != '1' && $_POST['note'] != '2' && $_POST['note'] != '3' && $_POST['note'] != '4' && $_POST['note'] != '5'){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format note !</div>';
        }

        if(empty($erreur)){
            // if($_GET['action'] == 'envoyer'){
                $laisserCommentaire = $pdo->prepare("INSERT INTO commentaire (membre_id, annonce_id, commentaire, date_enregistrement) VALUES (:membre_id, :annonce_id, :commentaire, NOW())");

                $laisserCommentaire->bindParam(':membre_id', $id_membre);
                $laisserCommentaire->bindParam(':annonce_id', $id_annonce);
                $laisserCommentaire->bindParam(':commentaire', $_POST['commentaire']);
                $laisserCommentaire->execute();

                $laisserNote = $pdo->prepare("INSERT INTO note (membre_id1, membre_id2, note, date_enregistrement) VALUES (:membre_id1, :membre_id2, :note, NOW())");

                $laisserNote->bindParam(':membre_id1', $id_membre);
                $laisserNote->bindParam(':membre_id2', $membre_id2);
                $laisserNote->bindParam(':note', $_POST['note']);
                // $laisserNote->bindParam(':avis', $_POST['avis']);
                $laisserNote->execute();
            // }else{

            // }
        }
    }

// REQUETE RECUP COMMENTAIRE
$id_annonce = $_GET['id_annonce'];
$req_commentaires = $pdo->prepare("SELECT commentaire.*, membre.* FROM commentaire, membre WHERE annonce_id = :id_annonce AND id_membre = membre_id");
$req_commentaires->execute(array('id_annonce' => $id_annonce));
$commentaires = $req_commentaires->fetchAll(PDO::FETCH_OBJ);



$commentaire = "";










require_once('include/affichage.php');
require_once('include/header.php');
?>

<?= $erreur?>

<!-- FICHE ANNONCES -->
<div class="col-10 mx-auto mt-5">
    <div class="d-lg-flex">
        <div class="col-lg-6">
            <img class="img-fluid mx-auto img_annonce_principal" id="image-principale" src="<?= URL . 'img/' . $infos_annonce['photo'] ?>" loading="lazy" alt="image de annonce avec le titre <?=$infos_annonce['titre']?>">
        </div>
        <div class="col-lg-6 text-center mx-auto">
            <h1 class="display-lg-2 mt-2 text-uppercase"><?= $infos_annonce['titre'] ?></h1>
            <h2 class="mt-2"><?= $infos_annonce['description_courte'] ?></h2>
            <h3 class="display-lg-4 mt-4">Prix : <?= $infos_annonce['prix'] . " €"?></h3>
        </div>
    </div>
    <div class="d-lg-flex col-11 mt-5">
        <div class="mx-auto">
            <img class="img-fluid mx-auto mr-2 mt-2 control_images_annonce" src="<?= URL . 'img/' . $infos_photos_annexes['photo1'] ?>" loading="lazy" onclick="changerImagePrincipale('<?= URL . 'img/' . $infos_photos_annexes['photo1'] ?>')" alt="image de annonce avec le titre <?=$infos_annonce['titre']?>">
            <img class="img-fluid mx-auto mr-2 mt-2 control_images_annonce" src="<?= URL . 'img/' . $infos_photos_annexes['photo2'] ?>" loading="lazy" onclick="changerImagePrincipale('<?= URL . 'img/' . $infos_photos_annexes['photo2'] ?>')" alt="image de annonce avec le titre <?=$infos_annonce['titre']?>">
            <img class="img-fluid mx-auto mr-2 mt-2 control_images_annonce" src="<?= URL . 'img/' . $infos_photos_annexes['photo3'] ?>" loading="lazy" onclick="changerImagePrincipale('<?= URL . 'img/' . $infos_photos_annexes['photo3'] ?>')" alt="image de annonce avec le titre <?=$infos_annonce['titre']?>">
            <img class="img-fluid mx-auto mr-2 mt-2 control_images_annonce" src="<?= URL . 'img/' . $infos_photos_annexes['photo4'] ?>" loading="lazy" onclick="changerImagePrincipale('<?= URL . 'img/' . $infos_photos_annexes['photo4'] ?>')" alt="image de annonce avec le titre <?=$infos_annonce['titre']?>">
            <img class="img-fluid mx-auto mt-2 control_images_annonce" src="<?= URL . 'img/' . $infos_photos_annexes['photo5'] ?>" loading="lazy" onclick="changerImagePrincipale('<?= URL . 'img/' . $infos_photos_annexes['photo5'] ?>')" alt="image de annonce avec le titre <?=$infos_annonce['titre']?>">
        </div>
    </div>
    <div class="d-lg-flex mt-5 mx-auto">
        <div class="col-lg-6 text-center">
            <h3 class="display-lg-4 mt-4 mx-auto">Categorie : <?= $infos_annonce['titre_categorie']?></h3>
        </div>
        <div class="col-lg-5 mx-auto py-4">
            <a href="?action=call" data-toggle="modal" data-target="#contact-user">
                <button type="button" class="btn btn-sm btn-outline-dark btn-warning rounded w-100 p-3">
                    <i class="bi bi-telephone-outbound mr-2"></i> Contacter le vendeur : <?= $infos_annonce['prenom']?>
                </button>
            </a>
        </div>
    </div>
    <div class="mt-5 d-lg-flex">
        <h3 class="col-lg-4 mx-auto">Adresse : <?= $infos_annonce['adresse'] . " "?></h3>
        <h3 class="col-lg-4 mx-auto">Ville : <?=$infos_annonce['ville']?></h3>
        <h3 class="col-lg-2 mx-auto">Code postal : <?= $infos_annonce['cp']?></h3>
        <h3 class="col-lg-2 mx-auto">Pays : <?= $infos_annonce['pays']?></h3>
    </div>

    <div class="mt-5 col-lg-8 mx-auto">
        <?php $maps_url = "https://www.google.com/maps/embed/v1/place?key=AIzaSyBLcuhwrabaBuFJuRsgPkTSqyA3leXSmVY&zoom=15&q=" . urlencode($infos_annonce['adresse'] . ' ' . $infos_annonce['ville'] . ' ' . $infos_annonce['cp']); ?>
        <iframe src="<?= $maps_url ?>" class="iframeMap" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <div class="mx-auto">
        <h3 class="display-lg-4 col-lg-10 text-center mx-auto mt-5 text-underline"><u>Description de l'article</u></h3>
        <h4 class="col-lg-11 mx-auto mt-5"><?= $infos_annonce['description_longue'] ?></h4>
    </div>

</div>

<!-- FORMULAIRE DE COMMENTAIRE + NOTE -->
<?php if(internauteConnecte()):?>
<div class="col-lg-md-5 mx-auto mt-5">
    <h3 class="text-center">Laisser un commentaire</h3>

    <div class="">
        <form action="" method="post">

            <input type="hidden" id="<?= $id_membre?>" name="id_membre" value="<?= $id_membre ?>">
            <input type="hidden" id="<?= $id_annonce?>" name="id_annonce" value="<?= $id_annonce ?>">

            <div class="col-lg-2 text-center mx-auto mt-5">
                <label for="pseudo"><h3>Pseudo : <?= $_SESSION['membre']['pseudo'] ?></h3></label>
            </div>

            <div class="col-lg-10 text-center mx-auto mt-5">
                <label for="commentaire"><h3>Commentaire :</h3></label>
                <textarea class="col-6" id="commentaire" name="commentaire" rows="4" required value="commentaire"></textarea>
            </div>

            <div class="col-md-4 mt-5 text-center mx-auto pt-2">
                <h3 class="mx-auto text-wrap">NOTE</h3> 
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="note" id="note1" value="1">
                        <label class="form-check-label mx-2" for="note1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="note" id="note2" value="2" checked>
                        <label class="form-check-label mx-2" for="note2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="note" id="note3" value="3" checked>
                        <label class="form-check-label mx-2" for="note3">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="note" id="note4" value="4" checked>
                        <label class="form-check-label mx-2" for="note4">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="note" id="note5" value="5" checked>
                        <label class="form-check-label mx-2" for="note5">5</label>
                    </div>
                </div>
            </div>

            <div class="text-center mx-auto">
                <input class="col-10 col-lg-2 mx-auto mt-5" type="submit" value="envoyer">
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<!-- AFFICHAGE DE COMMENTAIRES -->
<div class="col-md-5 mx-auto mt-5">
    <h3 class="text-center mb-5">Commentaires</h3>
    <?php foreach ($commentaires as $commentaire) : ?>
        <div>
            <h5><?= $commentaire->pseudo ?></h5>
            <p>Commentaire: <?= $commentaire->commentaire ?></p>
            <p><?= $commentaire->date_enregistrement ?></p>
        </div>
    <?php endforeach; ?>
</div>

<!-- MODAL DE SUP/MDF-->
<div class="modal fade" id="contact-user" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mx-auto">
                Contacter : <?= $infos_annonce['prenom'] ?>
            </div>
            <div class="modal-body mx-auto mt-5">
                Téléphone : <?= $infos_annonce['telephone']?>
            </div>
            <div class="modal-body mx-auto">
                Email : <?= $infos_annonce['email']?>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer mx-auto">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


        <div class="col-md-12">
            <?php //echo '<pre>'; print_r($infos_annonce); echo '</pre>'; ?>
            <?php //echo '<pre>'; var_dump($infos_photos_annexes); echo '</pre>'; ?>
        </div>


    <?php require_once('include/footer.php') ?>