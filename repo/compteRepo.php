<?php 
class compteRepo {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function ajouteCompte($clientId , $compteType){
        try {
            $randomNumber = random_int(1000000 , 9999999);
            $sql = "INSERT INTO comptes (client_id , rib , solde , compte_type) VALUES( :client_id, :rib , 0 , :compte_type)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ":client_id" => $clientId,
                ":compte_type" => $compteType,
                ":rib" => $randomNumber
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

    public function afficheCompte(){
        try {
            $sql = "SELECT * FROM clients cl JOIN comptes cm ON cl.id = cm.client_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$comptes){
                echo "thier no compte !";
                return;
            }
            foreach ($comptes as $compte) {
                echo "#" . $compte['id'] .  " |nom: " . $compte["nom"] ." | prenom: ". $compte["prenom"] . " | email :" . $compte["email"] . " | rib: " . $compte["rib"] . " | solde: ". $compte["solde"] . " | compte_type: " . $compte["compte_type"] . "<br>";
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
    public function renderComptes(){
        try {
            $sql = "SELECT * FROM comptes";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!$results){
                echo "thier no compte !";
                return;
            }
            $comptes = [];
            $i = 0;
            foreach ($results as $compte) {
                if($compte["compte_type"] == "courant"){
                    $comptes[$i] = new compteCourant ($compte["id"] , $compte["client_id"] , $compte["rib"] , $compte["solde"]);
                }else{
                    $comptes[$i] = new compteEpargne ($compte["id"] , $compte["client_id"] , $compte["rib"] , $compte["solde"]);
                }
                $i++;
            }   
            return $comptes;
        } catch (Exception $e) {
            echo $e;
        }
    }
    public function chercheCompte($rib , $comptes){
        foreach ( $comptes as  $compte) {
            $flag = false;
           if( $compte->getRib() == $rib ){
                $flag = true;
                echo "+ we found compte with rib: " . $rib . "<br>";
                return $compte;
            }
        }
        if(!$flag){
            echo "- we dont found compte with rib: " . $rib . "<br>";
        }
    }
}