<?php
require_once('../include/init.php');

if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php' );
    exit();
}

require_once('includeAdmin/header.php');
?>
    <div class="d-flex ">
        <h1 class="my-5 text-center display-4 mx-auto">
            <div class=" text-dark text-wrap p-3">ACCUEIL ADMINISTRATEUR</div>
        </h1>
        <h2 class="text-center my-5 display-4 mx-auto">
            <div class=" text-dark text-wrap p-3">BONJOUR, <?= $_SESSION['membre']['pseudo'] ?> </div>
        </h2>
    </div>
        
    <div class="row justify-content-around my-5">
        <img class='img-fluid' src="<?= URL ?>img/admin.jpg" alt="Image du Back Office" loading="lazy">  
    </div>

<?php require_once('includeAdmin/footer.php'); ?>