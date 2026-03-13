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
	private $table_name = "klanten";	

	// Methods
	
	/**
	 * Summary of crudKlant
	 * @return void
	 */
	public function crudKlant() : void {
		// Haal alle klant op uit de database mbv de method getKlant()
		$lijst = $this->getKlanten();

		// Print een HTML tabel van de lijst	
		$this->showTable($lijst);
	}

	/**
	 * Summary of getKlant
	 * @return mixed
	 */
	public function getKlanten() : array {
		$sql = "SELECT klantId, klantNaam, klantEmail, klantWoonplaats FROM klanten";
		$lijst = self::$conn->query($sql)->fetchAll();
		
		return $lijst;
	}

 /**
  * Summary of getKlant
  * @param int $klantId
  * @return mixed
  */
	public function getKlant(int $klantId) : array {

		$sql = "SELECT * FROM klanten WHERE klantId = :klantId";
		$stmt = self::$conn->prepare($sql);
		$stmt->execute(['klantId' => $klantId]);
		
		$row = $stmt->fetch();

		return $row ? $row : [];
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
		if (empty($lijst)) {
			echo "Geen klanten gevonden.";
			return;
		}

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
            <form method='post' action='delete.php?klantId={$row['klantId']}' >       
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
		// First delete related verkooporders
		$sql_verkoop = "DELETE FROM verkooporders WHERE klantId = :klantId";
		$stmt_verkoop = self::$conn->prepare($sql_verkoop);
		$stmt_verkoop->execute(['klantId' => $klantId]);

		// Then delete the klant
		$sql = "DELETE FROM $this->table_name WHERE klantId = :klantId";
		$stmt = self::$conn->prepare($sql);

		return $stmt->execute([
			'klantId' => $klantId
		]);
	
	}

	public function updateKlant($row) : bool{
		$sql = "UPDATE $this->table_name
		        SET klantNaam = :klantNaam,
		            klantEmail = :klantEmail,
		            klantAdres = :klantAdres,
		            klantPostcode = :klantPostcode,
		            klantWoonplaats = :klantWoonplaats
		        WHERE klantId = :klantId";

		$stmt = self::$conn->prepare($sql);

		return $stmt->execute([
			'klantId' => (int) ($row['klantId'] ?? 0),
			'klantNaam' => $row['klantnaam'] ?? ($row['klantNaam'] ?? null),
			'klantEmail' => $row['klantemail'] ?? ($row['klantEmail'] ?? null),
			'klantAdres' => $row['klantadres'] ?? ($row['klantAdres'] ?? null),
			'klantPostcode' => !empty($row['klantpostcode']) ? $row['klantpostcode'] : (!empty($row['klantPostcode']) ? $row['klantPostcode'] : null),
			'klantWoonplaats' => !empty($row['klantwoonplaats']) ? $row['klantwoonplaats'] : (!empty($row['klantWoonplaats']) ? $row['klantWoonplaats'] : null)
		]);
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
	
	
	/**
	 * Summary of insertKlant
	 * @param mixed $row
	 * @return mixed
	 */
	public function insertKlant($row){
		$sql = "INSERT INTO $this->table_name 
		        (klantNaam, klantEmail, klantAdres, klantPostcode, klantWoonplaats)
		        VALUES
		        (:klantNaam, :klantEmail, :klantAdres, :klantPostcode, :klantWoonplaats)";

		$stmt = self::$conn->prepare($sql);

		return $stmt->execute([
			'klantNaam' => $row['klantnaam'] ?? ($row['klantNaam'] ?? null),
			'klantEmail' => $row['klantemail'] ?? ($row['klantEmail'] ?? null),
			'klantAdres' => $row['klantadres'] ?? ($row['klantAdres'] ?? null),
			'klantPostcode' => !empty($row['klantpostcode']) ? $row['klantpostcode'] : (!empty($row['klantPostcode']) ? $row['klantPostcode'] : null),
			'klantWoonplaats' => !empty($row['klantwoonplaats']) ? $row['klantwoonplaats'] : (!empty($row['klantWoonplaats']) ? $row['klantWoonplaats'] : null)
		]);
	}
}
?>
