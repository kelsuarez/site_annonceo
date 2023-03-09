<?php
require_once('include/init.php');

$pageTitle = "Connexion";

// script pour se déconnecter
// on vérifie que dans l'URL a transiter une action  = deconnexion
// dans ce cas on fait un unet (avec le nom de la session pour la cibler)
// on ne fait pas de session_destroy car elle est trop radicale
// elle ne va  pas seulement detruire la session que l'on cible, mais toutes les sessions ouvertes (exemple, la session panier aussi). Donc trop radicale, on fait juste unset
if(isset($_GET['action'])  && $_GET['action'] == 'deconnexion'){
    unset($_SESSION['membre']);
    header('location:' . URL . 'connexion.php');
    exit();
}

if(internauteConnecte()){
    header('location:' . URL . 'profil.php');
    exit();
}

if(isset($_GET['action']) && $_GET['action'] == 'validate' ){
$validate .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                    <strong>Félicitations !</strong> Votre inscription est réussie 😉, vous pouvez vous connecter !
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
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

    <!-- TITLE CONNEXINO -->
    <h2 class="text-center py-5"><div class="badge badge-info text-dark text-wrap p-3"><strong>CONNEXION</strong></div></h2>

    <!-- MESSAGE DE VALIDATION -->
    <?= $validate ?>

    <!-- FORMULAIRE DE CONNEXION -->
    <form class="my-5" method="POST" action="">
        <div class="col-md-4 offset-md-4 my-4">
            <label class="form-label" for="pseudo"><div class="badge badge-dark text-wrap">Pseudo</div></label>
            <input class="form-control btn btn-outline-success mb-4" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo">

            <label class="form-label" for="mdp"><div class="badge badge-dark text-wrap">Mot de passe</div></label>
            <input class="form-control btn btn-outline-success mb-4" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe">

            <button type="submit" class="btn btn-lg btn-outline-dark text-success offset-md-4 my-2">Connexion</button>
        </div>
    </form>

<?php require_once('include/footer.php') ?>