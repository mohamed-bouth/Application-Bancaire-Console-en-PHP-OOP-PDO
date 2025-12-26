<?php
class transaction {
    private $compte_id;
    private $id;
    private $type;
    private $amount;
    private $date;

    public function __construct($compte_id, $id, $type, $amount , $date) {
        $this->compte_id = $compte_id;
        $this->id = $id;
        $this->type = $type;
        $this->amount = $amount;
        $this->date = $date;
    }
    public function getInfo(){
        echo "compte_id: ".$this->compte_id." | id: ".$this->id. " | type: ".$this->type." | amount: ".$this->amount;
    }
}