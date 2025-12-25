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
}