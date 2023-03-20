<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Annonceo Admin</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

  <!-- links pour les icon bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

  <!-- {# links pour databaseTables #} -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>


  <link rel="stylesheet" type="text/css" href="../css/stat.css"/>


  <!-- <style>
    .maxImg{
      max-height: 20em;
    }
  </style> -->
</head>

<body>
  <div class="d-flex" id="wrapper">

    <!-- SIDEBAR -->
    <div class="bg-info border-right" id="sidebar-wrapper">
      <div class="sidebar-heading text-dark text-center text-uppercase pt-5"><h3><strong>Annonceo Admin</strong></h3></div>
      <div class="list-group list-group-flush col-12 mx-auto">
        <!-- GESTION DE ANNONCES -->
        <a href="<?= URL ?>admin/statistiques.php" class="list-group-item list-group-item-action bg-info text-light py-5"><button type="button" class="btn btn-outline-light text-dark w-100"><strong>&nbspGestion &nbsp&nbspdes&nbsp&nbsp statistiques&nbsp</strong></button></a>
        <!-- GESTION DE ANNONCES -->
        <a href="<?= URL ?>admin/gestion_produit.php" class="list-group-item list-group-item-action bg-info text-light py-5"><button type="button" class="btn btn-outline-light text-dark w-100"><strong>&nbspGestion &nbsp&nbspdes&nbsp&nbsp annonces&nbsp</strong></button></a>
        <!-- GESTION DE MEMBRES -->
        <a href="<?= URL ?>admin/gestion_membre.php" class="list-group-item list-group-item-action bg-info text-light py-5"><button type="button" class="btn btn-outline-light text-dark w-100"><strong>&nbspGestion &nbspdes&nbsp membres&nbsp</strong></button></a>
        <!-- GESTION DE CATEGORIES -->
        <a href="<?= URL ?>admin/gestion_categories.php" class="list-group-item list-group-item-action bg-info text-light py-5"><button type="button" class="btn btn-outline-light text-dark w-100"><strong>&nbspGestion &nbsp&nbspdes&nbsp&nbsp Catégories&nbsp</strong></button></a>
        <!-- GESTION DE COMMENTAIRES -->
        <a href="<?= URL ?>admin/gestion_commentaires.php" class="list-group-item list-group-item-action bg-info text-light py-5"><button type="button" class="btn btn-outline-light text-dark w-100"><strong>&nbspGestion &nbsp&nbspdes&nbsp&nbsp Commentaires&nbsp</strong></button></a>
        <!-- GESTION DE NOTES -->
        <a href="<?= URL ?>admin/gestion_notes.php" class="list-group-item list-group-item-action bg-info text-light py-5"><button type="button" class="btn btn-outline-light text-dark w-100"><strong>&nbspGestion &nbsp&nbspdes&nbsp&nbsp Notes&nbsp</strong></button></a>
        <!-- ACCUEIL STORE -->
        <a href="<?= URL ?>index.php" class="list-group-item list-group-item-action bg-info text-light py-5"><button type="button" class="btn btn-outline-light text-dark w-100"><strong>Retour Accueil Store</strong></button></a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

<!-- Page Content -->
  <div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-info bg-info border-bottom">
      <button class="btn btn-lg btn-outline-light col-2" id="menu-toggle"><i class="bi bi-caret-left-square-fill"></i> Menu <i class="bi bi-caret-right-square-fill"></i></button>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="<?= URL ?>index.php"><button type="button" class="btn btn-outline-light text-dark"><strong>Home Boutique</strong></button></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= URL ?>admin/index.php"><button type="button" class="btn btn-outline-light text-dark"><strong>Home Admin</strong></button></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <button type="button" class="btn btn-outline-light text-dark"><strong>Menu Admin</strong></button>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= URL ?>admin/gestion_membre.php"><strong>Gestion des membres</strong></a>
          <a class="dropdown-item" href="<?= URL ?>admin/gestion_produit.php"><strong>Gestion des produits</strong></a>
          <a class="dropdown-item" href="<?= URL ?>admin/gestion_categories.php"><strong>Gestion des catégories</strong></a>
          <a class="dropdown-item" href="<?= URL ?>admin/gestion_commande.php"><strong>Gestion des commandes</strong></a>
          <a class="dropdown-item" href="<?= URL ?>admin/gestion_detail_commande.php"><strong>Détail des commandes</strong></a>
        </div>
      </li>
    </ul>
  </div>
</nav>

<div class="m-5">