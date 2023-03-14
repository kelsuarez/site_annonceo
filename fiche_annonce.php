<?php
require_once('include/init.php');

// code a venir

// récupération de l'annonce

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

$recup_commentaire = $pdo->query("SELECT * FROM commentaire");


require_once('include/affichage.php');
require_once('include/header.php');
?>

</div>

<div class="col-11 mx-auto mt-5">
    <div class="d-flex">
        <div class="col-6">
            <img class="img-fluid" id="image-principale" src="<?= URL . 'img/' . $infos_annonce['photo'] ?>" max-width="800" loading="lazy">
        </div>
        <div class="col-6 text-center mx-auto">
            <h1 class="display-2 text-uppercase"><?= $infos_annonce['titre'] ?></h1>
            <h2><?= $infos_annonce['description_courte'] ?></h2>
            <h3 class="display-4 mt-4">Prix : <?= $infos_annonce['prix']?></h3>
        </div>
    </div>
    <div class="d-flex mt-5">
        <div class="mx-auto">
            <img class="img-fluid mr-5" src="<?= URL . 'img/' . $infos_photos_annexes['photo1'] ?>" width="250" loading="lazy" onclick="changerImagePrincipale('<?= URL . 'img/' . $infos_photos_annexes['photo1'] ?>')">
            <img class="img-fluid mr-5" src="<?= URL . 'img/' . $infos_photos_annexes['photo2'] ?>" width="250" loading="lazy" onclick="changerImagePrincipale('<?= URL . 'img/' . $infos_photos_annexes['photo2'] ?>')">
            <img class="img-fluid mr-5" src="<?= URL . 'img/' . $infos_photos_annexes['photo3'] ?>" width="250" loading="lazy" onclick="changerImagePrincipale('<?= URL . 'img/' . $infos_photos_annexes['photo3'] ?>')">
            <img class="img-fluid mr-5" src="<?= URL . 'img/' . $infos_photos_annexes['photo4'] ?>" width="250" loading="lazy" onclick="changerImagePrincipale('<?= URL . 'img/' . $infos_photos_annexes['photo4'] ?>')">
            <img class="img-fluid" src="<?= URL . 'img/' . $infos_photos_annexes['photo5'] ?>" width="250" loading="lazy" onclick="changerImagePrincipale('<?= URL . 'img/' . $infos_photos_annexes['photo5'] ?>')">
        </div>
    </div>
    <div class="d-flex mt-5 mx-auto">
        <div class="col-6 d-flex text-center">
            <h3 class="display-4 mt-4 mx-auto">Categorie : <?= $infos_annonce['titre_categorie']?></h3>
        </div>
        <div class="col-5 mx-auto py-4">
            <a href="?action=call" data-toggle="modal" data-target="#contact-user">
                <button type="button" class="btn btn-sm btn-outline-dark btn-warning rounded w-100 p-3">
                    <i class="bi bi-telephone-outbound mr-2"></i> Contacter le vendeur : <?= $infos_annonce['prenom']?>
                </button>
            </a>
        </div>
    </div>
    <div class="mt-5 d-flex">
        <h3 class="col-4 mx-auto">Adresse : <?= $infos_annonce['adresse'] . " "?></h3>
        <h3 class="col-4 mx-auto">Ville : <?=$infos_annonce['ville']?></h3>
        <h3 class="col-2 mx-auto">Code postal : <?= $infos_annonce['cp']?></h3>
        <h3 class="col-2 mx-auto">Pays : <?= $infos_annonce['pays']?></h3>
    </div>
    <div class="mx-auto">
        <h3 class="display-4 col-10 text-center mx-auto mt-5 text-underline"><u>Description de l'article</u></h3>
        <h4 class="col-11 mx-auto mt-5"><?= $infos_annonce['description_longue'] ?></h4>
    </div>
</div>


<!-- MODAL DE SUP/MDF-->
<div class="modal fade" id="contact-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

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





<div>


        <div class="col-md-12">
            <?php echo '<pre>'; print_r($infos_annonce); echo '</pre>'; ?>
            <?php echo '<pre>'; var_dump($infos_photos_annexes); echo '</pre>'; ?>
        </div>


    <?php require_once('include/footer.php') ?>