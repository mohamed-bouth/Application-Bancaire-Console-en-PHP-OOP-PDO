<?php
class transactionRepo{
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }
    public function renderTransaction(){
        try {
            $sql = "SELECT * FROM transactions";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $transactions = [];
            $i = 0;
            foreach($results as $transaction){
                $transactions[$i] = new Transaction($transaction["compte_id"] , $transaction["id"] , $transaction["transaction_type"] , $transaction["amount"] , $transaction["created_at"]);
                $i++;
            }
            return $transactions;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function afficheTransaction(){
        try {
            $sql = "SELECT * FROM transactions";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($results as $transaction){
                echo "#" . $transaction["id"] . " | compte_id: " . $transaction["compte_id"] . " | transaction_type: " . $transaction["transaction_type"] . " | amount: " . $transaction["amount"] , $transaction["created_at"];
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
}