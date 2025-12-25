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

    abstract public function deposerSolde($pdo , $solde);
    abstract public function retirerSolde($pdo , $solde);
    abstract public function envoyerSolde($pdo , $solde);
}