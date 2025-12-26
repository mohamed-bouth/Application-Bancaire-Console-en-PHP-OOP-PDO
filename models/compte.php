<?php
abstract class compte {
    protected $id;
    protected $clientId;
    protected $rib;
    protected $solde;

    public function __construct($id, $clientId, $rib, $solde) {

    $this->id = $id;
    $this->clientId = $clientId;
    $this->rib = $rib;
    $this->solde = $solde;

    }

    abstract public function deposerSolde($pdo , $solde);
    abstract public function retirerSolde($pdo , $solde);
    abstract public function envoyerSolde($pdo , $solde);
    abstract public function getRib();
}