<?php
// auteur: studentnaam
// functie: definitie class Klant
namespace Bas\classes;

use Bas\classes\Database;
use Bas\classes\TableHelper;

class Klant extends Database{
	public $klantId;
	public $klantemail = null;
	public $klantnaam;
	public $klantwoonplaats;
	private $table_name = "klant";	

	// Methods
	
	/**
	 * Summary of crudKlant
	 * @param string $zoeknaam
	 * @return void
	 */
	public function crudKlant(string $zoeknaam = "") : void {
		// Haal alle klanten op uit de database mbv de method getKlanten()
		$lijst = $this->getKlanten($zoeknaam);

		// Print een HTML tabel van de lijst	
		$this->showTable($lijst);
	}

	/**
	 * Summary of getKlanten
	 * @param string $zoeknaam
	 * @return array
	 */
	public function getKlanten(string $zoeknaam = "") : array {
		try {
			if (!empty(trim($zoeknaam))) {
				$stmt = self::$conn->prepare("SELECT * FROM $this->table_name WHERE klantNaam LIKE :zoek OR klantEmail LIKE :zoek OR klantWoonplaats LIKE :zoek");
				$zoekTerm = '%' . trim($zoeknaam) . '%';
				$stmt->execute([':zoek' => $zoekTerm]);
			} else {
				$stmt = self::$conn->query("SELECT * FROM $this->table_name ORDER BY klantNaam ASC");
			}

			return $stmt->fetchAll();
		} catch (\PDOException $e) {
			return [];
		}
	}

 /**
  * Summary of getKlant
  * @param int $klantId
  * @return array
  */
	public function getKlant(int $klantId) : array {
		try {
			$stmt = self::$conn->prepare("SELECT * FROM $this->table_name WHERE klantId = :klantId LIMIT 1");
			$stmt->execute([':klantId' => $klantId]);
			$klant = $stmt->fetch();
			return $klant ? $klant : [];
		} catch (\PDOException $e) {
			return [];
		}
	}
	
	public function dropDownKlant($row_selected = -1){
	
		// Haal alle klanten op uit de database mbv de method getKlanten()
		$lijst = $this->getKlanten();
		
		echo "<label for='Klant'>Choose a klant:</label>";
		echo "<select name='klantId'>";
		foreach ($lijst as $row){
			if($row_selected == $row["klantId"]){
				echo "<option value='$row[klantId]' selected='selected'> $row[klantNaam] $row[klantEmail]</option>\n";
			} else {
				echo "<option value='$row[klantId]'> $row[klantNaam] $row[klantEmail]</option>\n";
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

		$txt = "<table>";

		// Voeg de kolomnamen boven de tabel
		$txt .= TableHelper::getTableHeader($lijst[0]);

		foreach($lijst as $row){
			$txt .= "<tr>";
			$txt .=  "<td>" . $row["klantId"] . "</td>";
			$txt .=  "<td>" . $row["klantNaam"] . "</td>";
			$txt .=  "<td>" . $row["klantEmail"] . "</td>";
			$txt .=  "<td>" . $row["klantWoonplaats"] . "</td>";
			
			//Update
			// Wijzig knopje
        	$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='update.php?klantId={$row['klantId']}' >       
                <button name='update'>Wzg</button>	 
            </form> </td>";

			//Delete
			$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='delete.php'>       
                <input type='hidden' name='klantId' value='{$row['klantId']}'>
                <button name='verwijderen'>Verwijderen</button>	 
            </form> </td>";
			$txt .= "</tr>";
		}
		$txt .= "</table>";
		echo $txt;
	}

	// Delete klant
 /**
  * Summary of deleteKlant
  * @param int $klantId
  * @return bool
  */
	public function deleteKlant(int $klantId) : bool {
		try {
			$stmt = self::$conn->prepare("DELETE FROM $this->table_name WHERE klantId = :klantId");
			return $stmt->execute([':klantId' => $klantId]);
		} catch (\PDOException $e) {
			return false;
		}
	}

	public function updateKlant($row) : bool{
		try {
			$stmt = self::$conn->prepare("UPDATE $this->table_name SET klantNaam = :klantNaam, klantEmail = :klantEmail, klantAdres = :klantAdres, klantPostcode = :klantPostcode, klantWoonplaats = :klantWoonplaats WHERE klantId = :klantId");
			return $stmt->execute([
				':klantNaam' => $row['klantNaam'] ?? '',
				':klantEmail' => $row['klantEmail'] ?? '',
				':klantAdres' => $row['klantAdres'] ?? '',
				':klantPostcode' => $row['klantPostcode'] ?? '',
				':klantWoonplaats' => $row['klantWoonplaats'] ?? '',
				':klantId' => $row['klantId'] ?? 0
			]);
		} catch (\PDOException $e) {
			return false;
		}
	}
	
	
	/**
	 * Summary of BepMaxKlantId
	 * @return int
	 */
	private function BepMaxKlantId() : int {
		
	// Bepaal uniek nummer
	$sql="SELECT MAX(klantId)+1 FROM $this->table_name";
	return  (int) self::$conn->query($sql)->fetchColumn();
}
	
	
	public function insertKlant($row): bool
{
    $sql = "INSERT INTO $this->table_name
            (klantId, klantNaam, klantEmail, klantAdres, klantPostcode, klantWoonplaats)
            VALUES (:klantId, :klantNaam, :klantEmail, :klantAdres, :klantPostcode, :klantWoonplaats)";

    $stmt = self::$conn->prepare($sql);

    return $stmt->execute([
        ':klantId' => $this->BepMaxKlantId(),
        ':klantNaam' => $row['klantNaam'],
        ':klantEmail' => $row['klantEmail'],
        ':klantAdres' => $row['klantAdres'],
        ':klantPostcode' => $row['klantPostcode'],
        ':klantWoonplaats' => $row['klantWoonplaats']
    ]);
}
}
?>