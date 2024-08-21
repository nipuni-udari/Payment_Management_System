<?php
include('../connect.php');
include('../../CRM/public/EMP_DB_connect.php');

ini_set('display_errors', 'On');
session_start();

header('Content-Type: text/html; charset=UTF-8');

if (isset($_SESSION["Validete_session"]) && $_SESSION["Validete_session"] == '1') {
    if (isset($_POST['refno'])) {
        $refno = $_POST['refno'];

        $sql = "SELECT  (CHEQUE_AMOUNT - SUM(WBS_AMOUNT)) AS balance_amount FROM CASH_WALLET WHERE REF_NO = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $refno);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $balanceAmount = htmlspecialchars($row['balance_amount']);
            echo "<div>Balance Amount: $balanceAmount</div>";
        } else {
            echo "<tr><td colspan='6'>No data available</td></tr>";
        }

        $stmt->close();
    } else {
        echo "Reference number not provided";
    }
} else {
    echo "Session not valid";
}
?>
