<?php
require_once('include/init.php');

// TITLE PAGE
$pageTitle = "Déposer annonce";

// REDIRECTION SI USER NON CONNECTE
if(!internauteConnecte()){
    header('location:' . URL . 'connexion.php');
}
$titre = "";
$description_courte ="";
$description_longue = "";
$prix = "";
$categorie = "";
$photo = "";
$pays = "";
$ville = "";
$adresse = "";
$cp	= "";
$membre_id = "";
$photo_id = "";
$categorie_id = "";
$date_enregistrement = "";

require_once('include/header.php');
?>

<?= $erreur ?>

    <h2 class="text-center py-5 col-3 mx-auto">
        <div class="badge badge-info text-wrap p-3 w-100">Déposer une annonce</div>
    </h2>

    <!-- FORMULAIRE -->
    <?php //if(isset($_GET['action'])): ?>

        <h2 class="pt-5 text-center">Formulaire d'une annonce</h2>

        <form id="monForm" class="my-5 col-12 mx-auto" method="POST" action=""  enctype="multipart/form-data">

            <!-- INPUT HIDDEN -->
        <div class="d-md-flex mx-auto justify-content-center">
            <div class="col-md-6 mx-auto">
                <!-- MODULE TITRE -->
                <div class="col-md-10 mx-auto">
                    <label class="form-label" for="reference"><div class="badge badge-dark text-wrap">Titre</div></label>
                    <input class="form-control" type="text" name="titre" id="titre"  placeholder="Titre" value="<?= $titre?>">
                </div>
                <!-- MODULE DESCRIPTION COURTE -->
                <div class="col-md-10 mt-4 mx-auto">
                    <label class="form-label" for="categorie"><div class="badge badge-dark text-wrap">Description courte</div></label>
                    <input class="form-control" type="text" name="description_courte" id="description_courte"  placeholder="Description courte" value="<?= $description_courte?>">
                </div>
                <!-- MODULE DESCRIPTION LONGUE -->
                <div class="col-md-10 mt-4 mx-auto">
                    <label class="form-label" for="categorie"><div class="badge badge-dark text-wrap">Description courte</div></label>
                    <input class="form-control" type="text" name="description_courte" id="description_courte"  placeholder="Description courte" value="<?= $description_courte?>">
                </div>
                <!-- MODULE PRIX -->
                <div class="col-md-10 mt-4 mx-auto">
                    <label class="form-label" for="prix"><div class="badge badge-dark text-wrap">Prix</div></label>
                    <input class="form-control" type="text" name="prix" id="prix"  placeholder="Prix" value="<?= $prix?>">
                </div>
                <!-- MODULE COULEUR -->
                <div class="col-md-10 mt-4 mx-auto">
                    <label class="badge badge-dark text-wrap" for="couleur">Categorie</label>
                    <select class="form-control" name="couleur" id="couleur">
                        <option value="" class="bg-dark text-light" disabled="disabled">Choisissez</option>
                        <option class="bg-dark text-light" value="Emploi" <?= ($categorie == "Emploi") ? 'selected' : "" ?>>Emploi</option>
                        <option class="bg-dark text-light" value="Véhicule" <?= ($categorie == "Véhicule") ? 'selected' : "" ?>>Véhicule</option>
                        <option class="bg-dark text-light" value="Immobilier" <?= ($categorie == "Immobilier") ? 'selected' : "" ?>>Immobilier</option>
                        <option class="bg-dark text-light" value="Vacances" <?= ($categorie == "Vacances") ? 'selected' : "" ?>>Vacances</option>
                        <option class="bg-dark text-light" value="Multimedia" <?= ($categorie == "Multimedia") ? 'selected' : "" ?>>Multimedia</option>
                        <option class="bg-dark text-light" value="Loisir" <?= ($categorie == "Loisir") ? 'selected' : "" ?>>Loisir</option>
                        <option class="bg-dark text-light" value="Materiel" <?= ($categorie == "Materiel") ? 'selected' : "" ?>>Materiel</option>
                        <option class="bg-dark text-light" value="Services" <?= ($categorie == "Services") ? 'selected' : "" ?>>Services</option>
                        <option class="bg-dark text-light" value="Maison" <?= ($categorie == "Maison") ? 'selected' : "" ?>>Maison</option>
                        <option class="bg-dark text-light" value="Vetements" <?= ($categorie == "Vetements") ? 'selected' : "" ?>>Vetements</option>
                        <option class="bg-dark text-light" value="Autres" <?= ($categorie == "Autres") ? 'selected' : "" ?>>Autres</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mx-auto">
                <!-- MODULE PHOTO -->
                <div class="col-md-12 mt-4 mx-auto">
                    <div class="d-flex mx-auto">
                        <label for="photo1">Photo 1:</label>
                        <label for="photo2">Photo 2:</label>
                        <label for="photo3">Photo 3:</label>
                        <label for="photo4">Photo 4:</label>
                        <label for="photo5">Photo 5:</label>
                    </div>
                    <div class="d-flex mx-auto">
                        <input type="file" name="photo1" id="photo1"><br>
                        <input type="file" name="photo2" id="photo2"><br>
                        <input type="file" name="photo3" id="photo3"><br>
                        <input type="file" name="photo4" id="photo4"><br>
                        <input type="file" name="photo5" id="photo5"><br>
                    </div>
                </div>
                <!-- MODULE PAYS -->
                <div class="col-md-10 mt-4 mx-auto">
                    <label class="form-label" for="pays">
                        <div class="badge badge-dark text-wrap">Pays</div>
                    </label>
                    <input class="form-control" type="text" name="pays" id="pays" placeholder="Votre pays">
                </div>
                <!-- MODULE VILLE -->
                <div class="col-md-10 mt-4 mx-auto">
                    <label class="form-label" for="ville"><div class="badge badge-dark text-wrap">Ville</div></label>
                    <input class="form-control" type="text" name="ville" id="ville" placeholder="Votre ville">
                </div>
                <!-- MODULE ADRESSE -->
                <div class="col-md-10 mt-4 mx-auto">
                    <label class="form-label" for="adresse"><div class="badge badge-dark text-wrap">Adresse</div></label>
                    <input class="form-control" type="text" name="adresse" id="adresse" placeholder="Votre adresse">
                </div>
                <!-- MODULE CODE POSTAL -->
                <div class="col-md-10 mt-4 mx-auto">
                    <label class="form-label" for="code_postal"><div class="badge badge-dark text-wrap">Code Postal</div></label>
                    <input class="form-control" type="text" name="code_postal" id="code_postal" placeholder="Votre code postal">
                </div>
            </div>
        </div>
        <!-- BUTTON VALIDER -->
        <div class="col-md-6 mx-auto mt-5">
            <button type="submit" class="btn btn-outline-dark btn-success w-100">Valider</button>
        </div>
    <?php //endif; ?>