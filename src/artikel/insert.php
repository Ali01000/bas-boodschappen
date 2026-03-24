<?php
// functie: nieuw artikel toevoegen

require '../../vendor/autoload.php';

use Bas\classes\Artikel;

$melding = "";

if (isset($_POST["insert"])) {
    $row = [
        'artOmschrijving' => $_POST['artOmschrijving'] ?? '',
        'artVerkoop' => $_POST['artVerkoop'] ?? '',
        'artVoorraad' => $_POST['artVoorraad'] ?? ''
    ];

    if (
        empty($row['artOmschrijving']) ||
        empty($row['artVerkoop']) ||
        empty($row['artVoorraad'])
    ) {
        $melding = "Vul alle velden in.";
    } elseif (!is_numeric($row['artVerkoop'])) {
        $melding = "Verkoopprijs moet een geldig nummer zijn.";
    } elseif (!is_numeric($row['artVoorraad']) || $row['artVoorraad'] < 0) {
        $melding = "Voorraad moet een positief nummer zijn.";
    } else {
        $artikel = new Artikel();

        if ($artikel->insertArtikel($row)) {
            $melding = "Artikel succesvol toegevoegd.";
        } else {
            $melding = "Artikel toevoegen mislukt.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuw artikel toevoegen</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Bas Brengt Boodschappen</h1>
    <h2>Nieuw artikel toevoegen</h2>

    <?php if ($melding != ""): ?>
        <p><?= htmlspecialchars($melding) ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="artOmschrijving">Omschrijving:</label><br>
        <input type="text" id="artOmschrijving" name="artOmschrijving" required><br><br>

        <label for="artVerkoop">Verkoopprijs (€):</label><br>
        <input type="number" id="artVerkoop" name="artVerkoop" step="0.01" min="0" required><br><br>

        <label for="artVoorraad">Voorraad:</label><br>
        <input type="number" id="artVoorraad" name="artVoorraad" min="0" required><br><br>

        <input type="submit" name="insert" value="Opslaan">
    </form>

    <br>
    <a href="read.php">Terug naar artikelen</a>

</body>
</html>