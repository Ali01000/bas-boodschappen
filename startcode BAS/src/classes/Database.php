<?php
namespace Bas\classes;

use PDO;
use PDOException;

require_once __DIR__ . "/../config/config.php";

class Database {

    protected static $conn = NULL;

    public function __construct() {
        if (!self::$conn) {
            try {
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];

                self::$conn = new PDO(
                    "mysql:host=" . SERVERNAME . ";dbname=" . DATABASE,
                    USERNAME,
                    PASSWORD,
                    $options
                );
            } catch (PDOException $e) {
                echo "Connectie mislukt: " . $e->getMessage();
            }
        }
    }

    public function getConnection() {
        return self::$conn;
    }
}
?>