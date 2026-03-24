<?php
// auteur: studentnaam
// functie: unittests class Artikel

use PHPUnit\Framework\TestCase;
use Bas\classes\Artikel;

class ArtikelTest extends TestCase{

    protected $artikel;

    protected function setUp(): void {
        $this->artikel = new Artikel();
    }

    public function testgetArtikelen(){
        $artikelen = $this->artikel->getArtikelen();
        $this->assertIsArray($artikelen);
        $this->assertTrue(count($artikelen) >= 0, "Aantal moet 0 of groter zijn");
    }

    public function testGetArtikel(){
        $artId = 1;
        $artikel = $this->artikel->getArtikel($artId);
        if (!empty($artikel)) {
            $this->assertEquals($artId, $artikel['artId']);
        } else {
            $this->assertEmpty($artikel);
        }
    }

    public function testInsertArtikel()
    {
        $row = [
            'artOmschrijving' => 'Test Art',
            'artVerkoop' => 9.99,
            'artVoorraad' => 10
        ];

        $result = $this->artikel->insertArtikel($row);

        $this->assertTrue($result, "Insert van artikel moet slagen");
    }

    public function testUpdateArtikel()
    {
        // Eerst een artikel toevoegen om te kunnen updaten
        $insertRow = [
            'artOmschrijving' => 'Test Art',
            'artVerkoop' => 5.00,
            'artVoorraad' => 5
        ];
        $this->artikel->insertArtikel($insertRow);

        // Haal het laatst toegevoegde artikel op
        $artikelen = $this->artikel->getArtikelen();
        $laatsteArtikel = end($artikelen);

        // Update het artikel
        $updateRow = [
            'artId' => $laatsteArtikel['artId'],
            'artOmschrijving' => 'Updated Art',
            'artVerkoop' => 7.50,
            'artVoorraad' => 8
        ];

        $result = $this->artikel->updateArtikel($updateRow);
        $this->assertTrue($result, "Update van artikel moet slagen");

        // Controleer of de update is doorgevoerd
        $bijgewerktArtikel = $this->artikel->getArtikel($laatsteArtikel['artId']);
        $this->assertEquals('Updated Art', $bijgewerktArtikel['artOmschrijving']);
        $this->assertEquals(7.50, $bijgewerktArtikel['artVerkoop']);
        $this->assertEquals(8, $bijgewerktArtikel['artVoorraad']);
    }

    public function testDeleteArtikel()
    {
        // Eerst een artikel toevoegen om te kunnen verwijderen
        $insertRow = [
            'artOmschrijving' => 'Del Art',
            'artVerkoop' => 3.00,
            'artVoorraad' => 2
        ];
        $this->artikel->insertArtikel($insertRow);

        // Haal het laatst toegevoegde artikel op
        $artikelen = $this->artikel->getArtikelen();
        $laatsteArtikel = end($artikelen);
        $artId = $laatsteArtikel['artId'];

        // Verwijder het artikel
        $result = $this->artikel->deleteArtikel($artId);
        $this->assertTrue($result, "Delete van artikel moet slagen");

        // Controleer of het artikel is verwijderd
        $verwijderdArtikel = $this->artikel->getArtikel($artId);
        $this->assertEmpty($verwijderdArtikel, "Artikel moet verwijderd zijn");
    }

    public function testGetNonExistentArtikel()
    {
        $artikel = $this->artikel->getArtikel(99999); // Niet-bestaand ID
        $this->assertEmpty($artikel, "Niet-bestaand artikel moet leeg array teruggeven");
    }

    public function testDropDownArtikel()
    {
        // Test de dropdown functie
        ob_start(); // Buffer output
        $this->artikel->dropDownArtikel();
        $output = ob_get_clean();

        $this->assertTrue(strpos($output, "select name='artId'") !== false, "Dropdown moet een select element bevatten");
        $this->assertTrue(strpos($output, 'Choose a artikel') !== false, "Dropdown moet een label bevatten");
    }

    public function testShowTable()
    {
        // Test de tabel weergave functie
        $artikelen = $this->artikel->getArtikelen();

        ob_start(); // Buffer output
        $this->artikel->showTable($artikelen);
        $output = ob_get_clean();

        if (!empty($artikelen)) {
            $this->assertTrue(strpos($output, '<table>') !== false, "Tabel moet table element bevatten");
            $this->assertTrue(strpos($output, '<tr>') !== false, "Tabel moet rijen bevatten");
        } else {
            $this->assertTrue(strpos($output, 'Geen artikelen gevonden') !== false, "Lege tabel moet melding tonen");
        }
    }
}
?>