<?php
// Include your database connection file
include('../connect.php');
include('../../CRM/public/EMP_DB_connect.php');

// Ensure error reporting is on for debugging
ini_set('display_errors', 'On');
session_start();

// Set response array
$response = array();
$response['status'] = 'error'; // Default status

// Set header for JSON response
header('Content-Type: application/json; charset=UTF-8');

// Validate session
if (isset($_SESSION["Validete_session"]) && $_SESSION["Validete_session"] == '1') {
    // Check if all required POST parameters are set
    if (isset($_POST['refno'], $_POST['invoiceNo'], $_POST['wbs'], $_POST['wbsamount'], $_POST['division'], $_POST['hris'], $_POST['amount'],$_POST['BPcode'], $_POST['balanceamount'])) {
        // Sanitize and retrieve POST data
        $refno = $_POST['refno'];
        $invoiceNo = $_POST['invoiceNo'];
        $wbs = $_POST['wbs'];
        $wbsamount = $_POST['wbsamount'];
        $bpcode = $_POST['BPcode'];
        $division = $_POST['division'];
        $hris = $_POST['hris'];
        $amount = $_POST['amount'];
        $balanceAmount = $_POST['balanceamount'];
        $form_edit_date = date('Y-m-d');
        $edit_status = 'Edited';

        // Prepare SQL statement with parameters to prevent SQL injection
        $sql = "UPDATE CASH_WALLET 
                SET WBS_ELEMENT = ?, WBS_AMOUNT = ?, BP_CODE = ?, CHEQUE_AMOUNT = ?, HRIS_NO = ?, DIVISION = ?, BALANCE = ?, WBS_EDIT_DATE = ?, WBS_EDIT_STATUS = ?
                WHERE REF_NO = ? AND INVOICE_NO = ?";
        
        // Prepare statement
        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("sssssssssss", $wbs, $wbsamount, $bpcode, $amount, $hris, $division, $balanceAmount, $form_edit_date, $edit_status,$refno, $invoiceNo);

        // Execute statement
        if ($stmt->execute()) {
            $response['status'] = 'success';
        } else {
            $response['message'] = $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        $response['message'] = 'Required POST parameters missing';
    }
} else {
    $response['message'] = 'Invalid session';
}

// Output JSON response
echo json_encode($response);
?>
