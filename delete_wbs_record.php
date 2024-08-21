<?php
include('../connect.php');
include('../../CRM/public/EMP_DB_connect.php');

ini_set('display_errors', 'On');
session_start();

// Set response array
$response = array();
$response['status'] = 'error'; // Default status

if (isset($_SESSION["Validete_session"]) && $_SESSION["Validete_session"] == '1') {
    if (isset($_POST['invoiceNo'])) {
        $invoiceNo = $conn->real_escape_string($_POST['invoiceNo']);

        // Prepare and execute the delete statement
        $sql = "DELETE FROM CASH_WALLET WHERE INVOICE_NO = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $invoiceNo);

            if ($stmt->execute()) {
                $response['status'] = 'success';
            } else {
                $response['message'] = 'Execution error: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            $response['message'] = 'Preparation error: ' . $conn->error;
        }
    } else {
        $response['message'] = 'Invoice number not provided';
    }
} else {
    $response['message'] = 'Invalid session';
}

$conn->close();
echo json_encode($response);
?>
