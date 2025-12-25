<?php
class clientRepo {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function ajouteClient($nom , $prenom , $email){
        try {
            $sql = "INSERT INTO clients (nom , prenom , email)
            VALUES (:nom, :prenom, :email)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ":nom" => $nom,
                ":prenom" => $prenom,
                ":email" => $email
            ]);
        } catch (Exception $e) {
            echo($e);
        }
    }

    public function modifieClient($nom , $prenom , $email){
        $sql = "SELECT * FROM clients WHERE email = :email";
        $stmt1 = $this->db->prepare($sql);
        $stmt1->execute([
            ":email" => $email
        ]);
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        if(!$result1){
            return;
        }

        $id = $result1[0]["id"];
        try {
            $sql = "UPDATE clients SET nom = :nom , prenom = :prenom , email = :email WHERE id = :id";
            $stmt2 = $this->db->prepare($sql);
            $stmt2->execute([
                ":nom" => $nom,
                ":prenom" => $prenom,
                ":email" => $email,
                ":id" => $id
            ]);

            $sql = "SELECT * FROM clients WHERE id = :id";
            $stmt3 = $this->db->prepare($sql);
            $stmt3->execute([
                ":id" => $id
            ]);
            print_r($stmt3->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function supprimeClient($email){
        try{
            $sql = "DELETE FROM clients WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
            ":email"=> $email
            ]);
            echo("the client has removed succesfuly");
        } catch (Exception $e) {
            echo($e);
        }
    }

    public function afficheClient(){
        try{
            $sql = "SELECT * FROM clients";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            print_r($clients);
        } catch (Exception $e) {
            echo($e);
        }
    }
    public function renderClient(){
        try{
            $sql = "SELECT * FROM clients";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $users = [];
            $i = 0;
            foreach ($clients as $client) {
                $users[$i] = new client ($client["id"], $client["nom"], $client["prenom"], $client["email"], $client["created_at"] ) ;
                $i++;
            }
        }catch (Exception $e) {
            echo($e);
        }
        return $users;
    }

    public function chercheClient($email , $users){
        foreach ( $users as  $user) {
            $flag = false;
           if( $user->getEmail() == $email ){
                $flag = true;
                echo "+ we found client with email: " . $email . "<br>";
                return $user;
            }
        }
        if(!$flag){
            echo "- we dont found client with email: " . $email . "<br>";
        }
    }
}