<?php

// SELECT CATEGORIE
$afficheMenuCategories = $pdo->query(" SELECT DISTINCT titre FROM categorie ORDER BY titre ASC ");

// CATEGORIE
if(isset($_GET['categorie'])){

    // AFFICHAGE
    $sql = "SELECT annonce.*, categorie.titre AS titre_categorie FROM annonce INNER JOIN categorie ON annonce.categorie_id = categorie.id_categorie WHERE categorie.titre = ?";
    $stmt = $pdo->prepare($sql);
    $categorie = $_GET['categorie'];
    $stmt->execute([$categorie]);

    // TITRE
    $afficheTitreCategorie = $pdo->query(" SELECT titre FROM categorie WHERE titre = '$_GET[categorie]' ");
    $titreCategorie = $afficheTitreCategorie->fetch(PDO::FETCH_ASSOC);

    // pour les onglets categories
    // $pageTitle = "Nos modèles de " . $_GET['categorie'];
    // fin onglets categories
}

// SELECT PRIX
$afficheMenuPrix = $pdo->query(" SELECT DISTINCT prix FROM annonce ORDER BY prix ASC ");

// PRIX
if(isset($_GET['prix'])){

    // AFFICHAGE
    $affichePrix = $pdo->query(" SELECT * FROM annonce WHERE prix = '$_GET[prix]' ORDER BY prix ASC ");

    // TITRE
    $afficheTitrePrix = $pdo->query(" SELECT prix FROM annonce WHERE prix = '$_GET[prix]' ");
    $titrePrix = $afficheTitrePrix->fetch(PDO::FETCH_ASSOC);

    // pour les onglets categories
    // $pageTitle = "Nos modèles de " . $_GET['categorie'];
    // fin onglets categories
}

// SELECT VILLE
$afficheMenuVille = $pdo->query(" SELECT DISTINCT ville FROM annonce ORDER BY ville ASC ");

// VILLE
if(isset($_GET['ville'])){

    // AFFICHAGE
    $afficheVille = $pdo->query(" SELECT * FROM annonce WHERE ville = '$_GET[ville]' ORDER BY ville ASC ");

    // TITRE
    $afficheTitreVille = $pdo->query(" SELECT ville FROM annonce WHERE ville = '$_GET[ville]' ");
    $titreVille = $afficheTitreVille->fetch(PDO::FETCH_ASSOC);

    // pour les onglets categories
    // $pageTitle = "Nos modèles de " . $_GET['categorie'];
    // fin onglets categories
}

// DERNIERS ANNONCES
// AFFICHAGE
$afficheDerniers = $pdo->query(" SELECT * FROM annonce ORDER BY date_enregistrement DESC ");

// if(isset($_GET['public'])){
    // pagination produits par public
    
    // fin pagination produits par public

    // affichage des produits par public
    // requete qui va cibler tous les produits qui ont en commun le public récupéré dans l'URL
    // $afficheProduits = $pdo->query(" SELECT * FROM produit WHERE public = '$_GET[public]' ORDER BY prix ASC ");
    // fin affichage des produits par public

    // affichage du public dans le <h2>
    // $afficheTitrePublic = $pdo->query(" SELECT public FROM produit WHERE public = '$_GET[public]' ");
    // $titrePublic = $afficheTitrePublic->fetch(PDO::FETCH_ASSOC);
    // fin du </h2> pour le public

    // pour les onglets publics
    // $pageTitle = "Nos vetements " . ucfirst($_GET['public']) . 's'; 
    // fin onglets publics
// }
// fin affichage par public

// ---------------------------------------------------------------------------------------
// Tout ce qui concerne la fiche produit

// affichage d'un produit
if(isset($_GET['id_annonce'])){
    $detailAnnonce = $pdo->query(" SELECT * FROM annonce WHERE id_annonce = '$_GET[id_annonce]' ");
        if($detailAnnonce->rowCount() <= 0){
            header('location:' . URL);
            exit;
        }
    $detail = $detailAnnonce->fetch(PDO::FETCH_ASSOC);
}

// if(isset($_GET['id_annonce'])){
//     $detailAnnonce = $pdo->query(" SELECT * FROM annonce WHERE id_annonce = '$_GET[id_annonce]' ");
//         if($detailAnnonce->rowCount() <= 0){
//             header('location:' . URL);
//             exit;
//         }
//     $photoid = $detailAnnonce->fetch(PDO::FETCH_ASSOC);
// }

// $photoid = $pdo->query("SELECT * FROM photo WHERE id_photo = '$_GET[$photoid]'");
// $maListePhoto = $photoid->fetch(PDO::FETCH_ASSOC);

// if(isset($_GET['id_annonce'])){
//     $detailAnnonce = $pdo->query(" SELECT * FROM annonce WHERE id_annonce = '$_GET[id_annonce]' ");
//     $detail = $detailAnnonce->fetch(PDO::FETCH_ASSOC);

    
// }

// fin affichage d'un seul produit

// foreach($photo AS $indice => $valeur) {
//     if($indice != 'id_photo') {
//         if(!empty($valeur)) {
//             echo '<img src="' . $maListePhoto . $valeur . '">';
//         }
//     }
// } 
//  fin fiche produit

// --------------------------------------------------------------------------------------------