<?php
require_once('include/init.php');

// TITLE PAGE
$pageTitle = "Inscription";

// REDIRECTION SI USER CONNECTE
if(internauteConnecte()){
    header('location:' . URL . 'profil.php');
}

if(isset($_GET['action']) && $_GET['action'] == 'validate' ){
    $validate .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> Votre inscription est réussie 😉, vous pouvez vous connecter !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
}

// CONDITION D'ENVOIE EN BDD
if($_POST){

    // PSEUDO
    if(!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9-_.]{3,20}$#', $_POST['pseudo'])){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo !</div>';
    }
    // MDP
    if(!isset($_POST['mdp']) || strlen($_POST['mdp']) < 3 || strlen($_POST['mdp']) > 20 ){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format mdp !</div>';
    }
    // NOM
    if(!isset($_POST['nom']) || iconv_strlen($_POST['nom']) < 3 || iconv_strlen($_POST['nom']) > 20 ){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format nom !</div>';
    }
    // PRENOM 
    if(!isset($_POST['prenom']) || iconv_strlen($_POST['prenom']) < 3 || iconv_strlen($_POST['prenom']) > 20 ){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format prénom !</div>';
    }
    // TELEPHONE ------------------------------------------------- 
    if(!isset($_POST['telephone']) || !preg_match('#^[0-9]{1,10}$#', $_POST['telephone'])){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format telephone !</div>';
    }
    // EMAIL
    if(!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format email !</div>';
    }
    // CIVILITE
    if(!isset($_POST['civilite']) || $_POST['civilite'] != 'femme' && $_POST['civilite'] != 'homme' ){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format civilité !</div>';
    }

    // VERIFICATION PSEUDO EN BDD
    $verifPseudo = $pdo->prepare("SELECT pseudo FROM membre WHERE pseudo = :pseudo ");
    $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $verifPseudo->execute();
    if($verifPseudo->rowCount() == 1){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur, ce pseudo existe déjà, vous devez en choisir un autre !</div>';
    }

    // HASH MOT DE PASSE
    $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    // REQUETTE PREPARE D'ENVOIE EN BDD
    if(empty($erreur)){
        $inscrireUser = $pdo->prepare(" INSERT INTO membre (pseudo, mdp, nom, prenom, telephone, email, civilite, date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite, NOW())");
        $inscrireUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $inscrireUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
        $inscrireUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $inscrireUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $inscrireUser->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_STR);
        $inscrireUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $inscrireUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
        $inscrireUser->execute();

        // redirection UX vers la page de connexion, avec en plus un message particulier s'il vient de s'inscrire (ne s(affichera pas si il était inscrit depuis longtemps))
        header('location' . URL . 'connexion.php?action=validate');
    }

}

require_once('include/header.php');
?>


    <h2 class="text-center py-5 col-3 mx-auto">
        <div class="badge badge-info text-wrap p-3 w-100">Inscription</div>
    </h2>

<?= $erreur ?>

<!-- $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo !</div>'; -->


<form class="my-5 col-10 mx-auto" method="POST" action="">

    <div class="row">
        <!-- PSEUDO -->
        <div class="col-md-4 mt-5">
            <label class="form-label" for="pseudo"><div class="badge badge-dark text-wrap">Pseudo</div></label>
            <input class="form-control btn btn-outline-success" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" max-length="20" pattern="[a-zA-Z0-9-_.]{3,20}" title="caractères acceptés: majuscules et minuscules, chiffres, signes tels que: - _ . , entre trois et vingt caractères." required>
        </div>
        <!-- MOT DE PASSE -->
        <div class="col-md-4 mt-5">
        <label class="form-label" for="mdp"><div class="badge badge-dark text-wrap">Mot de passe</div></label>
        <input class="form-control btn btn-outline-success" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" required>
        </div>
        <!-- EMAIL -->
        <div class="col-md-4 mt-5">
        <label class="form-label" for="email"><div class="badge badge-dark text-wrap">Email</div></label>
        <input class="form-control btn btn-outline-success" type="email" name="email" id="email" placeholder="Votre email" required>
        </div>
    </div>

    <div class="row">
        <!-- NOM -->
        <div class="col-md-4 mt-5">
            <label class="form-label" for="nom"><div class="badge badge-dark text-wrap">Nom</div></label>
            <input class="form-control btn btn-outline-success" type="text" name="nom" id="nom" placeholder="Votre nom">
        </div>
        <!-- PRENOM -->
        <div class="col-md-4 mt-5">
            <label class="form-label" for="prenom"><div class="badge badge-dark text-wrap">Prénom</div></label>
            <input class="form-control btn btn-outline-success" type="text" name="prenom" id="prenom" placeholder="Votre prénom">
        </div>
        <!-- TELEPHONE -->
        <div class="col-md-4 mt-5">
            <label class="form-label" for="telephone"><div class="badge badge-dark text-wrap">Telephone</div></label>
            <input class="form-control btn btn-outline-success" type="text" name="telephone" id="telephone" placeholder="Votre numéro de teléphone">
        </div>
        <!-- CIVILITE -->
        <div class="col-md-4 mt-5 pt-2">
            <p><div class="badge badge-dark text-wrap">Civilité</div></p> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="civilite" id="civilite1" value="femme">
                <label class="form-check-label mx-2" for="civilite1">Femme</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="civilite" id="civilite2" value="homme" checked>
                <label class="form-check-label mx-2" for="civilite2">Homme</label>
            </div>
        </div>
    </div>

    <div class="col-md-1 mt-5">
        <a href="?action=validate">
            <button type="submit" class="btn btn-lg btn-outline-success">Valider</button>
        </a>
    </div>
    
</form>

<?php require_once('include/footer.php') ?>