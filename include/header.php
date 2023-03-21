<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- FAVICON -->
  <link rel="icon" type="image/png" href="logo_100_black.png" />
  <!-- GOOGLE FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,600&family=Shantell+Sans&display=swap" rel="stylesheet">
  <!--LOCAL CSS -->
  <link rel="stylesheet" type="text/css" href="style.css">
  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <!-- ICON BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
  <title><?=(isset($pageTitle) ? $pageTitle : "ANNONCEO") ?></title>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= URL ?>">
      <img class="ml-5 imgLogo" src="<?= URL ?>logo_300_black.png" alt="logo annonceo">
    </a>
    <button class="navbar-toggler bg-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
          <a class="nav-link display-3 text-dark" href="<?= URL ?>">ANNONCEO</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php if(internauteConnecte()): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <button type="button" class="btn btn-outline-dark">Espace <strong><?= $_SESSION['membre']['pseudo'] ?></strong></button>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?= URL ?>profil.php"><strong>Profil <?= $_SESSION['membre']['pseudo'] ?></strong></a>
              <a class="dropdown-item" href="<?= URL ?>connexion.php?action=deconnexion"><strong>Déconnexion</strong></a>
            </div>
          </li>
        <?php else: ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle mr-5" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <button type="button" class="btn btn-outline-dark">Espace Membre</button>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?= URL ?>connexion.php">
                <button class="btn btn-outline-dark">Connexion</button>
              </a>
              <a class="dropdown-item" href="<?= URL ?>inscription.php">
                <button class="btn btn-outline-dark">Inscription</button>
              </a>
            </div>
          </li>
        <?php endif; ?>
        <?php if(internauteConnecteAdmin()): ?>
          <li class="nav-item mr-5">
              <a class="nav-link" href="admin/index.php"><button type="button" class="btn btn-outline-dark">Administrateur</button></a>
          </li>
        <?php endif; ?>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-dark my-2 my-sm-0 mr-5" type="submit">Search</button>
      </form>
    </div>
  </nav>
</header>