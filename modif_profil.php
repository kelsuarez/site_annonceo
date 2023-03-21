<?php
require_once('include/init.php');

// VERIF DE CONNEXION
if (!internauteConnecte()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

if (!isset($_SESSION['membre'])) {
    // Rediriger l'utilisateur vers la page de connexion
    header('Location: ' . URL . 'connexion.php');
    exit();
}

if ($_SESSION['membre']['id_membre'] != $_GET['id_membre']) {
// Rediriger l'utilisateur vers une page d'erreur ou la page d'accueil
header('Location: ' . URL . 'erreur.php');
exit();
}

$success = "";

// MEMBRE
if (isset($_GET['action'])) {

    if ($_POST) {

        // NOM
        if (!isset($_POST['nom']) || iconv_strlen($_POST['nom']) < 3 || iconv_strlen($_POST['nom']) > 20) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format nom !</div>';
        }
        // PRENOM
        if (!isset($_POST['prenom']) || iconv_strlen($_POST['prenom']) < 3 || iconv_strlen($_POST['prenom']) > 20) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format prénom !</div>';
        }
        // TELEPHONE 
        if(!isset($_POST['telephone']) || !preg_match('#^[0-9]{1,10}$#', $_POST['telephone'])){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format telephone !</div>';
        }
        // EMAIL
        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format email !</div>';
        }
        // CIVILITE
        if (!isset($_POST['civilite']) || $_POST['civilite'] != 'femme' && $_POST['civilite'] != 'homme') {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format civilité !</div>';
        }

        if (empty($erreur)) {
            // mdp = :mdp, pseudo = :pseudo,

            // si dans l'URL action == update, on entame une procédure de modification
            if ($_GET['action'] == 'profil') {
                $modifUser = $pdo->prepare(" UPDATE membre SET id_membre = :id_membre, nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, civilite = :civilite WHERE id_membre = :id_membre ");
                $modifUser->bindValue(':id_membre', $_POST['id_membre'], PDO::PARAM_INT);
                // $modifUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $modifUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $modifUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $modifUser->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_STR);
                $modifUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $modifUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
                // $modifUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
                $modifUser->execute();
        
                // pour personnaliser le message de réussite, je dois récupérer le pseudo de l'utilisateur modifié en BDD, pour personnaliser le message
                $queryUser = $pdo->query(" SELECT pseudo FROM membre WHERE id_membre = '$_GET[id_membre]' ");
                $user = $queryUser->fetch(PDO::FETCH_ASSOC);
        
                $success = '<div class="text-center alert alert-success alert-dismissible fade show mt-5" role="alert">
                            <strong>Félicitations !</strong> Votre modification de profil '. $user['pseudo'] .' a bien été pris en compte!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="col-md-2 mx-auto text-center">
                            <a href="profil.php" class="btn btn-success">Retourner a mon profil</a>
                        </div>';
            }
        }
    }

    // REQUETE - RECUPERATION EN BDD POUR UN UPDATE
    if ($_GET['action'] == 'profil') {
        $tousUsers = $pdo->query("SELECT * FROM membre WHERE id_membre = '$_GET[id_membre]' ");
        $userActuel = $tousUsers->fetch(PDO::FETCH_ASSOC);
    }

    $id_membre = (isset($userActuel['id_membre'])) ? $userActuel['id_membre'] : "";
    $pseudo = (isset($userActuel['pseudo'])) ? $userActuel['pseudo'] : "";
    $email = (isset($userActuel['email'])) ? $userActuel['email'] : "";
    $nom = (isset($userActuel['nom'])) ? $userActuel['nom'] : "";
    $prenom = (isset($userActuel['prenom'])) ? $userActuel['prenom'] : "";
    $telephone = (isset($userActuel['telephone'])) ? $userActuel['telephone'] : "";
    $civilite = (isset($userActuel['civilite'])) ? $userActuel['civilite'] : "";
    $mdp = (isset($userActuel['mdp'])) ? $userActuel['mdp'] : "";

    // REQUETE - DELETE
    if($_GET['action'] == 'delete'){
        $pdo->query(" DELETE FROM membre WHERE id_membre = '$_GET[id_membre]' ");
    }
}

require_once('include/header.php');
?>

<?= $erreur ?>
<?= $success ?>

<?php if (isset($_GET['action']) && $_GET['action'] == 'profil') : ?>

        <div class="col-md-8 mx-auto">

            <form class="my-5" method="POST" action="">

            <input type="hidden" name="id_membre" value="<?= $id_membre ?>">

            <div class="row">
                
                <!-- EMAIL -->
                <div class="col-md-3 mt-5 mx-auto">
                    <label class="form-label" for="email">
                        <div class="badge badge-dark text-wrap">Email</div>
                    </label>
                    <input class="form-control" type="email" name="email" id="email" placeholder="Email" value="<?= $email ?>">
                </div>
            </div>

            <div class="row">

                <!-- NOM -->
                <div class="col-md-4 mt-5 mx-auto">
                    <label class="form-label" for="nom">
                        <div class="badge badge-dark text-wrap">Nom</div>
                    </label>
                    <input class="form-control" type="text" name="nom" id="nom" placeholder="Nom" value="<?= $nom ?>">
                </div>

                <!-- PRENOM -->
                <div class="col-md-4 mt-5 mx-auto">
                    <label class="form-label" for="prenom">
                        <div class="badge badge-dark text-wrap">Prénom</div>
                    </label>
                    <input class="form-control" type="text" name="prenom" id="prenom" placeholder="Prénom" value="<?= $prenom ?>">
                </div>
            </div>

            <div class="row">

                <!-- TELEPHONE -->
                <div class="col-md-4 mt-5 mx-auto">
                    <label class="form-label" for="telephone"><div class="badge badge-dark text-wrap">Telephone</div></label>
                    <input class="form-control" type="text" name="telephone" id="telephone" placeholder="Votre numéro de teléphone" value="<?= $telephone ?>">
                </div>

                <!-- CIVILITE -->
                <div class="col-md-4 mt-4 mx-auto">
                    <p>
                        <div class="badge badge-dark text-wrap">Civilité</div>
                    </p>

                    <input type="radio" name="civilite" id="civilite1" value="femme" <?= ($civilite == "femme") ? 'checked' : ""  ?>>
                    <label class="mx-2" for="civilite1">Femme</label>

                    <input type="radio" name="civilite" id="civilite2" value="homme" <?= ($civilite == "homme") ? 'checked' : ""  ?>>
                    <label class="mx-2" for="civilite2">Homme</label>
                </div>
            </div>

            <!-- VALIDATION -->
            <div class="col-md-3 mt-5 mx-auto">
                <button type="submit" class="btn btn-dark w-100 text-white">Valider</button>
            </div>

            </form>
        </div>
<?php endif; ?>

<?php require_once('include/footer.php') ?>