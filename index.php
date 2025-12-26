<?php
require_once "./config/database.php";
include "./models/client.php";
include "./models/compte.php";
include "./models/compteCourant.php";
include "./models/compteEpargne.php";
include "./repo/clientRepo.php";
include "./repo/compteRepo.php";

echo "index page =====>";
echo "<br>";
$admin = new clientRepo($pdo);
$admin2 = new compteRepo($pdo);

$clients = $admin->renderClients();
$comptes = $admin2->renderComptes();

$myuser = $admin->chercheClient("mohamedbouth87@gmail.com" , $clients);
$myuser->getComptes($pdo);


$comptes[0]->getInfo();

$mycompte = $admin2->chercheCompte(957328564, $comptes);


