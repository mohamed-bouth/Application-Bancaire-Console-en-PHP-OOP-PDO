<?php
require_once "../config/database.php";
include "../models/compte.php";
include "../repo/compteRepo.php";

$viewComptes = new compteRepo($pdo);
$viewComptes->afficheCompte();
