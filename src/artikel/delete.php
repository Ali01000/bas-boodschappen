<?php
// auteur: studentnaam
// functie:

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Artikel;

$artikel = new Artikel;

if (isset($_POST["verwijderen"]) && isset($_GET["artId"])) {
	$ok = $artikel->deleteArtikel((int) $_GET["artId"]);

	if ($ok) {
		echo '<script>alert("Artikel verwijderd")</script>';
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