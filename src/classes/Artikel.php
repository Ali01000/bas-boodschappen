<?php
// auteur: studentnaam
// functie: definitie class Artikel
namespace Bas\classes;

use Bas\classes\Database;
use Bas\classes\TableHelper;

class Artikel extends Database{
	public $artId;
	public $artOmschrijving;
	public $artInkoop;
	public $artVerkoop;
	public $artVoorraad;
	public $artMinVoorraad;
	public $artMaxVoorraad;
	public $artLocatie;
	private $table_name = "artikelen";

	// Methods

	/**
	 * Summary of crudArtikel
	 * @return void
	 */
	public function crudArtikel() : void {
		// Haal alle artikelen op uit de database mbv de method getArtikelen()
		$lijst = $this->getArtikelen();

		// Print een HTML tabel van de lijst
		$this->showTable($lijst);
	}

	/**
	 * Summary of getArtikelen
	 * @return mixed
	 */
	public function getArtikelen() : array {
		$sql = "SELECT artId, artOmschrijving, artVerkoop, artVoorraad FROM artikelen";
		$lijst = self::$conn->query($sql)->fetchAll();

		return $lijst;
	}

 /**
  * Summary of getArtikel
  * @param int $artId
  * @return mixed
  */
	public function getArtikel(int $artId) : array {

		$sql = "SELECT * FROM artikelen WHERE artId = :artId";
		$stmt = self::$conn->prepare($sql);
		$stmt->execute(['artId' => $artId]);

		$row = $stmt->fetch();

		return $row ? $row : [];
	}

	public function dropDownArtikel($row_selected = -1){

		// Haal alle artikelen op uit de database mbv de method getArtikelen()
		$lijst = $this->getArtikelen();

		echo "<label for='Artikel'>Choose a artikel:</label>";
		echo "<select name='artId'>";
		foreach ($lijst as $row){
			if($row_selected == $row["artId"]){
				echo "<option value='$row[artId]' selected='selected'> $row[artOmschrijving] (€$row[artVerkoop])</option>\n";
			} else {
				echo "<option value='$row[artId]'> $row[artOmschrijving] (€$row[artVerkoop])</option>\n";
			}
		}
		echo "</select>";
	}

 /**
  * Summary of showTable
  * @param mixed $lijst
  * @return void
  */
	public function showTable($lijst) : void {
		if (empty($lijst)) {
			echo "Geen artikelen gevonden.";
			return;
		}

		$txt = "<table>";

		// Voeg de kolomnamen boven de tabel
		$txt .= TableHelper::getTableHeader($lijst[0]);

		foreach($lijst as $row){
			$txt .= "<tr>";
			$txt .=  "<td>" . $row["artId"] . "</td>";
			$txt .=  "<td>" . $row["artOmschrijving"] . "</td>";
			$txt .=  "<td>€" . number_format($row["artVerkoop"], 2) . "</td>";
			$txt .=  "<td>" . $row["artVoorraad"] . "</td>";

			//Update
			// Wijzig knopje
        	$txt .=  "<td>";
			$txt .= "
            <form method='post' action='update.php?artId={$row['artId']}' >
                <button name='update'>Wzg</button>
            </form> </td>";

			//Delete
			$txt .=  "<td>";
			$txt .= "
            <form method='post' action='delete.php?artId={$row['artId']}' >
                <button name='verwijderen'>Verwijderen</button>
            </form> </td>";
			$txt .= "</tr>";
		}
		$txt .= "</table>";
		echo $txt;
	}

	// Delete artikel
 /**
  * Summary of deleteArtikel
  * @param int $artId
  * @return bool
  */
	public function deleteArtikel(int $artId) : bool {
		// First delete related inkooporders
		$sql_inkoop = "DELETE FROM inkooporders WHERE artId = :artId";
		$stmt_inkoop = self::$conn->prepare($sql_inkoop);
		$stmt_inkoop->execute(['artId' => $artId]);

		// Then delete related verkooporders
		$sql_verkoop = "DELETE FROM verkooporders WHERE artId = :artId";
		$stmt_verkoop = self::$conn->prepare($sql_verkoop);
		$stmt_verkoop->execute(['artId' => $artId]);

		// Then delete the artikel
		$sql = "DELETE FROM $this->table_name WHERE artId = :artId";
		$stmt = self::$conn->prepare($sql);

		return $stmt->execute([
			'artId' => $artId
		]);

	}

	public function updateArtikel($row) : bool{
		$sql = "UPDATE $this->table_name
		        SET artOmschrijving = :artOmschrijving,
		            artVerkoop = :artVerkoop,
		            artVoorraad = :artVoorraad
		        WHERE artId = :artId";

		$stmt = self::$conn->prepare($sql);

		return $stmt->execute([
			'artId' => (int) ($row['artId'] ?? 0),
			'artOmschrijving' => $row['artOmschrijving'] ?? null,
			'artVerkoop' => $row['artVerkoop'] ?? null,
			'artVoorraad' => $row['artVoorraad'] ?? null
		]);
	}


	/**
	 * Summary of insertArtikel
	 * @param mixed $row
	 * @return mixed
	 */
	public function insertArtikel($row){
		$sql = "INSERT INTO $this->table_name
		        (artOmschrijving, artVerkoop, artVoorraad)
		        VALUES
		        (:artOmschrijving, :artVerkoop, :artVoorraad)";

		$stmt = self::$conn->prepare($sql);

		return $stmt->execute([
			'artOmschrijving' => $row['artOmschrijving'] ?? null,
			'artVerkoop' => $row['artVerkoop'] ?? null,
			'artVoorraad' => $row['artVoorraad'] ?? null
		]);
	}
}
?>