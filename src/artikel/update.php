<?php
// auteur: studentnaam
// functie: update class Artikel

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Artikel;

$artikel = new Artikel;
$bericht = "";
$row = [];

if (isset($_POST["update"]) && $_POST["update"] == "Wijzigen") {
    if ($artikel->updateArtikel($_POST)) {
        echo '<script>alert("Artikel gewijzigd")</script>';
        echo "<script> location.replace('read.php'); </script>";
        exit;
    }

    $bericht = "Wijzigen mislukt.";
    $row = $_POST;
} elseif (isset($_GET['artId'])) {
    $row = $artikel->getArtikel((int) $_GET['artId']);
    if (empty($row)) {
        $bericht = "Artikel niet gevonden.";
    }
} else {
    $bericht = "Geen artId opgegeven.";
}

$showForm = !empty($row);

$artId = $row['artId'] ?? '';
$artOmschrijving = $row['artOmschrijving'] ?? '';
$artVerkoop = $row['artVerkoop'] ?? '';
$artVoorraad = $row['artVoorraad'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<h1>CRUD Artikel</h1>
<h2>Wijzigen</h2>
<?php if ($bericht !== "") { echo "<p>$bericht</p>"; } ?>
<?php if ($showForm) { ?>
<form method="post">
<input type="hidden" name="artId"
    value="<?php echo htmlspecialchars((string) $artId, ENT_QUOTES, 'UTF-8'); ?>">
<label for="artOmschrijving">Omschrijving:</label><br>
<input type="text" name="artOmschrijving" required
    value="<?php echo htmlspecialchars((string) $artOmschrijving, ENT_QUOTES, 'UTF-8'); ?>"><br><br>
<label for="artVerkoop">Verkoopprijs (€):</label><br>
<input type="number" name="artVerkoop" step="0.01" min="0" required
    value="<?php echo htmlspecialchars((string) $artVerkoop, ENT_QUOTES, 'UTF-8'); ?>"><br><br>
<label for="artVoorraad">Voorraad:</label><br>
<input type="number" name="artVoorraad" min="0" required
    value="<?php echo htmlspecialchars((string) $artVoorraad, ENT_QUOTES, 'UTF-8'); ?>"><br><br>
<input type="submit" name="update" value="Wijzigen">
</form></br>
<?php } ?>

<a href="read.php">Terug</a>

</body>
</html>