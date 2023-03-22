<?php
require_once('include/init.php');

// code a venir

require_once('include/affichage.php');
require_once('include/header.php');
?>

<!-- </div> -->



<?php 
// $affiche_annonces = $pdo->query(" SELECT annonce.*, categorie.titre AS titre_categorie FROM annonce, categorie"); 
// $monAnnonce = $affiche_annonces->fetch(PDO::FETCH_ASSOC);
?>
<?php //echo debug($affiche_annonces)?>


    <div class="container-fluid">

        <div class="row my-5">

            <!-- MENU DES FILTRES  -->
            <div class="col-lg-2 mx-auto">

                <!-- MENU CATEGORIE -->
                <h2 class="text-center">Catégories</h2>
                <form method="GET">
                    <label for="categorie"></label>
                    <select class="col-12" name="categorie" id="categorie">
                        <?php while($menuCategorie = $afficheMenuCategories->fetch(PDO::FETCH_ASSOC)): ?>
                            <option class="text-center" value="<?= $menuCategorie['titre'] ?>"><?= $menuCategorie['titre'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input class="col-12 mt-1" type="submit" name="submit" value="Submit">
                </form>

                <!-- MENU PRIX -->
                <h2 class="text-center mt-5">Prix</h2>
                <form method="GET">
                    <label for="prix"></label>
                    <select class="col-12" name="prix" id="prix">
                        <?php while($menuPrix = $afficheMenuPrix->fetch(PDO::FETCH_ASSOC)): ?>
                            <option class="text-center" value="<?= $menuPrix['prix'] ?>"><?= $menuPrix['prix'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input class="col-12 mt-1" type="submit" name="submit" value="Submit">
                </form>

                <!-- MENU VILLE -->
                <h2 class="text-center mt-5">Ville</h2>
                <form method="GET">
                    <label for="ville"></label>
                    <select class="col-12" name="ville" id="ville">
                        <?php while($menuVille = $afficheMenuVille->fetch(PDO::FETCH_ASSOC)): ?>
                            <option class="text-center" value="<?= $menuVille['ville'] ?>"><?= $menuVille['ville'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input class="col-12 mt-1" type="submit" name="submit" value="Submit">
                </form>

            </div>

            <!-- AFFICHAGE CATEGORIES -->
            <?php if(isset($_GET['categorie'])): ?>

                <div class="col-lg-10 mx-auto">

                <!-- TITRE  -->
                    <div class="row justify-content-around">
                        <h2 class="py-5">Annonces catégorie <?= $titreCategorie['titre'] ?></h2>
                    </div>

                <!-- FICHE ANNONCE -->
                    <div class="col-12 col-lg-8 mx-auto">
                        <?php while($fiche_annonce = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <?php //echo debug($fiche_annonce)?>
                            <div class="d-lg-flex mx-auto mt-5">
                                <div class="col-10 col-lg-6 mx-auto">
                                    <?php if(!empty($fiche_annonce['photo'])) :?>
                                        <img class="images_index" src="<?= URL . 'img/' . $fiche_annonce['photo'] ?>" alt="Annonce <?= $fiche_annonce['titre']?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-10 col-lg-6 mx-auto">
                                        <h3 class="card-title text-center"><?= $fiche_annonce['titre'] ?></h3>
                                        <p class="card-text"><?= $fiche_annonce['description_courte'] ?></p>
                                        <div class="d-flex m-1 mx-auto">
                                            <h5 class="card-text mr-2"><small class="text-muted"><?= $fiche_annonce['prix'] . " €"?></small></h5>
                                            <div>
                                                <a class="text-dark" href="fiche_annonce.php?id_annonce=<?=$fiche_annonce['id_annonce']?>">Voir plus</a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                <!-- PAGINATION -->
                    <nav aria-label="">
                        <ul class="pagination justify-content-end">
                            <li class="mx-1 page-item  ">
                                <a class="page-link text-success" href="" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <!--  -->
                            <li class="mx-1 page-item ">
                                <a class="btn btn-outline-success " href=""></a>
                            </li>
                            <!--  -->
                            <li class="mx-1 page-item ">
                                <a class="page-link text-success" href="" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>

            <!-- AFFICHAGE PRIX -->
            <?php elseif(isset($_GET['prix'])): ?>

                <div class="col-lg-10">

                <!-- TITRE -->
                    <div class="row justify-content-around">
                        <h2 class="py-5">Annonces avec un prix de <?= ucfirst($titrePrix['prix']) ?> €</h2>
                    </div>

                <!-- FICHE ANNONCE -->
                    <div class="col-12 col-lg-8 mx-auto">
                        <?php while($prix = $affichePrix->fetch(PDO::FETCH_ASSOC)): ?>
                            <?php //echo debug($prix)?>
                            <div class="d-lg-flex mx-auto mt-5">
                                <div class="col-10 col-lg-6 mx-auto">
                                    <?php if(!empty($prix['photo'])) :?>
                                        <img class="images_index" src="<?= URL . 'img/' . $prix['photo'] ?>" alt="Annonce <?= $prix['titre']?>">
                                    <?php endif;?>
                                </div>
                                <div class="col-10 col-lg-6 mx-auto">
                                        <h3 class="card-title text-center"><?= $prix['titre'] ?></h3>
                                        <p class="card-text"><?= $prix['description_courte'] ?></p>
                                        <div class="d-flex m-1 mx-auto">
                                            <h5 class="card-text mr-2"><small class="text-muted"><?= $prix['prix'] . " €"?></small></h5>
                                            <div>
                                                <a class="text-dark" href="fiche_annonce.php?id_annonce=<?=$prix['id_annonce']?>">Voir plus</a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                <!-- PAGINATION -->
                    <nav aria-label="">
                        <!-- dans les 3 <a href> je dois faire référence à la catégorie, en plus de la page, sinon cela ne fonctionnera pas -->
                        <ul class="pagination justify-content-end">
                            <li class="mx-1 page-item  ">
                                <a class="page-link text-success" href="" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>

                            <li class="mx-1 page-item ">
                                <a class="btn btn-outline-success " href=""></a>
                            </li>

                            <li class="mx-1 page-item ">
                                <a class="page-link text-success" href="" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>

            <!-- AFFICHAGE VILLE -->
            <?php elseif(isset($_GET['ville'])): ?>

                <div class="col-md-10">

                <!-- TITRE -->
                    <div class="row justify-content-around">
                        <h2 class="py-5">Annonces alentours de <?= ucfirst($titreVille['ville']) ?></h2>
                    </div>

                <!-- FICHE ANNONCE -->
                    <div class="col-12 col-lg-8 mx-auto">
                        <?php while($ville = $afficheVille->fetch(PDO::FETCH_ASSOC)): ?>
                            <?php //echo debug($ville)?>
                            <div class="d-lg-flex mx-auto mt-5">
                                <div class="col-10 col-lg-6 mx-auto">
                                    <?php if(!empty($ville['photo'])) :?>
                                        <img class="images_index" src="<?= URL . 'img/' . $ville['photo'] ?>" alt="Annonce <?=$ville['titre']?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-10 col-lg-6 mx-auto">
                                        <h3 class="card-title text-center"><?= $ville['titre'] ?></h3>
                                        <p class="card-text"><?= $ville['description_courte'] ?></p>
                                        <div class="d-flex m-1 mx-auto">
                                            <h5 class="card-text mr-2"><small class="text-muted"><?= $ville['prix'] . " €"?></small></h5>
                                            <div>
                                                <a class="text-dark" href="fiche_annonce.php?id_annonce=<?=$ville['id_annonce']?>">Voir plus</a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                <!-- PAGINATION -->
                    <nav aria-label="">
                        <!-- dans les 3 <a href> je dois faire référence à la catégorie, en plus de la page, sinon cela ne fonctionnera pas -->
                        <ul class="pagination justify-content-end">
                            <li class="mx-1 page-item  ">
                                <a class="page-link text-success" href="" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>

                            <li class="mx-1 page-item ">
                                <a class="btn btn-outline-success " href=""></a>
                            </li>

                            <li class="mx-1 page-item ">
                                <a class="page-link text-success" href="" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>

            <!-- AFFICHAGE DERNIERS POST -->
            <?php else: ?>

                <div class="col-md-10">

                <h1 class="d-none d-lg-block text-center display-1 mt-5"><u>ANNONCEO</u></h1>

                <?php if(internauteConnecte()) :?>
                    <h2 class="text-center mt-5"><i class="bi bi-plus-circle"></i><a class="text-dark" href="profil.php?action=add"> Poster un annonce</a></h2>
                <?php else : ?>
                    <h2 class="text-center mt-5"><i class="bi bi-plus-circle"></i><a class="text-dark" href="connexion.php"> Poster un annonce</a></h2>
                <?php endif; ?>

                <!-- TITRE -->
                    <div class="row justify-content-around">
                        <h2 class="py-5">
                            Nos derniers annonces
                        </h2>
                    </div>

                <!-- FICHE ANNONCE -->
                    <div class="col-12 col-lg-8 mx-auto">
                        <?php while($date_last = $afficheDerniers->fetch(PDO::FETCH_ASSOC)): ?>
                            <?php //echo debug($date_last)?>
                            <div class="d-lg-flex mx-auto mt-5">
                                <div class="col-10 col-lg-6 mx-auto">
                                    <?php if(!empty($date_last['photo'])) :?>
                                        <img class="images_index" src="<?= URL . 'img/' . $date_last['photo'] ?>" alt="Annonce <?=$date_last['titre']?>">
                                    <?php endif;?>
                                </div>
                                <div class="col-10 col-lg-6 mx-auto">
                                        <h3 class="card-title text-center"><?= $date_last['titre'] ?></h3>
                                        <p class="card-text"><?= $date_last['description_courte'] ?></p>
                                        <div class="d-flex m-1 mx-auto">
                                            <h5 class="card-text mr-2"><small class="text-muted"><?= $date_last['prix'] . " €"?></small></h5>
                                            <div>
                                                <a class="text-dark" href="fiche_annonce.php?id_annonce=<?=$date_last['id_annonce']?>">Voir plus</a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                <!-- PAGINATION -->
                    <nav aria-label="">
                        <!-- dans les 3 <a href> je dois faire référence à la catégorie, en plus de la page, sinon cela ne fonctionnera pas -->
                        <ul class="pagination justify-content-end">
                            <li class="mx-1 page-item  ">
                                <a class="page-link text-success" href="" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>

                            <li class="mx-1 page-item ">
                                <a class="btn btn-outline-success " href=""></a>
                            </li>

                            <li class="mx-1 page-item ">
                                <a class="page-link text-success" href="" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>


            <?php endif; ?>

        </div>

    </div>

    <div class="col-md-12">
        <div class="row justify-content-around py-5 mx-auto">
            <img class='img-fluid' src="img/bandeau_annonceo" alt="Bandeau annonceo" loading="lazy">
        </div>
    </div>

<?php require_once('include/footer.php') ?>

