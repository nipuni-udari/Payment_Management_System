<?php
include('../connect.php');
include('../SERVICE_DESK_connect.php');
include('../../CRM/public/EMP_DB_connect.php');
include('../debtor_monitoring_connect.php');

ini_set('display_errors', 'On');
session_start();

header('Content-Type: application/json; charset=UTF-8'); 

$response = array();
$response['status'] = 'error'; 

if (isset($_SESSION["Validete_session"]) && $_SESSION["Validete_session"] == '1') {
    if (isset($_POST['refno'], $_POST['invoiceNo'], $_POST['wbs'], $_POST['wbsamount'],$_POST['BPcode'], $_POST['division'], $_POST['hris'], $_POST['amount'], $_POST['balanceamount'])) {
  
        $refno = $conn->real_escape_string($_POST['refno']);
        $invoiceNo = $conn->real_escape_string($_POST['invoiceNo']);
        $wbs = $conn->real_escape_string($_POST['wbs']);
        $wbsamount = $conn->real_escape_string($_POST['wbsamount']);
        $BPcode = $conn->real_escape_string($_POST['BPcode']);
        $division = $conn->real_escape_string($_POST['division']);
        $hris = $conn->real_escape_string($_POST['hris']);
        $amount = $conn->real_escape_string($_POST['amount']);
        $balanceAmount = $conn->real_escape_string($_POST['balanceamount']);

        // Insert data directly without checking for existing invoice number
        $sql = "INSERT INTO CASH_WALLET (REF_NO, INVOICE_NO, WBS_ELEMENT, WBS_AMOUNT, BP_CODE, CHEQUE_AMOUNT, HRIS_NO, DIVISION, BALANCE, WBS_ADD_DATE, WBS_STATUS) 
                VALUES ('$refno', '$invoiceNo', '$wbs', '$wbsamount',' $BPcode', '$amount', '$hris', '$division', '$balanceAmount', NOW(), 'Pending')";

        if ($conn->query($sql) === TRUE) {
            $response['status'] = 'success';
        } else {
            $response['message'] = $conn->error;
        }
    } else {
        $response['message'] = 'Required POST parameters missing';
    }
} else {
    $response['message'] = 'Invalid session';
}

echo json_encode($response);
?>
