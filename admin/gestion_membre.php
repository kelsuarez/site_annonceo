<?php
require_once('../include/init.php');

// CONNEXION ADMIN
if (!internauteConnecteAdmin()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

// PAGINATION
if(isset($_GET['page']) && !empty($_GET['page'])){
    $pageCourante = (int) strip_tags($_GET['page']);
}else{
    $pageCourante = 1;
}
$queryMembres = $pdo->query(" SELECT COUNT(id_categorie) AS nombreCategories FROM categorie");
$resultatMembres = $queryMembres->fetch();
$nombreMembres = (int) $resultatMembres['nombreCategories'];
$pagination = 5;
$nombrePages = ceil($nombreMembres / $pagination);
$premierMembre = ($pageCourante - 1) * $pagination;

// URL = ACTION
if (isset($_GET['action'])) {

    if ($_POST) {
        // PSEUDO
        if (!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9-_.]{3,20}$#', $_POST['pseudo'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo !</div>';
        }

        if ($_GET['action'] == 'add') {
            $verifPseudo = $pdo->prepare("SELECT pseudo FROM membre WHERE pseudo = :pseudo ");
            $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
            $verifPseudo->execute();
            if ($verifPseudo->rowCount() == 1) {
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur, ce pseudo existe déjà, vous devez en choisir un autre !</div>';
            }
            // MOT DE PASSE
            if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 3 || strlen($_POST['mdp']) > 20) {
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur format mdp !</div>';
            }
            $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        }
        // NOM
        if (!isset($_POST['nom']) || iconv_strlen($_POST['nom']) < 3 || iconv_strlen($_POST['nom']) > 20) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format nom !</div>';
        }
        // PRENOM
        if (!isset($_POST['prenom']) || iconv_strlen($_POST['prenom']) < 3 || iconv_strlen($_POST['prenom']) > 20) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format prénom !</div>';
        }
        // TELEPHONE 
        if(!isset($_POST['telephone']) || !preg_match('#^[0-9]{1,10}$#', $_POST['telephone'])){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format telephone !</div>';
        }
        // EMAIL
        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format email !</div>';
        }
        // CIVILITE
        if (!isset($_POST['civilite']) || $_POST['civilite'] != 'femme' && $_POST['civilite'] != 'homme') {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format civilité !</div>';
        }

        if (empty($erreur)) {
            // si dans l'URL action == update, on entame une procédure de modification
            if ($_GET['action'] == 'update') {
                $modifUser = $pdo->prepare(" UPDATE membre SET id_membre = :id_membre , pseudo = :pseudo, nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, civilite = :civilite WHERE id_membre = :id_membre ");
                $modifUser->bindValue(':id_membre', $_POST['id_membre'], PDO::PARAM_INT);
                $modifUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $modifUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $modifUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $modifUser->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_STR);
                $modifUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $modifUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
                $modifUser->execute();

                // pour personnaliser le message de réussite, je dois récupérer le pseudo de l'utilisateur modifié en BDD, pour personnaliser le message
                $queryUser = $pdo->query(" SELECT pseudo FROM membre WHERE id_membre = '$_GET[id_membre]' ");
                $user = $queryUser->fetch(PDO::FETCH_ASSOC);

                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> Modification de l`\'utilisateur '. $user['pseudo'] .' réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                // si on récupère autre chose que update (et donc add) on entame une procédure d'insertion en BDD
                $inscrireUser = $pdo->prepare(" INSERT INTO membre (pseudo, mdp, nom, prenom, telephone, email, civilite, date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite, NOW())");
                $inscrireUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
                $inscrireUser->execute();
            }
        }
    }

    // REQUETE - RECUPERATION EN BDD POUR UN UPDATE
    if ($_GET['action'] == 'update') {
        $tousUsers = $pdo->query("SELECT * FROM membre WHERE id_membre = '$_GET[id_membre]' ");
        $userActuel = $tousUsers->fetch(PDO::FETCH_ASSOC);
    }

    $id_membre = (isset($userActuel['id_membre'])) ? $userActuel['id_membre'] : "";
    $pseudo = (isset($userActuel['pseudo'])) ? $userActuel['pseudo'] : "";
    $email = (isset($userActuel['email'])) ? $userActuel['email'] : "";
    $nom = (isset($userActuel['nom'])) ? $userActuel['nom'] : "";
    $prenom = (isset($userActuel['prenom'])) ? $userActuel['prenom'] : "";
    $telephone = (isset($userActuel['telephone'])) ? $userActuel['telephone'] : "";
    $civilite = (isset($userActuel['civilite'])) ? $userActuel['civilite'] : "";

    // REQUETE - DELETE
    if($_GET['action'] == 'delete'){
        $pdo->query(" DELETE FROM membre WHERE id_membre = '$_GET[id_membre]' ");
    }
}

require_once('includeAdmin/header.php');
?>

<?= $erreur ?>
<?= $content ?>

<!-- TITLE GESTION -->
<h1 class="text-center my-5">
    <div class="badge badge-success text-wrap p-3">Gestion des utilisateurs</div>
</h1>

<!-- FORMULAIRE -->
<?php if (isset($_GET['action'])) : ?>

    <!-- TITLE FORMULAIRE -->
    <h2 class="my-5 text-center"><u>Formulaire <?= ($_GET['action'] == 'add') ? "d'ajout" : "de modification" ?> des utilisateurs</u></h2>

    <form class="my-5" method="POST" action="">

        <input type="hidden" name="id_membre" value="<?= $id_membre ?>">

        <div class="row">
            <!-- PSEUDO -->
            <div class="col-md-4 mt-5">
                <label class="form-label" for="pseudo">
                    <div class="badge badge-dark text-wrap">Pseudo</div>
                </label>
                <input class="form-control" type="text" name="pseudo" id="pseudo" placeholder="Pseudo" max-length="20" pattern="[a-zA-Z0-9-_.]{3,20}" title="caractères acceptés: majuscules et minuscules, chiffres, signes tels que: - _ . entre trois et vingt caractères." required value="<?= $pseudo ?>">
            </div>

            <!-- MOT DE PASSE -->
            <?php if ($_GET['action'] == "add") : ?>
                <div class="col-md-4 mt-5">
                    <label class="form-label" for="mdp">
                        <div class="badge badge-dark text-wrap">Mot de passe</div>
                    </label>
                    <input class="form-control" type="password" name="mdp" id="mdp" placeholder="Mot de passe" max-length="20" required>
                </div>
            <?php endif; ?>
            
            <!-- EMAIL -->
            <div class="col-md-4 mt-5">
                <label class="form-label" for="email">
                    <div class="badge badge-dark text-wrap">Email</div>
                </label>
                <input class="form-control" type="email" name="email" id="email" placeholder="Email" value="<?= $email ?>">
            </div>
        </div>

        <div class="row">
            <!-- NOM -->
            <div class="col-md-4 mt-5">
                <label class="form-label" for="nom">
                    <div class="badge badge-dark text-wrap">Nom</div>
                </label>
                <input class="form-control" type="text" name="nom" id="nom" placeholder="Nom" value="<?= $nom ?>">
            </div>
            <!-- PRENOM -->
            <div class="col-md-4 mt-5">
                <label class="form-label" for="prenom">
                    <div class="badge badge-dark text-wrap">Prénom</div>
                </label>
                <input class="form-control" type="text" name="prenom" id="prenom" placeholder="Prénom" value="<?= $prenom ?>">
            </div>
            <!-- TELEPHONE -->
            <div class="col-md-4 mt-5">
                <label class="form-label" for="telephone"><div class="badge badge-dark text-wrap">Telephone</div></label>
                <input class="form-control btn btn-outline-success" type="text" name="telephone" id="telephone" placeholder="Votre numéro de teléphone" value="<?= $telephone ?>">
            </div>
            <!-- CIVILITE -->
            <div class="col-md-4 mt-4">
                <p>
                <div class="badge badge-dark text-wrap">Civilité</div>
                </p>

                <input type="radio" name="civilite" id="civilite1" value="femme" <?= ($civilite == "femme") ? 'checked' : ""  ?>>
                <label class="mx-2" for="civilite1">Femme</label>

                <input type="radio" name="civilite" id="civilite2" value="homme" <?= ($civilite == "homme") ? 'checked' : ""  ?>>
                <label class="mx-2" for="civilite2">Homme</label>
            </div>
        </div>

        <!-- VALIDATION -->
        <div class="col-md-3 mt-5 mx-auto">
            <button type="submit" class="btn btn-outline-dark btn-success w-100 text-white">Valider</button>
        </div>

    </form>

<?php endif; ?>

<!-- NOMBRE DE CATEGORIES EN BDD -->
<?php $nbUsers = $pdo->query("SELECT id_membre FROM membre"); ?>
<h2 class="py-5 text-center">Utilisateurs en base de données:</h2>
<h3 class="text-center display-3">
    <div class="badge badge-success p-3"><?= $nbUsers->rowCount() ?></div>
</h3>

<!-- BUTTON D'AJOUT -->
<div class="col-3 mx-auto py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-sm btn-outline-dark btn-warning rounded w-100 p-3">
            <i class="bi bi-plus-circle-fill"></i> Ajouter un utilisateur
        </button>
    </a>
</div>

<!-- TABLEAU DE RESCUPERATION DONNES -->
<table class="table table-white text-center rounded-1">
    <?php $afficheUsers = $pdo->query("SELECT * FROM membre ORDER BY date_enregistrement DESC LIMIT $pagination OFFSET $premierMembre "); ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $afficheUsers->columnCount(); $i++) :
                $colonne = $afficheUsers->getColumnMeta(($i)) ?>
                <?php if ($colonne['name'] != 'mdp') : ?>
                    <th class="p-3 text-uppercase"><?= $colonne['name'] ?></th>
                <?php endif; ?>
            <?php endfor; ?>
            <th colspan=2 class="p-3 text-uppercase">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $afficheUsers->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($user as $key => $value) : ?>
                    <?php if ($key == 'statut') : ?>
                        <td>
                            <?php if ($value == 1) : ?>
                                Administrateur
                            <?php else : ?>
                                Membre
                            <?php endif; ?>
                        </td>
                    <?php else : ?>
                        <?php if ($key != 'mdp') : ?>
                            <td><?= $value ?></td>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td><a href='?action=update&id_membre=<?= $user['id_membre'] ?>'><i class="bi bi-pen-fill text-warning"></i></a></td>
                <td><a data-href="?action=delete&id_membre=<?= $user['id_membre'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger" style="font-size: 1.5rem;"></i></a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- PAGINATION -->
<nav aria-label="">
    <ul class="pagination justify-content-end">
        <li class="page-item <?= ($pageCourante == 1) ? 'disabled' : "" ?>">
            <a class="page-link text-dark" href="?page=<?= $pageCourante - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">précédente</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <?php for($page = 1; $page <= $nombrePages; $page++): ?>
        <li class="mx-1 page-item">
            <a class="btn btn-outline-success <?= ($pageCourante == $page) ? 'active' : "" ?>" href="?page=<?= $page ?>"><?= $page ?></a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?= ($pageCourante == $nombrePages)? 'disabled' : '' ?>">
            <a class="page-link text-dark" href="?page=<?= $pageCourante + 1 ?>" aria-label="Next">
                <span aria-hidden="true">suivante</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>

<!-- MODAL DE SUP/MDF-->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Supprimer Utilisateur
            </div>
            <div class="modal-body">
                Etes-vous sur de vouloir retirer cet utilisateur de votre base de données ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL GESTION D'UTILISATEURS -->
<?php if (!isset($_GET['action']) && !isset($_GET['page'])) : ?>
    <!-- modal infos -->
    <div class="modal fade" id="myModalUsers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger text-uppercase" id="exampleModalLabel">Gestion des utilisateurs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body col-8 mx-auto text-center">
                    <p>Gérez ici votre base de données des utilisateurs</p>
                    <p>Vous pouvez modifier leurs données, ajouter ou supprimer un utilisateur</p>
                </div>
                <div class="modal-footer col-5 mx-auto">
                    <button type="button" class="btn btn-outline-success text-dark w-100" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
<?php endif; ?>

<?php require_once('includeAdmin/footer.php'); ?>