<?php
// auteur: studentnaam
// functie: update class Klant

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;

$klant = new Klant;
$melding = '';

if (isset($_POST['update']) && $_POST['update'] === 'Wijzigen') {
    $row = [
        'klantId' => (int)($_POST['klantId'] ?? 0),
        'klantNaam' => trim($_POST['klantnaam'] ?? ''),
        'klantEmail' => trim($_POST['klantemail'] ?? ''),
        'klantAdres' => trim($_POST['klantadres'] ?? ''),
        'klantPostcode' => trim($_POST['klantpostcode'] ?? ''),
        'klantWoonplaats' => trim($_POST['klantwoonplaats'] ?? ''),
    ];

    if ($row['klantId'] <= 0 || empty($row['klantNaam']) || empty($row['klantEmail'])) {
        $melding = 'Vul minimaal naam en email in.';
    } elseif (!filter_var($row['klantEmail'], FILTER_VALIDATE_EMAIL)) {
        $melding = 'Ongeldig emailadres.';
    } else {
        if ($klant->updateKlant($row)) {
            header('Location: read.php?update=success');
            exit;
        }
        $melding = 'Bijwerken klant mislukt.';
    }
}

if (isset($_GET['klantId'])) {
    $klantId = (int)$_GET['klantId'];
    $row = $klant->getKlant($klantId);
    if (empty($row)) {
        $melding = 'Klant niet gevonden.';
    }
} else {
    $row = [];
    $melding = 'Geen klantId opgegeven.';
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Wijzigen klant</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>
<h1>CRUD Klant</h1>
<h2>Wijzigen</h2>

<?php if ($melding !== ''): ?>
    <p><?= htmlspecialchars($melding) ?></p>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="klantId" value="<?= htmlspecialchars($row['klantId'] ?? '') ?>">

    <label>Naam *</label><br>
    <input type="text" name="klantnaam" required value="<?= htmlspecialchars($row['klantNaam'] ?? '') ?>"><br>

    <label>Email *</label><br>
    <input type="email" name="klantemail" required value="<?= htmlspecialchars($row['klantEmail'] ?? '') ?>"><br>

    <label>Adres</label><br>
    <input type="text" name="klantadres" value="<?= htmlspecialchars($row['klantAdres'] ?? '') ?>"><br>

    <label>Postcode</label><br>
    <input type="text" name="klantpostcode" value="<?= htmlspecialchars($row['klantPostcode'] ?? '') ?>"><br>

    <label>Woonplaats</label><br>
    <input type="text" name="klantwoonplaats" value="<?= htmlspecialchars($row['klantWoonplaats'] ?? '') ?>"><br><br>

    <input type="submit" name="update" value="Wijzigen">
</form>

<br>
<a href="read.php">Terug</a>

</body>
</html>
