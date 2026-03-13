<?php 
// auteur: studentnaam
// functie: 

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;

$klant = new Klant;

if (isset($_POST["verwijderen"]) && isset($_GET["klantId"])) {
	$ok = $klant->deleteKlant((int) $_GET["klantId"]);

	if ($ok) {
		echo '<script>alert("Klant verwijderd")</script>';
	} else {
		echo '<script>alert("Verwijderen mislukt")</script>';
	}

	echo "<script> location.replace('read.php'); </script>";
	exit;
}

echo '<script>alert("Geen geldige verwijderactie")</script>';
echo "<script> location.replace('read.php'); </script>";
exit;
?>

