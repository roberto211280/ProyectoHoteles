<?php
// Clase para manejar la conexión a la base de datos
class BD {
    private $host = 'localhost';
    private $dbname = 'hoteles';
    private $user = 'root';
    private $password = '';
    private $pdo;
    private static $instance = null;

    private function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public static function conectar() {
        if (self::$instance === null) {
            self::$instance = new self(); // crea la instancia de la clase
        }
        return self::$instance->pdo; // devuelve el objeto PDO
    }
}
?>
