<?php
require_once('../include/init.php');

if (!internauteConnecteAdmin()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

require_once('includeAdmin/header.php');
?>


<!-- TABLEAU MIEUX NOTES -->
<h2 class="text-center m-5">TOP 5 MEMBRES LES MIEUX NOTES</h2>
<table class="table table-white text-center rounded-1 col-10 mx-auto">
    <?php $topNote = $pdo->query("SELECT membre_id2, AVG(note) AS moyenneNote FROM note GROUP BY membre_id2 ORDER BY moyenneNote DESC"); ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $topNote->columnCount(); $i++) :
                $colonne = $topNote->getColumnMeta(($i)) ?>
                    <th class="p-3 text-uppercase"><?= $colonne['name'] ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $topNote->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($user as $key => $value) : ?>
                        <td><?= round($value) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- TABLEAU PLUS ACTIFS -->
<h2 class="text-center m-5">TOP 5 MEMBRES LES PLUS ACTIVFS</h2>
<table class="table table-white text-center rounded-1 col-10 mx-auto">
    <?php $topMembre = $pdo->query("SELECT m.id_membre, m.pseudo, COUNT(DISTINCT a.id_annonce) AS nb_annonces_postees, COUNT(DISTINCT n.id_note) AS nb_notes_laissees, COUNT(DISTINCT c.id_commentaire) AS nb_commentaires_laissees, AVG(n.note) AS moyenne_notes FROM membre m LEFT JOIN annonce a ON a.membre_id = m.id_membre LEFT JOIN note n ON n.membre_id1 = m.id_membre LEFT JOIN commentaire c ON c.membre_id = m.id_membre GROUP BY m.id_membre ORDER BY nb_annonces_postees DESC, moyenne_notes DESC, nb_notes_laissees DESC, nb_commentaires_laissees DESC LIMIT 5"); ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $topMembre->columnCount(); $i++) :
                $colonne = $topMembre->getColumnMeta(($i)) ?>
                    <th class="p-3 text-uppercase"><?= $colonne['name'] ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $topMembre->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($user as $key => $value) : ?>
                        <td><?= $value ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- TABLEAU PLUS D'ANNONCES -->
<h2 class="text-center m-5">TOP 5 MEMBRES AVEC PLUS DES ANNONCES</h2>
<table class="table table-white text-center rounded-1 col-10 mx-auto">
    <?php $membreAnnonce = $pdo->query("SELECT membre_id, COUNT(DISTINCT id_annonce) AS nombreAnnonce  FROM annonce GROUP BY membre_id ORDER BY  nombreAnnonce DESC LIMIT 5"); ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $membreAnnonce->columnCount(); $i++) :
                $colonne = $membreAnnonce->getColumnMeta(($i)) ?>
                    <th class="p-3 text-uppercase"><?= $colonne['name'] ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $membreAnnonce->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($user as $key => $value) : ?>
                        <td><?= $value ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- TABLEAU PLUS ANCIENNES -->
<h2 class="text-center m-5">TOP 5 MEMBRES LES PLUS ANCIENNES</h2>
<table class="table table-white text-center rounded-1 col-10 mx-auto">
    <?php $membresAnciennes = $pdo-> query("SELECT membre_id, date_enregistrement FROM annonce ORDER BY date_enregistrement LIMIT 5");  ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $membresAnciennes->columnCount(); $i++) :
                $colonne = $membresAnciennes->getColumnMeta(($i)) ?>
                    <th class="p-3 text-uppercase"><?= $colonne['name'] ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $membresAnciennes->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($user as $key => $value) : ?>
                        <td><?= $value ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once('includeAdmin/footer.php'); ?>