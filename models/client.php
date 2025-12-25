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

    public function getComptes(){}
    public function getInformation(){
        echo "#". $this->id ." | nom: ". $this->nom ." | prenom: ". $this->prenom ." | email: ". $this->email ." | date de creation: ". $this->dateDeCreation ;
        echo "<br>";
    }
    public function getEmail(){
        return $this->email;
    }
}