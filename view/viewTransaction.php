<?php
require_once "../config/database.php";
include "../models/transaction.php";
include "../repo/transactionRepo.php";

$viewTransactions = new transactionRepo($pdo);
$viewTransactions->renderTransaction();