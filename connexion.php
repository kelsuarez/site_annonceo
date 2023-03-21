<?php
require_once('include/init.php');

$pageTitle = "Connexion";

if(isset($_GET['action'])  && $_GET['action'] == 'deconnexion'){
    unset($_SESSION['membre']);
    header('location:' . URL . 'connexion.php');
    exit();
}

if(internauteConnecte()){
    header('location:' . URL . 'profil.php');
    exit();
}

if($_POST){

    // REQUETTE COMPARATION PSEUDO EN BDD
    $verifPseudo = $pdo->prepare(" SELECT * FROM membre WHERE pseudo = :pseudo ");
    $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $verifPseudo->execute();

    // 
    if($verifPseudo->rowCount() == 1){
        $user = $verifPseudo->fetch(PDO::FETCH_ASSOC);
        if(password_verify($_POST['mdp'], $user['mdp'])){
            foreach($user as $key => $value){
                if($key != 'mdp'){
                    $_SESSION['membre'][$key] = $value;
                    if(internauteConnecteAdmin()){
                        header('location:' . URL . 'admin/index.php?action=validate' );
                    }elseif(isset($_GET['action']) && $_GET['action'] == 'acheter'){
                        header('location:' . URL . 'panier.php' );
                    }else{
                        header('location:' . URL . 'profil.php?action=validate' );
                    }
                }
            }
        }else{
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur ce mot de passe ne correspond pas !</div>';
        }
    }else{
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur ce pseudo n\'existe pas, vérifiez !<br> Etes vous inscrit ?</div>';
    }
}

require_once('include/header.php');
?>

    <!-- TITLE CONNEXION -->
    <h2 class="text-center display-4 my-5 text-wrap p-3">CONNEXION</h2>

    <!-- MESSAGE DE VALIDATION -->
    <?= $validate ?>

    <!-- FORMULAIRE DE CONNEXION -->
    <form class="my-5" method="POST" action="">
        <div class="col-md-4 offset-md-4 my-4">
            <label class="form-label" for="pseudo">Pseudo</label>
            <input class="form-control btn btn-outline-dark mb-4" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo">

            <label class="form-label" for="mdp">Mot de passe</label>
            <input class="form-control btn btn-outline-dark mb-4" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe">

            <button type="submit" class="text-center mx-auto col-10 col-lg-12 mx-auto btn btn-lg btn-outline-dark">Connexion</button>
        </div>
    </form>

<?php require_once('include/footer.php') ?>