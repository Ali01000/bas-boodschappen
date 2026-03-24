<?php
/*
    Auteur: Studentnaam
    Function: Read.php – CRUD Klant + Artikelen
*/

// Fouten zichtbaar maken
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoloader classes via Composer
require 'vendor/autoload.php'; // pas pad aan als nodig

use Bas\classes\Klant;
use Bas\classes\Artikel;

// Objecten aanmaken
$klant = new Klant;
$artikel = new Artikel;

// Zoekfilters
$zoeknaam = $_GET['zoeknaam'] ?? '';
$zoekartikel = $_GET['zoekartikel'] ?? '';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD BAS</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1, h2 { color: #333; }
        nav a { display: inline-block; margin: 5px; padding: 6px 12px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 4px; }
        nav a:hover { background-color: #0056b3; }
        form { margin-bottom: 20px; }
        input[type="text"] { padding: 6px; width: 250px; }
        input[type="submit"] { padding: 6px 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: left; }
        a.button { text-decoration: none; background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; }
        a.button:hover { background-color: #218838; }
    </style>
</head>
<body>
    <h1>CRUD BAS</h1>
    <nav>
        <a href="index.php">Home</a><br>
        <a href="insert.php">Toevoegen nieuwe klant</a>
        <a href="create_artikel.php">Toevoegen nieuw artikel</a><br><br>
        <a href="read.php">Bekijk klanten</a>
        <a href="read.php?view=artikelen">Bekijk artikelen</a><br><br>
    </nav>

    <!-- Zoekfunctie Klant -->
    <h2>Zoeken Klant</h2>
    <form method="get" action="">
        <label for="zoeknaam">Zoeken op klantnaam/email/woonplaats:</label><br>
        <input type="text" id="zoeknaam" name="zoeknaam" value="<?= htmlspecialchars($zoeknaam) ?>" placeholder="Typ hier...">
        <input type="submit" value="Zoeken">
        <a href="read.php">Reset</a>
    </form>

    <?php
    // CRUD Klant uitvoeren
    echo "<h2>Klanten</h2>";
    $klant->crudKlant($zoeknaam);

    // Zoekfunctie Artikelen
    ?>
    <h2>Zoeken Artikelen</h2>
    <form method="get" action="">
        <label for="zoekartikel">Zoeken op artikelnaam/prijs:</label><br>
        <input type="text" id="zoekartikel" name="zoekartikel" value="<?= htmlspecialchars($zoekartikel) ?>" placeholder="Typ hier...">
        <input type="submit" value="Zoeken">
        <a href="read.php">Reset</a>
    </form>

    <?php
    // CRUD Artikelen uitvoeren
    echo "<h2>Artikelen</h2>";
    $artikel->crudArtikel($zoekartikel);
    ?>
</body>
</html>