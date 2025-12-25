<?php 
class compteRepo {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function ajouteCompte($clientId , $compteType){
        try {
            $sql = "INSERT INTO comptes (client_id , solde , compte_type) VALUES( :client_id, 0 , :compte_type)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ":client_id" => $clientId,
                ":compte_type" => $compteType
            ]);
        } catch (Exception $e) {
            echo $e;
        }
    }
    public function SupprimeCompte($clientId , $compteType){
        try {
        $sql = "SELECT * FROM comptes WHERE client_id = :client_id AND compte_type = :compte_type AND solde = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":client_id" => $clientId,
            ":compte_type" => $compteType
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            echo "thier no compte or compte with solde 0";
            return;
        }

        $sql = "DELETE FROM comptes WHERE client_id = :client_id AND compte_type = :compte_type";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":client_id" => $clientId,
            ":compte_type" => $compteType
        ]);

        echo "the compte has removed succesfuly";

        } catch (Exception $e) {
            echo $e;
        }
    }
}