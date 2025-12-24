<?php
class clientRepo {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function ajouteClient($nom , $prenom , $email){
        try {
            $sql = "INSERT INTO clients (nom , prenom , email)
            VALUES (:nom, :prenom, :email)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ":nom" => $nom,
                ":prenom" => $prenom,
                ":email" => $email
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            print_r($result);
        } catch (Exception $e) {
            echo($e);
        }
    }
}