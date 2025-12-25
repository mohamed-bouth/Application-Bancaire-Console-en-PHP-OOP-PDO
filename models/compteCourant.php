<?php
class compteCourant extends compte {
    private static $depositFee = 1;
    private static $decouvert_max = - 500;

    public function __construct($id , $clientId , $solde){
        parent::__construct($id , $clientId , $solde);
    }
    public function deposerSolde($pdo , $solde){
        try {
            $newSolde = $this->solde + $solde - self::$depositFee;
            $sql = "UPDATE comptes SET solde = :solde WHERE client_id = :client_id AND compte_type = 'courant' ";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([
                ":solde"=> $newSolde,
                ":client_id"=> $this->clientId
            ]);
            $this->solde = $newSolde;
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
            $sql = "UPDATE comptes SET solde = :solde WHERE client_id = :client_id AND compte_type = 'courant' ";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([
                ":solde"=> $newSolde,
                ":client_id"=> $this->clientId
            ]);
            $this->solde = $newSolde;
        }catch(Exception $e){
            echo $e;
        }
        $this->solde = $newSolde;
        echo "solde: " . $this->solde;
    }
    public function envoyerSolde($pdo , $solde){}
}
