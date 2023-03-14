<?php
// affichage des catégories dans la navigation latérale
$afficheMenuCategories = $pdo->query(" SELECT DISTINCT titre FROM categorie ORDER BY titre ASC ");
// fin de navigation laterale catégories

// tout l'affichage par categorie
if(isset($_GET['categorie'])){
    // pagination pour les categories
    
    // fin pagination pour les categories

    // affichage de tous les produits concernés par une categorie
    $fiche_annonce = $pdo->query(" SELECT annonce.*, categorie.titre AS titre_categorie FROM annonce, categorie WHERE categorie.titre = '$_GET[categorie]'");
    // fin affichage des produits par categorie

    // affichage de la categorie dans le <h2>
    $afficheTitreCategorie = $pdo->query(" SELECT titre FROM categorie WHERE titre = '$_GET[categorie]' ");
    $titreCategorie = $afficheTitreCategorie->fetch(PDO::FETCH_ASSOC);
    // fin du h2 categorie

    // pour les onglets categories
    $pageTitle = "Nos modèles de " . $_GET['categorie'];
    // fin onglets categories
}
// fin affichage par categorie

// -----------------------------------------------------------------------------------

// tout l'affichage par public
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