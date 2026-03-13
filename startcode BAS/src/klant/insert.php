<?php
// functie: nieuwe klant toevoegen

require '../../vendor/autoload.php';

use Bas\classes\Klant;

$melding = "";

if (isset($_POST["insert"])) {
    $row = [
        'klantNaam' => $_POST['klantNaam'] ?? '',
        'klantEmail' => $_POST['klantEmail'] ?? '',
        'klantAdres' => $_POST['klantAdres'] ?? '',
        'klantPostcode' => $_POST['klantPostcode'] ?? '',
        'klantWoonplaats' => $_POST['klantWoonplaats'] ?? ''
    ];

    if (
        empty($row['klantNaam']) ||
        empty($row['klantEmail']) ||
        empty($row['klantAdres']) ||
        empty($row['klantPostcode']) ||
        empty($row['klantWoonplaats'])
    ) {
        $melding = "Vul alle velden in.";
    } elseif (!filter_var($row['klantEmail'], FILTER_VALIDATE_EMAIL)) {
        $melding = "Ongeldig emailadres.";
    } else {
        $klant = new Klant();

        if ($klant->insertKlant($row)) {
            $melding = "Klant succesvol toegevoegd.";
        } else {
            $melding = "Klant toevoegen mislukt.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe klant toevoegen</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <h1>Bas Brengt Boodschappen</h1>
    <h2>Nieuwe klant toevoegen</h2>

    <?php if ($melding != ""): ?>
        <p><?= htmlspecialchars($melding) ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="klantNaam">Naam:</label><br>
        <input type="text" id="klantNaam" name="klantNaam" required><br><br>

        <label for="klantEmail">Email:</label><br>
        <input type="email" id="klantEmail" name="klantEmail" required><br><br>

        <label for="klantAdres">Straat + huisnummer:</label><br>
        <input type="text" id="klantAdres" name="klantAdres" required><br><br>

        <label for="klantPostcode">Postcode:</label><br>
        <input type="text" id="klantPostcode" name="klantPostcode" required><br><br>

        <label for="klantWoonplaats">Woonplaats:</label><br>
        <input type="text" id="klantWoonplaats" name="klantWoonplaats" required><br><br>

        <input type="submit" name="insert" value="Opslaan">
    </form>

    <br>
    <a href="read.php">Terug naar klanten</a>

</body>
</html>