<?php
$titre = 'Liste des étudiants';
require_once __DIR__ . '/config/connexion.php';

$pdo = getConnexion();

// ---------------------------------------------------------------
// Étape 4 : lecture des étudiants
// Bonus 5.1 : filtre par filière (requête préparée + bindParam)
// ---------------------------------------------------------------
$filtre = $_GET['filiere'] ?? '';

if ($filtre !== '' && in_array($filtre, FILIERES, true)) {
    // TODO 5.1 (BONUS) : préparer un SELECT avec "WHERE filiere = :filiere",
    //   lier :filiere avec bindParam() puis exécuter.
    //   En attendant, on affiche toute la liste :
    $filtre = '';
}

if ($filtre === '') {
    // TODO 4.1 : exécuter avec $pdo->query() la requête qui sélectionne
    //   id, cne, nom, prenom, email, filiere, date_naissance, date_inscription
    //   de la table etudiants, triés par nom puis prénom.
    //   Stocker le PDOStatement retourné dans $stmt.

}

// TODO 4.2 : récupérer toutes les lignes avec fetchAll() dans $etudiants,
//   puis compter les lignes (count) et les colonnes (columnCount())
$etudiants   = [];
$nbEtudiants = 0;
$nbColonnes  = 0;

// Message après ajout / suppression (venant de ajouter.php ou supprimer.php)
$message = '';
if (isset($_GET['ajout']))     { $message = 'Étudiant ajouté avec succès (id n° ' . (int) $_GET['ajout'] . ').'; }
if (isset($_GET['supprime']))  { $message = 'Étudiant supprimé.'; }

require __DIR__ . '/includes/header.php';
?>
<h1>Liste des étudiants</h1>

<?php if ($message): ?>
    <div class="alerte alerte-succes"><?= e($message) ?></div>
<?php endif; ?>

<div class="carte">
    <div class="barre-outils">
        <form method="get" action="liste.php">
            <label for="filiere">Filière :</label>
            <select name="filiere" id="filiere" onchange="this.form.submit()">
                <option value="">Toutes</option>
                <?php foreach (FILIERES as $f): ?>
                    <option value="<?= e($f) ?>" <?= $filtre === $f ? 'selected' : '' ?>><?= e($f) ?></option>
                <?php endforeach; ?>
            </select>
            <noscript><button class="btn" type="submit">Filtrer</button></noscript>
        </form>
        <a class="btn" href="ajouter.php">➕ Ajouter</a>
    </div>

    <p class="info"><?= $nbEtudiants ?> étudiant(s) — <?= $nbColonnes ?> colonnes retournées par la requête</p>

    <table>
        <thead>
            <tr>
                <th>#</th><th>CNE</th><th>Nom</th><th>Prénom</th><th>E-mail</th>
                <th>Filière</th><th>Naissance</th><th>Inscrit le</th><th></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($nbEtudiants === 0): ?>
            <tr><td colspan="9" class="vide">Aucun étudiant enregistré pour le moment.</td></tr>
        <?php else: ?>
            <?php foreach ($etudiants as $i => $etu): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <!-- TODO 4.3 : afficher le CNE, le nom (en majuscules), le prénom,
                         l'e-mail et la filière de $etu, en les protégeant avec e()
                         (une cellule <td> par colonne ; la filière dans <span class="badge">) -->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <!-- (fourni) dates au format français -->
                    <td><?= $etu['date_naissance'] ? date('d/m/Y', strtotime($etu['date_naissance'])) : '—' ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($etu['date_inscription'])) ?></td>
                    <td>
                        <!-- Bonus 5.2 : suppression en POST (jamais en GET pour une action qui modifie la base) -->
                        <form method="post" action="supprimer.php" onsubmit="return confirm('Supprimer cet étudiant ?');">
                            <input type="hidden" name="id" value="<?= (int) $etu['id'] ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
