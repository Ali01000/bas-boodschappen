<!--
	Auteur: Studentnaam
	Function: home page CRUD Klant
-->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
	<h1>CRUD Klant</h1>
	<nav>
		<a href='../index.html'>Home</a><br>
		<a href='insert.php'>Toevoegen nieuwe klant</a><br><br>
	</nav>

	<form method="get" action="read.php">
		<label for="zoeknaam">Zoeken op klantnaam/email/woonplaats:</label><br>
		<input type="text" id="zoeknaam" name="zoeknaam" value="<?= htmlspecialchars($_GET['zoeknaam'] ?? '') ?>" placeholder="Typ hier...">
		<input type="submit" value="Zoeken">
		<a href="read.php">Reset</a>
	</form>

	<?php if (isset($_GET['deleted'])): ?>
		<p><?= $_GET['deleted'] == 1 ? 'Klant succesvol verwijderd.' : 'Verwijderen mislukt.' ?></p>
	<?php endif; ?>

	<?php

// Autoloader classes via composer
require '../../vendor/autoload.php';

use Bas\classes\Klant;

// Maak een object Klant
$klant = new Klant;

// Zoekfilter
$zoeknaam = $_GET['zoeknaam'] ?? '';

// Start CRUD
$klant->crudKlant($zoeknaam);

?>
</body>
</html>