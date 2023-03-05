<?php
require_once('include/init.php');



// code a venir
require_once('include/affichage.php');
// positionner le pageTitle sous le require de affichage, car c'est dedans que a été declaré le tableau $detail (sinon, undifined array_key[titre] etc...)
// le substr avec la valeur -1 va enlever tous les pluriels pour les catégories (je veux afficher le mot au singulier dans l'onglet title)
$pageTitle = "Fiche " . substr($detail['categorie'], 0, -1) . " " . $detail['titre'];
require_once('include/header.php');
?>

</div>

<div class="container-fluid">
    <div class="row">
        <!-- debut de la colonne qui va afficher les categories -->
        <div class="col-md-2">

            <div class="list-group text-center">

                <?php while ($menuCategorie = $afficheMenuCategories->fetch(PDO::FETCH_ASSOC)) : ?>
                    <a class="btn btn-outline-success my-2" href="<?= URL ?>?categorie=<?= $menuCategorie['categorie'] ?>"><?= $menuCategorie['categorie'] ?></a>
                <?php endwhile; ?>

            </div>

        </div>
        <!-- fin de la colonne catégories -->
        <div class="col-md-8">

            <h2 class='text-center my-5'>
                <div class="badge badge-dark text-wrap p-3">Fiche du produit <?= substr($detail['categorie'], 0, -1) . " " . $detail['titre'] ?></div>
            </h2>

            <div class="row justify-content-around text-center py-5">
                <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 22rem;">
                    <img src="<?= URL . 'img/' . $detail['photo'] ?>" class="card-img-top" alt="image du produit <?= substr($detail['categorie'], 0, -1) . " " . $detail['titre'] ?>">
                    <div class="card-body">
                        <h3 class="card-title">
                            <div class="badge badge-dark text-wrap"><?= $detail['prix'] ?> €</div>
                        </h3>
                        <p class="card-text"><?= $detail['description'] ?></p>
                        <!-- ------------------- -->
                        <!-- condition pour savoir si on affiche un sélecteur pour choisir le nombre de produits que l'on veut (s'il y a du stock) ou si on afiche le message d'alerte qui indique une rupture de stock -->
                        <?php if ($detail['stock'] > 0) : ?>
                            <!-- La quantité désirée sera récupérée sur la page panier (pour savoir combien il veut acheter), donc on indique dans l'attribut action, le nom du fichier panier.php -->
                            <form method="POST" action="panier.php">
                                <input type="hidden" name="id_produit" value="<?= $detail['id_produit'] ?>">
                                <label for="quantite">J'en achète</label>
                                <select class="form-control col-md-5 mx-auto" name="quantite" id="quantite">
                                    <!-- ----------- -->
                                    <!-- boucle qui va récupérer la quantité en stock pour permettre de choisir la quantité -->
                                    <?php for ($quantite = 1; $quantite <= min($detail['stock'], 5); $quantite++) : ?>
                                        <!-- la fonction prédéfinie min (au dessus) permet de n'afficher que 5 au maximum dans le sélecteur, même si j'en ai plus en stock. Volontairement, après reflexion, je ne veux pas vendre plus de 5 articles du même produit durant la même vente  -->
                                        <option class="bg-dark text-light" value="<?= $quantite ?>"><?= $quantite ?></option>
                                    <?php endfor; ?>
                                    <!-- ----------- -->
                                </select>
                                <button type="submit" class="btn btn-outline-success my-2" name="ajout_panier" value="ajout_panier"><i class="bi bi-plus-circle"></i> Panier <i class="bi bi-cart3"></i></button>
                            </form>
                        <?php else : ?>
                            <!-- ----------- -->
                            <p class="card-text">
                            <div class="badge badge-danger text-wrap p-3">Produit en rupture de stock</div>
                            </p>
                        <?php endif; ?>
                        <!-- ------------ -->
                        <!-- lien pour retourner voir tous les produits de la même catégorie -->
                        <p>Voir tous les modèles <a href="<?= URL ?>?categorie=<?= $detail['categorie'] ?>">de la même catégorie</a> ou <a href="<?= URL . '?public=' . $detail['public'] ?>">pour le même public</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <?php require_once('include/footer.php') ?>