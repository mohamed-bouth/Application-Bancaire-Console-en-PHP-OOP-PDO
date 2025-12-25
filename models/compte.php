<?php
abstract class compte {
    protected $id;
    protected $clientId;
    protected $solde;

    public function __construct($id, $clientId, $solde) {

    $this->id = $id;
    $this->clientId = $clientId;
    $this->solde = $solde;

    }

    abstract public function deposerSolde($solde);
    abstract public function retirerSolde($solde);
    abstract public function envoyerSolde($solde);
}