<?php
include "./models/compte.php";
class compteCourant extends compte {
    public static $depositFee = 1;

    public function __construct($id , $clientId){
        parent::__construct($id , $clientId);

    }
    public function deposerSolde($solde){}
    public function retirerSolde($solde){}
    public function envoyerSolde($solde){}
}
