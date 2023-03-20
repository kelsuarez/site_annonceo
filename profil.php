<?php
require_once('include/init.php');

$mesCategories = $pdo->query("SELECT * FROM categorie");

// REQUETTE PREPARE POUR RECUPERER LE NOMBRE D'ANNONCES
$id_membre = $_SESSION['membre']['id_membre'];
$stmt = $pdo->prepare("SELECT COUNT(*) FROM annonce WHERE membre_id = ?");
$stmt->execute([$id_membre]);
$nbAnnonces = $stmt->fetchColumn();
//echo debug($id_membre);// -> JE RECUPERE LE NOMBRE D'ANNONCES

// PAGE TITLE
$pageTitle = "Profil de " . $_SESSION['membre']['pseudo'];

// VERIF DE CONNEXION
if (!internauteConnecte()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

// MESSAGE DE CONNEXION
if (isset($_GET['action']) && $_GET['action'] == 'validate') {
    $validate .= '<div class="alert alert-success alert-dismissible fade show mt-5 col-5 mx-auto" role="alert">
                    Félicitations <strong>' . $_SESSION['membre']['pseudo'] . '</strong>, vous etes connecté 😉 !
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
}

// MESSAGE DE CREATION ANNONCE
if (isset($_GET['action']) && $_GET['action'] == 'ajoutfait') {
    $validate .= '<div class="alert alert-success alert-dismissible fade show mt-5 col-5 mx-auto" role="alert">
                    Félicitations <strong>' . $_SESSION['membre']['pseudo'] . '</strong>, votre annonce est en ligne !
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
}

// DECLARATION DE VARIABLES VIDES 
$id_annonce = "";
$titre = "";
$description_courte = "";
$description_longue = "";
$prix =  "";
$pays =  "";
$ville = "";
$adresse =  "";
$cp =  "";
$id_membre = $_SESSION['membre']['id_membre'];
$photo_id = "";
$categorie_id = "";
$photo_actuelle = "";

$photoBdd1 = "";
$photoBdd2 = "";
$photoBdd3 = "";
$photoBdd4 = "";
$photoBdd5 = "";

// if(isset($_GET['action']) && !empty($_POST)){

if(isset($_GET['action'])){

    if ($_POST){

        // TITRE
        if(!isset($_POST['titre']) || !preg_match('#^[a-zA-Z0-9 -_.éà\'è]{2,50}$#', $_POST['titre'])){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format titre !</div>';
        }
        // DESCRIPTION COURTE
            if(!isset($_POST['description_courte']) || iconv_strlen($_POST['description_courte']) <1 || iconv_strlen($_POST['description_courte']) > 200 ){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format description courte !</div>';
        }
        // DESCRIPTION LONGUE
        if(!isset($_POST['description_longue']) || iconv_strlen($_POST['description_longue']) <1 || iconv_strlen($_POST['description_longue']) > 500 ){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format description longue !</div>';
        }
        // PRIX
        if(!isset($_POST['prix']) || !preg_match('#^[0-9]{1,10}$#', $_POST['prix'])){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format code prix !</div>';
        }
        // CATEGORIE
        if(!isset($_POST['categorie'])){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format categorie !</div>';
        }
        // PHOTO
        if(isset($_FILES['fichier']) && $_FILES['fichier']['error'] == 0) {
            if ($_FILES['fichier']['size'] > $_POST['MAX_FILE_SIZE']) {
                echo "Le fichier téléchargé est trop volumineux.";
            }
            $allowed = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png');
            $filename = $_FILES['fichier']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!in_array($ext, $allowed)) {
                echo "Le type de fichier n'est pas autorisé.";
            }
        }
        // PAYS
        if(!isset($_POST['pays']) || iconv_strlen($_POST['pays']) < 3 || iconv_strlen($_POST['pays']) > 20 ){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pays !</div>';
        }
        // VILLE
        if(!isset($_POST['ville']) || strlen($_POST['ville']) < 2 || strlen($_POST['ville']) > 30 ){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format ville !</div>';
        }
        //ADRESSE
        if(!isset($_POST['adresse']) || strlen($_POST['adresse']) < 5 || strlen($_POST['adresse']) > 50 ){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format adresse !</div>';
        }
        // CODE POSTAL
        if(!isset($_POST['cp']) || !preg_match('#^[0-9]{5}$#', $_POST['cp'])){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format code postal !</div>';
        }
        // TRAITEMENT PHOTO
        $photoBdd = (!empty($_POST['photo_actuelle'])) ? $_POST['photo_actuelle'] : "";
        // if($_GET['action'] == 'update'){
        //     $photoBdd = $_POST['photo_actuelle'];
        // }

        if(!empty($_FILES['photo']['name'])){
            $photo_nom = uniqid() . '_' . $_FILES['photo']['name'];
            $photoBdd = "$photo_nom";
            $photoDossier = RACINE_SITE . "img/$photo_nom";
            if(is_uploaded_file($_FILES['photo']['tmp_name']) && file_exists(RACINE_SITE . "img/")){
                copy($_FILES['photo']['tmp_name'], $photoDossier);
            } else {
                echo "Une erreur est survenue lors du téléchargement du fichier.";
            }
        }
        // A VOIR POUR LES 5 AUTRES PHOTOS

        if(!empty($_FILES['photo1']['name'])){
            $photo_nom = uniqid() . '_' . $_FILES['photo1']['name'];
            $photoBdd1 = "$photo_nom";
            $photoDossier = RACINE_SITE . "img/$photo_nom";
            if(is_uploaded_file($_FILES['photo1']['tmp_name']) && file_exists(RACINE_SITE . "img/")){
                copy($_FILES['photo1']['tmp_name'], $photoDossier);
            } else {
                echo "Une erreur est survenue lors du téléchargement du fichier.";
            }
        }
        if(!empty($_FILES['photo2']['name'])){
            $photo_nom = uniqid() . '_' . $_FILES['photo2']['name'];
            $photoBdd2 = "$photo_nom";
            $photoDossier = RACINE_SITE . "img/$photo_nom";
            if(is_uploaded_file($_FILES['photo2']['tmp_name']) && file_exists(RACINE_SITE . "img/")){
                copy($_FILES['photo2']['tmp_name'], $photoDossier);
            } else {
                echo "Une erreur est survenue lors du téléchargement du fichier.";
            }
        }
        if(!empty($_FILES['photo3']['name'])){
            $photo_nom = uniqid() . '_' . $_FILES['photo3']['name'];
            $photoBdd3 = "$photo_nom";
            $photoDossier = RACINE_SITE . "img/$photo_nom";
            if(is_uploaded_file($_FILES['photo3']['tmp_name']) && file_exists(RACINE_SITE . "img/")){
                copy($_FILES['photo3']['tmp_name'], $photoDossier);
            } else {
                echo "Une erreur est survenue lors du téléchargement du fichier.";
            }
        }
        if(!empty($_FILES['photo4']['name'])){
            $photo_nom = uniqid() . '_' . $_FILES['photo4']['name'];
            $photoBdd4 = "$photo_nom";
            $photoDossier = RACINE_SITE . "img/$photo_nom";
            if(is_uploaded_file($_FILES['photo4']['tmp_name']) && file_exists(RACINE_SITE . "img/")){
                copy($_FILES['photo4']['tmp_name'], $photoDossier);
            } else {
                echo "Une erreur est survenue lors du téléchargement du fichier.";
            }
        }
        if(!empty($_FILES['photo5']['name'])){
            $photo_nom = uniqid() . '_' . $_FILES['photo5']['name'];
            $photoBdd5 = "$photo_nom";
            $photoDossier = RACINE_SITE . "img/$photo_nom";
            if(is_uploaded_file($_FILES['photo5']['tmp_name']) && file_exists(RACINE_SITE . "img/")){
                copy($_FILES['photo5']['tmp_name'], $photoDossier);
            } else {
                echo "Une erreur est survenue lors du téléchargement du fichier.";
            }
        }

        // REQUETTE DE SI PAS DE ERREUR ON PEUT CONTINUER
        if(empty($erreur)){
            
            // REQUETTE DE UPDATE
            if($_GET['action'] == 'update'){
                $modifAnnonce = $pdo->prepare("UPDATE annonce SET id_annonce = :id_annonce, titre = :titre, description_courte = :description_courte, description_longue = :description_longue, prix = :prix, pays = :pays, ville = :ville, adresse = :adresse, cp = :cp, categorie_id = :categorie_id, photo = :photo  WHERE id_annonce = :id_annonce");
                $modifAnnonce->bindValue(':id_annonce', $_POST['id_annonce'], PDO::PARAM_INT);
                $modifAnnonce->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':description_courte', $_POST['description_courte'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':description_longue', $_POST['description_longue'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':prix', $_POST['prix'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':cp', $_POST['cp'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':categorie_id', $_POST['categorie_id'], PDO::PARAM_STR);
                $modifAnnonce->bindValue(':photo', $photoBdd, PDO::PARAM_STR);
                $modifAnnonce->execute();

                // MESSAGE DE VALIDATION A L'ENVOI
                $queryAnnonce = $pdo->query("SELECT titre FROM annonce WHERE id_annonce = '$_GET[id_annonce]'");
                $annonce = $queryAnnonce->fetch(PDO::FETCH_ASSOC);
                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                                <strong>Félicitations !</strong> Modification de produit ' . $annonce['titre'] .  ' est réussie 😉!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
            }else{

                // REQUETTE DE INSERTION A LA BDD PHOTO
                $incluirePhoto = $pdo->prepare("INSERT INTO photo (photo1, photo2, photo3, photo4, photo5) VALUES (:photo1, :photo2, :photo3, :photo4, :photo5)");

                $incluirePhoto->bindParam(':photo1', $photoBdd1);
                $incluirePhoto->bindParam(':photo2', $photoBdd2);
                $incluirePhoto->bindParam(':photo3', $photoBdd3);
                $incluirePhoto->bindParam(':photo4', $photoBdd4);
                $incluirePhoto->bindParam(':photo5', $photoBdd5);
                $incluirePhoto->execute();

                $photo_id = $pdo->lastInsertId();

                // REQUETTE DE INSERTION A LA BDD ANNONCE
                $incluireAnnonce = $pdo->prepare("INSERT INTO annonce (titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, categorie_id, date_enregistrement, photo_id) VALUES (:titre, :description_courte, :description_longue, :prix, :photo, :pays, :ville, :adresse, :cp, :membre_id, :categorie_id, NOW(), :photo_id)");

                $incluireAnnonce->bindParam(':titre', $_POST['titre']);
                $incluireAnnonce->bindParam(':description_courte', $_POST['description_courte']);
                $incluireAnnonce->bindParam(':description_longue', $_POST['description_longue']);
                $incluireAnnonce->bindParam(':prix', $_POST['prix']);
                $incluireAnnonce->bindParam(':photo', $photoBdd);
                $incluireAnnonce->bindParam(':pays', $_POST['pays']);
                $incluireAnnonce->bindParam(':ville', $_POST['ville']);
                $incluireAnnonce->bindParam(':adresse', $_POST['adresse']);
                $incluireAnnonce->bindParam(':cp', $_POST['cp']);
                $incluireAnnonce->bindParam(':membre_id', $id_membre);
                $incluireAnnonce->bindParam(':photo_id', $photo_id);
                $incluireAnnonce->bindValue(':categorie_id', $_POST['categorie']);
                $incluireAnnonce->execute();
            }
        }
    }
    // REQUETTE DE UPDATE
    if($_GET['action'] == 'update'){
        $tousAnnonce = $pdo->query("SELECT * FROM annonce WHERE id_annonce = '$_GET[id_annonce]'");
        $annonceActuel = $tousAnnonce->fetch(PDO::FETCH_ASSOC);
    }

    // REQUETTE DE RECUPERATION DE BDD PAR APPORT A LES DONNES EN FORM
    $id_annonce = (isset($annonceActuel['id_annonce'])) ? $annonceActuel['id_annonce'] : "";
    $titre = (isset($annonceActuel['titre'])) ? $annonceActuel['titre'] : "";
    $description_courte = (isset($annonceActuel['description_courte'])) ? $annonceActuel['description_courte'] : "";
    $description_longue = (isset($annonceActuel['description_longue'])) ? $annonceActuel['description_longue'] : "";
    $prix = (isset($annonceActuel['prix'])) ? $annonceActuel['prix'] : "";
    $pays = (isset($annonceActuel['pays'])) ? $annonceActuel['pays'] : "";
    $ville = (isset($annonceActuel['ville'])) ? $annonceActuel['ville'] : "";
    $adresse = (isset($annonceActuel['adresse'])) ? $annonceActuel['adresse'] : "";
    $cp = (isset($annonceActuel['cp'])) ? $annonceActuel['cp'] : "";
    $id_membre = (isset($annonceActuel['membre_id'])) ? $annonceActuel['membre_id'] : "";
    $photo_id = (isset($annonceActuel['photo_id'])) ? $annonceActuel['photo_id'] : "";
    $photo_actuelle = (isset($annonceActuel['photo'])) ? $annonceActuel['photo'] : "";
    $categorie_id = (isset($annonceActuel['categorie_id'])) ? $annonceActuel['categorie_id'] : "";
    // A FAIRE -> PHOTO

    // REQUETTE POUR DELETE
    if($_GET['action'] == 'delete'){
        $pdo->query("DELETE FROM annonce WHERE id_annonce = '$_GET[id_annonce]'");
    } 
}

require_once('include/header.php');
?>

<?= $erreur ?>

    <!-- MESSAGE DE BIENVENUE  -->
    <h2 class="text-center my-5 display-5">
        <div class="p-3 text-underline">Bonjour <?= (internauteConnecteAdmin()) ? $_SESSION['membre']['prenom'] . ", vous etes admin du site" : $_SESSION['membre']['prenom'] ?></div>
    </h2>

    <!-- MESSAGE DE VALIDATION -->
    <?= $validate ?>

    <!-- INFORMATION PROFIL -->
    <div class="col-11 col-lg-4 text-center mx-auto">
        <ul class="list-group">
            <!-- PRENOM -->
                <div class="list-group">
                    <h3>Votre Prenom</h3>
                    <li class="btn btn-outline-success text-dark my-3 shadow bg-white rounded"><?= $_SESSION['membre']['prenom'] ?></li>
                </div>
            <!-- NOM -->
                <div class="list-group">
                    <h3>Votre Nom</h3>
                    <li class="btn btn-outline-success text-dark my-3 shadow bg-white rounded"><?= $_SESSION['membre']['nom'] ?></li>
                </div>
            <!-- PESUDO -->
                <div class="list-group">
                    <h3>Votre Pseudo</h3>
                    <li class="btn btn-outline-success text-dark my-3 shadow bg-white rounded"><?= $_SESSION['membre']['pseudo'] ?></li>
                </div>
            <!-- MAIL -->
                <div class="list-group">
                    <h3>Votre Email</h3>
                    <li class="btn btn-outline-success text-dark my-3 shadow bg-white rounded"><?= $_SESSION['membre']['email'] ?></li>
                </div>
            <!-- TELEPHONE -->
                <div class="list-group">
                    <h3>Votre Téléphone</h3>
                    <li class="btn btn-outline-success text-dark my-3 shadow bg-white rounded"><?= $_SESSION['membre']['telephone'] ?></li>
                </div>
        </ul>
    </div>

    <!-- BUTTON VOIR PROFIL -->
    <div class="col-3 mx-auto py-2 justify-content-center mb-5">
        <a href='modif_profil.php?action=profil&id_membre=<?= $id_membre = $_SESSION['membre']['id_membre']?>'>
            <button type="button" class="w-100 py-3 btn btn-sm btn-outline-success shadow rounded">
                <i class="bi bi-eye mr-1"></i>
                    Modifier mes informations
            </button>
        </a>
    </div>

    <!-- NOMBRE DE PRODUITS EN BDD -->
    <h2 class="text-center py-5">Mes annonces: <?= $nbAnnonces?></h2>

    <!-- BUTTONS AJO/VOIR ANNONCES -->
    <div class="d-lg-flex mx-auto col-lg-6">
        <!-- BUTTON VOIR ANNONCE -->
        <div class="col mx-auto py-2 justify-content-center">
            <a href='?action=see'>
                <button type="button" class="w-100 py-3 btn btn-sm btn-outline-success shadow rounded">
                    <i class="bi bi-eye mr-1"></i>
                    Voir mes annonces
                </button>
            </a>
        </div>

        <!-- BUTTON AJOUT ANNONCE -->
        <div class="col mx-auto py-2 justify-content-center">
            <a href='?action=add'>
                <button type="button" class="w-100 py-3 btn btn-sm btn-outline-success shadow rounded">
                    <i class="bi bi-plus-circle-fill"></i> 
                    Ajouter un annonce
                </button>
            </a>
        </div>
    </div>

    <!-- AFFICHAGE DE MON TABLEAU ANNONCE -->
    <?php if (isset($_GET['action']) && $_GET['action'] == 'see'): ?>
        <table class="table table-white text-center rounded-1 mt-5 col-11 mx-auto">
            <?php $afficheAnnonces = $pdo->query("SELECT * FROM annonce WHERE membre_id = $id_membre ORDER BY date_enregistrement DESC ");?>
            <thead class="col-12">
                <tr class="col-12">
                    <?php for($i = 0; $i < $afficheAnnonces->columnCount(); $i++):
                        $colonne = $afficheAnnonces->getColumnMeta($i); ?>
                        <?php if($colonne['name'] != 'membre_id' && $colonne['name'] != 'photo_id' && $colonne['name'] != 'categorie_id' && $colonne['name'] != 'id_annonce'): ?>
                            <th class=""><?= $colonne['name']?></th>
                        <?php endif; ?>
                    <?php endfor ;?>
                    <th colspan=2>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($annonce = $afficheAnnonces->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <?php foreach($annonce as $indice => $value): ?>
                        <?php if ($indice != 'membre_id' && $indice != 'photo_id' && $indice != 'categorie_id' && $indice != 'id_annonce'): ?>
                            <?php if($indice == 'prix'):?>
                                <td> <?php echo $value . '€' ?> </td>
                            <?php elseif($indice == 'photo'):?>
                                <td><img class="img-fluid" src="<?= URL . 'img/' . $value ?>" width="200" loading="lazy"></td>
                            <?php else:?>
                                <td> <?php echo $value ?> </td>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td><a href='?action=update&id_annonce=<?= $annonce['id_annonce']?>'><i class="bi bi-pencil-square" style="font-size: 1.5rem;"></i></a></td>
                    <td><a href='fiche_annonce.php?id_annonce=<?= $annonce['id_annonce'] ?>'><i class="bi bi-eye" style="font-size: 1.5rem;"></i></a></td>
                    <td><a data-href="?action=delete&id_annonce=<?= $annonce['id_annonce']?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash" style="font-size: 1.5rem;"></i></a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- FORMULAIRE ANNONCE -->
    <?php if (isset($_GET['action']) && $_GET['action'] == 'add') : ?>
        <h2 class="pt-5 text-center">Formulaire d'une annonce</h2>

        <form id="monForm" class="my-5 col-12 mx-auto" method="POST" action=""  enctype="multipart/form-data">

            <!-- INPUT HIDDEN -->
            <input type="hidden" name="id_annonce" value="<?= $id_annonce ?>">
            <input type="hidden" name="membre_id" value="<?= $id_membre ?>">
            <input type="hidden" name="photo_id" value="<?= $photo_id ?>">
            <!-- <input type="hidden" name="photo_actuelle" value="<?php //echo $photo_actuelle ?>"> -->
            <input type="hidden" name="categorie" value="<?= $categorie_id?>">

            <div class="d-md-flex mx-auto justify-content-center">

                <div class="col-md-6 mx-auto">

                    <!-- MODULE TITRE -->
                    <div class="col-md-10 mx-auto">
                        <label class="form-label" for="reference"><div class="badge badge-dark text-wrap">Titre</div></label>
                        <input class="form-control" type="text" name="titre" id="titre" placeholder="Titre" max-length="50" pattern="[a-zA-Z0-9 -_.éà\'è]{2,50}" title="caractères acceptés: majuscules et minuscules, chiffres, signes tels que: - _ . entre cinq et cinquante  caractères." value="<?= $titre?>" required>
                    </div>

                    <!-- MODULE DESCRIPTION COURTE -->
                    <div class="col-md-10 mt-4 mx-auto">
                        <label class="form-label" for="categorie"><div class="badge badge-dark text-wrap">Description courte</div></label>
                        <input class="form-control" type="text" name="description_courte" id="description_courte" placeholder="Description courte" max-length="100" pattern="[a-zA-Z0-9-_.éà\'è]{5,100}" title="caractères acceptés: majuscules et minuscules, chiffres, signes tels que: - _ . entre cinq et cent caractères." value="<?= $description_courte?>" required>
                    </div>

                    <!-- MODULE DESCRIPTION LONGUE -->
                    <div class="col-md-10 mt-4 mx-auto">
                            <label class="form-label" for="description_longue"><div class="badge badge-dark text-wrap">Description longue</div></label>
                            <textarea class="form-control" name="description_longue" id="description_longue" placeholder="Description longue" rows="5"><?= $description_longue?></textarea>
                    </div>

                    <!-- MODULE PRIX -->
                    <div class="col-md-10 mt-4 mx-auto">
                        <label class="form-label" for="prix"><div class="badge badge-dark text-wrap">Prix</div></label>
                        <input class="form-control" type="text" name="prix" id="prix" placeholder="Prix" max-length="5" pattern="[0-9]{1,10}" title="caractères acceptés: chiffres entre un et cinq caractères." value="<?= $prix?>" required>
                    </div>

                    <!-- MODULE CATEGORIE -->
                    <div class="col-md-10 mt-4 mx-auto">
                        <label class="badge badge-dark text-wrap" for="categorie">Categorie</label>
                        <select class="form-control" name="categorie" id="categorie">
                            <option value="" selected hidden>Choisir une catégories</option>
                            <?php while ($categorie = $mesCategories->fetch(PDO::FETCH_ASSOC)) : ?>
                                <option value="<?= $categorie['id_categorie']?>"><?= $categorie['titre'] . " | ". $categorie['motscles'] ?></option>
                                <?php //$categorie_id = $categorie['id_categorie'];?>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mx-auto">
                    <!-- MODULE PHOTO -->
                    <div class="col-md-10 mt-4 mx-auto">
                        <label class="form-label" for="photo"><div class="badge badge-dark text-wrap">Photo Principale</div></label>
                        <input class="form-control" type="file" name="photo" id="photo" placeholder="Photo Principale">
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
                        <label class="form-label" for="cp"><div class="badge badge-dark text-wrap">Code Postal</div></label>
                        <input class="form-control" type="text" name="cp" id="cp" placeholder="Votre code postal">
                    </div>
                </div>
            </div>
            <div>
                <div class="col-md-12 mt-4 mx-auto">
                    <div class="d-lg-flex mx-auto">
                        <div>
                            <label for="photo1">Photo 1:</label>
                            <input type="file" name="photo1" id="photo1"><br>
                        </div>
                        <div>
                            <label for="photo2">Photo 2:</label>
                            <input type="file" name="photo2" id="photo2"><br>
                        </div>
                        <div>
                            <label for="photo3">Photo 3:</label>
                            <input type="file" name="photo3" id="photo3"><br>
                        </div>
                        <div>
                            <label for="photo4">Photo 4:</label>
                            <input type="file" name="photo4" id="photo4"><br>
                        </div>
                        <div>
                            <label for="photo5">Photo 5:</label>
                            <input type="file" name="photo5" id="photo5"><br>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BUTTON VALIDER -->
            <div class="col-md-6 mx-auto mt-5">
                <a href="?action=ajoutfait">
                    <button type="submit" class="btn btn-outline-dark btn-success w-100">Valider</button>
                </a>
            </div>
            <?= debug($erreur) ?>
        </form>
    <?php endif; ?>


    <!-- && $_GET['action'] == 'add' -->
    <!-- $_GET['action'] == 'update' -->
    
    <!-- FORMULAIRE -->
    <?php if(isset($_GET['action']) && $_GET['action'] == 'update'): ?>

    <h2 class="my-5 text-center"><u>Formulaire de modification des annonces</u></h2>

    <form id="monForm" class="my-5 col-12 mx-auto" method="POST" action="" enctype="multipart/form-data">

        <input type="hidden" name="id_annonce" value="<?= $id_annonce  ?>">
        <input type="hidden" name="membre_id" value="<?= $id_membre?>">
        <input type="hidden" name="photo_id" value="<?= $photo_id?>">
        <input type="hidden" name="categorie_id" value="<?= $categorie_id  ?>">

        <div class="d-flex mx-auto mt-5">
            <!-- TITRE -->
            <div class="col-md-4 mx-auto">
                <label class="form-label" for="titre">
                    <div class="badge badge-dark text-wrap">Titre</div>
                </label>
                <input class="form-control" type="text" name="titre" id="titre" placeholder="titre" value="<?= $titre ?>">
            </div>
            <!-- DESCRIPTION COURTE -->
            <div class="col-md-4 mx-auto">
                <label class="form-label" for="description_courte">
                    <div class="badge badge-dark text-wrap">Description courte</div>
                </label>
                <input class="form-control" type="text" name="description_courte" id="description_courte" placeholder="Description courte"  value="<?= $description_courte ?>">
            </div>
            <!-- DESCRIPTION LONGUE -->
            <div class="col-md-4 mx-auto">
                <label class="form-label" for="description_longue">
                    <div class="badge badge-dark text-wrap">Description longue</div>
                </label>
                <textarea class="form-control" name="description_longue" id="description_longue" placeholder="Description longue" rows="5"><?= $description_longue ?></textarea>
            </div>
        </div>

        <div class="d-flex mx-auto mt-5">
                <!-- PAYS -->
                <div class="col-md-4 mx-auto mt-5">
                    <label class="form-label" for="pays">
                        <div class="badge badge-dark text-wrap">Pays</div>
                    </label>
                    <input class="form-control" type="text" name="pays" id="pays" placeholder="Pays" value="<?= $pays?>">
                </div>
                <!-- VILLE -->
                <div class="col-md-4 mx-auto mt-5">
                    <label class="form-label" for="ville">
                        <div class="badge badge-dark text-wrap">Ville</div>
                    </label>
                    <input class="form-control" type="text" name="ville" id="ville"  placeholder="Ville" value="<?= $ville?>">
                </div>
                <!-- ADRESSE -->
                <div class="col-md-4 mx-auto mt-5">
                    <label class="form-label" for="adresse">
                        <div class="badge badge-dark text-wrap">Adresse</div>
                    </label>
                    <input class="form-control" type="text" name="adresse" id="adresse"  placeholder="Adresse" value="<?= $adresse?>">
                </div>
        </div>

        <div class="d-flex mx-auto mt-5">
            <!-- CODE POSTAL -->
            <div class="col-md-4 mt-5">
                    <label class="form-label" for="cp">
                        <div class="badge badge-dark text-wrap">Code Postal</div>
                    </label>
                    <input class="form-control" type="text" name="cp" id="cp"  placeholder="cp" value="<?= $cp?>">
                </div>
            <!-- PRIX -->
            <div class="col-md-4 mt-5">
                <label class="form-label" for="prix">
                    <div class="badge badge-dark text-wrap">Prix</div>
                </label>
                <input class="form-control" type="text" name="prix" id="prix" placeholder="Prix" value="<?= $prix ?>">
            </div>
        </div>

        <div class="d-flex mx-auto mt-5">
            <!-- PHOTO -->
            <div class="col-md-4 mt-5">
                <label class="form-label" for="photo">
                    <div class="badge badge-dark text-wrap">Photo Affiche</div>
                </label>
                <input class="form-control" type="file" name="photo" id="photo" placeholder="Photo">
            </div>
            <?php if(!empty($photo_actuelle)): ?>
                <div class="mt-4">
                    <p>Vous pouvez changer d'image
                        <img src="<?= URL . 'img/' . $photo_actuelle ?>" width="50px">
                    </p>
                </div>
            <?php endif; ?>
            <input type="hidden" name="photo_actualle" value="<?php $photo ?>">
            <!-- CATEGORIE -->
            <div class="col-md-4 mt-5">
                <label class="badge badge-dark text-wrap" for="categorie">Categorie</label>
                <select class="form-control" name="categorie" id="categorie">
                    <option value="" selected hidden>Choisir une catégories</option>
                    <?php while ($categorie = $mesCategories->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value="<?= $categorie['id_categorie']?>"><?= $categorie['titre'] . " | ". $categorie['motscles'] ?></option>
                        <?php //$categorie_id = $categorie['id_categorie'];?>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <!-- VALIDATION -->
        <div class="col-md-3 mt-5 mx-auto">
            <button type="submit" class="btn btn-outline-dark btn-success w-100 text-white">Valider</button>
        </div>

    </form>
    <?php endif; ?>

<?php require_once('include/footer.php') ?>














