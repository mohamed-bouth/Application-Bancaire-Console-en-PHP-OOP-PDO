<?php
require_once "./config/database.php";
include "./models/client.php";
include "./repo/clientRepo.php";
include "./repo/compteRepo.php";
echo "index page =====>";
echo "<br>";
$admin = new clientRepo($pdo);
$users = $admin->renderClient();