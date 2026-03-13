<?php
// auteur: studentnaam
// functie: update class Klant

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;

$klant = new Klant;
$bericht = "";
$row = [];

if (isset($_POST["update"]) && $_POST["update"] == "Wijzigen") {
    if ($klant->updateKlant($_POST)) {
        echo '<script>alert("Klant gewijzigd")</script>';
        echo "<script> location.replace('read.php'); </script>";
        exit;
    }

    $bericht = "Wijzigen mislukt.";
    $row = $_POST;
} elseif (isset($_GET['klantId'])) {
    $row = $klant->getKlant((int) $_GET['klantId']);
    if (empty($row)) {
        $bericht = "Klant niet gevonden.";
    }
} else {
    $bericht = "Geen klantId opgegeven.";
}

$showForm = !empty($row);

$klantId = $row['klantId'] ?? '';
$klantNaam = $row['klantnaam'] ?? ($row['klantNaam'] ?? '');
$klantEmail = $row['klantemail'] ?? ($row['klantEmail'] ?? '');
$klantAdres = $row['klantadres'] ?? ($row['klantAdres'] ?? '');
$klantPostcode = $row['klantpostcode'] ?? ($row['klantPostcode'] ?? '');
$klantWoonplaats = $row['klantwoonplaats'] ?? ($row['klantWoonplaats'] ?? '');
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
<h1>CRUD Klant</h1>
<h2>Wijzigen</h2>	
<?php if ($bericht !== "") { echo "<p>$bericht</p>"; } ?>
<?php if ($showForm) { ?>
<form method="post">
<input type="hidden" name="klantId" 
    value="<?php echo htmlspecialchars((string) $klantId, ENT_QUOTES, 'UTF-8'); ?>">
<input type="text" name="klantnaam" required 
    value="<?php echo htmlspecialchars((string) $klantNaam, ENT_QUOTES, 'UTF-8'); ?>"> *</br>
<input type="text" name="klantemail" required 
    value="<?php echo htmlspecialchars((string) $klantEmail, ENT_QUOTES, 'UTF-8'); ?>"> *</br>
<input type="text" name="klantadres" required 
    value="<?php echo htmlspecialchars((string) $klantAdres, ENT_QUOTES, 'UTF-8'); ?>"> *</br>
<input type="text" name="klantpostcode" 
    value="<?php echo htmlspecialchars((string) $klantPostcode, ENT_QUOTES, 'UTF-8'); ?>"> </br>
<input type="text" name="klantwoonplaats" 
    value="<?php echo htmlspecialchars((string) $klantWoonplaats, ENT_QUOTES, 'UTF-8'); ?>"> </br></br>
<input type="submit" name="update" value="Wijzigen">
</form></br>
<?php } ?>

<a href="read.php">Terug</a>

</body>
</html>
