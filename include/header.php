<?php

// requete pour afficher les onglets public (enfant, femme etc... par ordre alphabétique) dans la barre de navigation
// DISTINCT permet de n'afficher qu'une seule fois l'onglet, sinon, il sera affiché pour autant de produits concernés par ce public
$afficheMenuPublics = $pdo->query(" SELECT DISTINCT titre FROM categorie ORDER BY titre ASC ");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- FAVICON -->
  <link rel="icon" type="image/png" href="logo_300_black.png" />
  <!-- GOOGLE FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,600&family=Shantell+Sans&display=swap" rel="stylesheet">
  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <!-- ICON BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

  <!-- code pour récupérer le nom de chaque page de manière dynamique on declare pour chaque fichier, une valeur à pageTitle
  Dans le cas de la page d'accueil/index, impossible d'avoir une valeur si on a cliqué sur rien, donc on ne peut pas déclarer dans index.php une valeur unique. Cela empecherait d'avoir un onglet dynamiqu si on veut afficher les manteaux, ou les vestes etc...
  Pour résoudre ce problème, on dit que si pageTitle existe (dans un fichier), on affiche sa valeur, si elle n'existe pas, on affiche La Boutique -->

  
    <title><?=(isset($pageTitle) ? $pageTitle : "La Boutique") ?></title>
    <style>
      .imgLogo{
        width: 60px;
      }
      .shantellSans{
        font-family: 'Shantell Sans', cursive;
      }
      *{
        font-family: 'Roboto Flex', sans-serif;
      }
    </style>
</head>
<body>

<header>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?= URL ?>">
      <img class="ml-5 imgLogo"src="<?= URL ?>logo_300_white.png">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
          <a class="nav-link display-4 shantellSans text-info" href="<?= URL ?>">Annonceo</a>
        </li>
      <!-- ----------- -->
      <?php while($menuPublic = $afficheMenuPublics->fetch(PDO::FETCH_ASSOC)): ?>
      <li class="nav-item">
        <!-- ucfirst permet de donner une majuscule a la première lettre d'un mot -->
        
        <a class="nav-link" href=""><button type="button" class="btn btn-outline-success"></button></a>
        
      </li>
      <?php endwhile; ?>
      <!-- ---------- -->
    </ul>
    <ul class="navbar-nav ml-auto">
      <!-- -------------------------- -->
    <?php if(internauteConnecte()): ?>
      <!-- si l'internaute est connecté il aura accés aux pages profil, panier et un bouton de deconnexion  (mais pas aux autres) -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <button type="button" class="btn btn-outline-success">Espace <strong><?= $_SESSION['membre']['pseudo'] ?></strong></button>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= URL ?>profil.php"><strong>Profil <?= $_SESSION['membre']['pseudo'] ?></strong></a>
          <a class="dropdown-item" href="<?= URL ?>panier.php"><strong>Panier <?= $_SESSION['membre']['pseudo'] ?></strong></a>
          <a class="dropdown-item" href="<?= URL ?>connexion.php?action=deconnexion"><strong>Déconnexion</strong></a>
        </div>
      </li>
    <?php else: ?>
      <!-- si il n'est pas connecté, il aura droit aux pages inscription, connexion et panier (mais pas aux autres)-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-5" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <button type="button" class="btn btn-outline-success">Espace Membre</button>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= URL ?>inscription.php">
            <button class="btn btn-outline-success">Inscription</button>
          </a>
          <a class="dropdown-item" href="<?= URL ?>connexion.php">
            <button class="btn btn-outline-success">Connexion</button>
          </a>
          <a class="dropdown-item" href="<?= URL ?>panier.php">
            <button class="btn btn-outline-success px-4">Panier</button>
          </a>
        </div>
      </li>
      <?php endif; ?>
     <!-- le bouton admin n'apparaitra que pour un utilisateur qui a les droits d'admin -->
    <?php if(internauteConnecteAdmin()): ?>
      <li class="nav-item mr-5">
          <a class="nav-link" href="admin/index.php"><button type="button" class="btn btn-outline-success">Admin</button></a>
      </li>
    <?php endif; ?>
      <!-- ------------------------------------ -->
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0 mr-5" type="submit">Search</button>
    </form>
  </div>
</nav>

</header>

<!-- <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
  <li class="nav-item text-center ">
    <a class="nav-link" href="<?= URL ?>index.php"><button type="button" class="btn btn-outline-light text-white badge badge-dark text-wrap p-2"><strong class="shantellSans display-4">VOIR LES ANNONCES</strong></button></a>
  </li>
</ul> -->

<!-- <h2 class="text-center pb-5">Notre Catalogue. Nos Produits !</h2> -->