<?php
include('../connect.php');
include('../../CRM/public/EMP_DB_connect.php');

ini_set('display_errors', 'On');
session_start();

if (!isset($_SESSION["Validete_session"]) || $_SESSION["Validete_session"] != '1') {
    header('Location: ../login.php');
    exit;
}

$banks = [];

// Fetch bank names from finance_db_accounts
$sql = "SELECT finance_db_accounts_bank FROM finance_db_accounts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $banks[] = $row['finance_db_accounts_bank'];
    }
}

// Return JSON
header('Content-Type: application/json');
echo json_encode($banks);

$conn->close();
?>
