<?php
include('../connect.php');
session_start();

$response = array();

if (isset($_SESSION["Validete_session"]) && $_SESSION["Validete_session"] == '1') {
    if (!isset($_POST['refno']) || empty($_POST['refno'])) {
        $response['status'] = 'error';
        $response['message'] = 'REFNO not provided';
        echo json_encode($response);
        exit;
    }

    $refno = $_POST['refno'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM CHEQUE_DEPOSIT WHERE REFNO = ?");
    $stmt->bind_param("s", $refno);

    if ($stmt->execute()) {
        $response['status'] = 'success';
    } else {
        $response['status'] = 'error';
        $response['message'] = $stmt->error;
    }

    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Unauthorized access';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
