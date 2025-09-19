<?php
class Connection {
    private $host;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $conn;

    public function __construct($host, $dbName, $dbUser, $dbPassword) {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
    }

    public function connect() { 
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName;charset=utf8mb4", $this->dbUser, $this->dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            die("Connessione fallita: " . $e->getMessage());
        }
    }

    // Metodo query con parametri
    public function query($query, $params = []) {
        $stm = $this->conn->prepare($query);
        $stm->execute($params);
        return $stm;
    }

    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne($sql, $params = []) {
        return $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }
    public  function getConn(){
        return $this->conn;
    }
    
}
?>
