<?php
require_once "../config/database.php";
include "../models/client.php";
include "../repo/clientRepo.php";

$viewClients = new clientRepo($pdo);
$viewClients->afficheClients();