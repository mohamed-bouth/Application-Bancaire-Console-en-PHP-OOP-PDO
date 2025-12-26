<?php 
class client {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $dateDeCreation;

    public function __construct($id , $nom , $prenom , $email , $dateDeCreation){
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->dateDeCreation = $dateDeCreation;
    }

    public function getComptes($pdo){
        try {
            $sql = "SELECT * FROM clients cl JOIN comptes cm ON cl.id = cm.client_id WHERE cl.id = :client_id ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":client_id"=> $this->id]);
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
    public function getInformation(){
        echo "#". $this->id ." | nom: ". $this->nom ." | prenom: ". $this->prenom ." | email: ". $this->email ." | date de creation: ". $this->dateDeCreation ;
        echo "<br>";
    }
    public function getEmail(){
        return $this->email;
    }
    public function getId(){
        return $this->id;
    }
}