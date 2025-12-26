<?php
class compteEpargne extends compte {
    private static $depositFee = 1;
    private static $decouvert_max = 0;

    public function __construct($id , $clientId , $rib , $solde){
        parent::__construct($id , $clientId , $rib , $solde);
    }
    public function deposerSolde($pdo , $solde){
        try {
            $newSolde = $this->solde + $solde;
            $sql = "UPDATE comptes SET solde = :solde WHERE client_id = :client_id AND compte_type = 'epargne' ";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([
                ":solde"=> $newSolde,
                ":client_id"=> $this->clientId
            ]);
            $this->solde = $newSolde;
            $sql = "INSERT INTO transactions (compte_id , transaction_type , amount) VALUES ( :compte_id , 'deposer' , :amount )";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([
                ":compte_id" => $this->id,
                ":amount"=>  $solde
            ]);
        }catch(Exception $e){
            echo $e;
        }
    }
    public function retirerSolde($pdo , $solde){
        $newSolde = $this->solde - $solde;
        echo $newSolde . " = "  . $this->solde . " - " . $solde;

        if($newSolde < self::$decouvert_max){
            echo "we cant make this process !";
            return;
        }

        try{
            $sql = "UPDATE comptes SET solde = :solde WHERE client_id = :client_id AND compte_type = 'epargne' ";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([
                ":solde"=> $newSolde,
                ":client_id"=> $this->clientId
            ]);
            $this->solde = $newSolde;
            $sql = "INSERT INTO transactions (compte_id , transaction_type , amount) VALUES ( :compte_id , 'retirer' , :amount )";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([
                ":compte_id" => $this->id,
                ":amount"=>  -$solde
            ]);
        }catch(Exception $e){
            echo $e;
        }
        $this->solde = $newSolde;
        echo "solde: " . $this->solde;
    }
    public function envoyerSolde($pdo , $rib ,  $solde){
        if($solde > $this->solde){
            return;
        }

        $newSolde = $this->solde - $solde;
        $enterAdmin = new compteRepo($pdo);
        $comptes = $enterAdmin->renderComptes();
        $compte = $enterAdmin->chercheCompte($rib , $comptes);
        if(!$compte){
            return;
        }

        try {
            $newSendSolde = $compte->getSolde() + $solde;
            echo $newSendSolde . " = " . $compte->getSolde() . " + " . $solde;

            $sql = "UPDATE comptes SET solde = :solde WHERE client_id = :client_id AND rib = :rib ";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([
                ":solde"=> $newSolde,
                ":client_id"=> $this->clientId,
                ":rib"=> $this->rib
            ]);

            $sql = "UPDATE comptes SET solde = :solde WHERE client_id = :client_id AND rib = :rib ";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([
                ":solde"=> $newSendSolde,
                ":client_id"=> $compte->getClientId(),
                ":rib"=> $rib
            ]);
            $sql = "INSERT INTO transactions (compte_id , transaction_type , amount) VALUES ( :compte_id , 'envoyer' , :amount )";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([
                ":compte_id" => $this->id,
                ":amount"=>  -$solde
            ]);
            $sql = "INSERT INTO transactions (compte_id , transaction_type , amount) VALUES ( :compte_id , 'envoyer' , :amount )";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([
                ":compte_id" => $compte->getId(),
                ":amount"=>  $solde
            ]);
        } catch(Exception $e){
            echo $e;
        }

    }
    public function getInfo(){
        echo "#" . $this->id . " | clientId: ". $this->clientId . " | rib: " . $this->rib . " | solde: ". $this->solde . "<br>";
    }
    public function getRib(){
        return $this->rib;
    }
    public function getSolde(){
        return $this->solde;
    }
    public function getClientId() {
        return $this->clientId;
    }
    public function getId(){
        return $this->id;
    }
}