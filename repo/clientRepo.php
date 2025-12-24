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

    public function modifieClient($nom , $prenom , $email){
        $sql = "SELECT * FROM clients WHERE email = :email";
        $stmt1 = $this->db->prepare($sql);
        $stmt1->execute([
            ":email" => $email
        ]);
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        if(!$result1){
            exit();
        }

        $id = $result1[0]["id"];
        try {
            $sql = "UPDATE clients SET nom = :nom , prenom = :prenom , email = :email WHERE id = :id";
            $stmt2 = $this->db->prepare($sql);
            $stmt2->execute([
                ":nom" => $nom,
                ":prenom" => $prenom,
                ":email" => $email,
                ":id" => $id
            ]);

            $sql = "SELECT * FROM clients WHERE id = :id";
            $stmt3 = $this->db->prepare($sql);
            $stmt3->execute([
                ":id" => $id
            ]);
            print_r($stmt3->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print_r($e);
        }
    }

}