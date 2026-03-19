<?php 
// auteur: studentnaam
// functie: verwijderen klant

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;

if (isset($_POST['verwijderen']) && isset($_POST['klantId'])) {
	$klant = new Klant();
	$klantId = (int)$_POST['klantId'];

	if ($klantId > 0 && $klant->deleteKlant($klantId)) {
		header('Location: read.php?deleted=1');
		exit;
	}

	header('Location: read.php?deleted=0');
	exit;
}

header('Location: read.php');
exit;
?>



