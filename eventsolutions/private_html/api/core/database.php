<?php
class Database{

    private $host = "localhost";
    private $db_name = "u10448d24532_eventsolutions";
    private $username = "u10448d24532_ES";
    private $password = "P2v984nQ";
    public $conn;
  
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>