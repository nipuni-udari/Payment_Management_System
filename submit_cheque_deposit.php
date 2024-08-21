<?php
include('../connect.php');
include('../../CRM/public/EMP_DB_connect.php');

ini_set('display_errors', 'On');
session_start();

if (isset($_SESSION["Validete_session"]) && $_SESSION["Validete_session"] == '1') {
    $PAGE_REDIRECT_PRIVILLEDGE = $_SESSION['PAGE_REDIRECT_PRIVILLEDGE'];
    $hris_no = $_SESSION['HRIS_NO'];

    if (!isset($_SESSION['HRIS_NO']) || empty($_SESSION['HRIS_NO'])) {
        $response['status'] = 'error';
        $response['message'] = 'HRIS_NO not found in session';
        echo json_encode($response);
        exit;
    }

    $nextRefNo = 'REF' . date('YmdHis'); 
    $refno = $_POST['refno'];
    $form_submited_date = date('Y-m-d');
    $form_edit_date = date('Y-m-d');
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $division = mysqli_real_escape_string($conn, $_POST['division']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $customerCode = mysqli_real_escape_string($conn, $_POST['customerCode']);
    $submittedBy = mysqli_real_escape_string($conn, $_POST['submittedBy']);
    $chequeNo = mysqli_real_escape_string($conn, $_POST['chequeNo']);
    $bank = mysqli_real_escape_string($conn, $_POST['bank']);
    $advance = isset($_POST['advance']) ? "'yes'" : "'no'";
    $debtorRecovery = isset($_POST['debtorRecovery']) ? "'yes'" : "'no'";
    $crossdivision = isset($_POST['CrossDivision']) ? "'yes'" : "'no'";
    $payment_type = mysqli_real_escape_string($conn, $_POST['payment_type']);

    if ($refno) {
        // Update query
        $sql = "UPDATE CHEQUE_DEPOSIT 
                SET 
                    DIVISION = '$division', 
                    AMOUNT = '$amount', 
                    CUSTOMER_CODE = '$customerCode', 
                    SUBMITTED_BY = '$submittedBy', 
                    CHEQUE_NO = '$chequeNo', 
                    CROSS_DIVISION = $crossdivision,
                    BANK = '$bank', 
                    ADVANCE = $advance, 
                    DEBTOR_RECOVERY = $debtorRecovery, 
                    DATE = '$date', 
                    FORM_EDIT_DATE = '$form_edit_date',
                    EDIT_STATUS = 'Edited',
                    PAYMENT_TYPE = '$payment_type' 
                WHERE REFNO = '$refno'";
    } else {
        // Insert query
        $sql = "INSERT INTO CHEQUE_DEPOSIT 
                (USER_HRIS, REFNO, PAYMENT_TYPE, DIVISION, AMOUNT, CUSTOMER_CODE, SUBMITTED_BY, CHEQUE_NO, BANK, ADVANCE, DEBTOR_RECOVERY, DATE, FORM_SUBMITED_DATE, CROSS_DIVISION, DEPOSIT_STATUS)
                VALUES 
                ('$hris_no', '$nextRefNo', '$payment_type', '$division', '$amount', '$customerCode', '$submittedBy', '$chequeNo', '$bank', $advance, $debtorRecovery, '$date', '$form_submited_date', $crossdivision, 'Pending')";
    }

    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        if ($refno) {
            $response['update'] = 'Updated Success';
        } else {
            $response['refno'] = $nextRefNo;
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = $conn->error;
    }
} else {
    header('Location: ../login.php');
    exit;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
