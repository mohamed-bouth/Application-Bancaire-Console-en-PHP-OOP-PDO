<?php

class database{
    private static $instance = null;
    private PDO $conn;

    private function __construct(){
        $this->conn = new PDO("mysql:host=localhost;dbname=bank_db;charset=utf8","root","");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public static function getInstance(){
        if (self::$instance === null){
            self::$instance = new database();
        }
        return self::$instance;

    }


    public function getConnection():PDO {
        return $this->conn;
    }

   
}

$pdo = database::getInstance()->getConnection();

?>
