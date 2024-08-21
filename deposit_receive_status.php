<?php

include('../connect.php');
include('../../CRM/public/EMP_DB_connect.php');
include('ESMSWS.php'); // Include the ESMSWS.php file to access SMS functions

session_start();

$response = array();
$response['status'] = 'error'; 

if (isset($_SESSION["Validete_session"]) && $_SESSION["Validete_session"] == '1') {
    // Session is valid
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if required POST parameters are set
        if (isset($_POST['refNo']) && isset($_POST['status']) && isset($_POST['accountNo'])) {
            $refNo = $_POST['refNo'];
            $status = $_POST['status'];
            $accountNo = $_POST['accountNo'];

            // Prepare the SQL statement
            $query = "UPDATE CHEQUE_DEPOSIT SET DEPOSIT_STATUS = ?, RECEIVER_MOBILE_NUMBER = ? WHERE REFNO = ?";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param('sss', $status, $accountNo, $refNo);

                // Execute the statement and check for success
                if ($stmt->execute()) {
                    $response['status'] = 'success';

                    // Send SMS after successful update
                    $session = createSession('', 'esmsusr_168l', '2pr8jmh', ''); // Replace with actual credentials
                    $message = "The Payment deposit for REFNO: $refNo has been successfully received.";
                    $recipients = array($accountNo); // The phone number to send the SMS to
                    $alias = 'Fentons'; // Sender alias
                    $messageType = 0; // 0 for normal message, 1 for promotional message

                    // Send the SMS
                    $smsStatus = sendMessages($session, $alias, $message, $recipients, $messageType);

                    // Check SMS status
                    if ($smsStatus == 'SUCCESS') {
                        $response['sms_status'] = 'SMS sent successfully';
                    } else {
                        $response['sms_status'] = 'Failed to send SMS';
                    }

                    closeSession($session); // Close the SMS session

                } else {
                    $response['status'] = 'error';
                    $response['message'] = $stmt->error;
                }
                $stmt->close();
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to prepare the SQL statement';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = "Required POST parameters missing";
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = "Invalid request method";
    }
} else {
    $response['message'] = 'Invalid session';
}

// Send JSON response
echo json_encode($response);

?>
