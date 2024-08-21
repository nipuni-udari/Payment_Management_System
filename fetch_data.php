<?php
include('../connect.php');
include('../SERVICE_DESK_connect.php');
include('../../CRM/public/EMP_DB_connect.php');

ini_set('display_errors', 'On');
session_start();

header('Content-Type: text/html; charset=UTF-8');

if (isset($_SESSION["Validete_session"]) && $_SESSION["Validete_session"] == '1') {
    if (isset($_POST['refno'])) {
        $refno = $_POST['refno'];

        $sql = "SELECT * FROM CASH_WALLET WHERE REF_NO = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $refno);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $userHris = htmlspecialchars($row['HRIS_NO']);
                $refno = htmlspecialchars($row['REF_NO']);
                $amount = htmlspecialchars($row['CHEQUE_AMOUNT']);
                $wbsamount = htmlspecialchars($row['WBS_AMOUNT']);
                $wbselement = htmlspecialchars($row['WBS_ELEMENT']);
                $invoiceNo = htmlspecialchars($row['INVOICE_NO']);
                $bpCode = htmlspecialchars($row['BP_CODE']);
                $division = htmlspecialchars($row['DIVISION']);
                $status = htmlspecialchars($row['WBS_STATUS']);
                
                $queryA = "SELECT (CHEQUE_AMOUNT - SUM(WBS_AMOUNT)) AS balance_amount FROM CASH_WALLET WHERE REF_NO = ?";
                                                    $stmt = $conn->prepare($queryA);
                                                    $stmt->bind_param("s", $refno);
                                                    $stmt->execute();
                                                    $resultA = $stmt->get_result();

                                                    if ($resultA->num_rows > 0) {
                                                        $row = $resultA->fetch_assoc();
                                                        $balanceAmount = htmlspecialchars($row['balance_amount']);}
                
                // Output the row data
                echo "<tr class='btn-reveal-trigger'>
        <td class='user_hris align-middle white-space-nowrap py-2' style='color: #83f7cb;'>$userHris</td>
        <td class='refno align-middle py-2' style='color:#f7c579;'>$refno</td>
        <td class='invoiceNo align-middle white-space-nowrap py-2'>$invoiceNo</td>
         <td class='status align-middle white-space-nowrap py-2' style='color: #d95e07;'>$status</td>
        <td class='amount align-middle py-2'>$amount</td>
        <td class='wbsamount align-middle py-2'>$wbsamount</td>
        <td class='wbselement align-middle white-space-nowrap py-2'>$wbselement</td>
        <td class='BPcode align-middle white-space-nowrap py-2'>$bpCode</td>
        <td class='wbs align-middle white-space-nowrap py-2'>$division</td>
        <td class='align-middle white-space-nowrap'>";

// Check if status is approved to disable edit button
if ($status == 'Approved' || $status == 'Rejected') {
    echo "<button class='btn btn-sm btn-warning' style='margin-right: 5px;' disabled>
            <i class='fas fa-edit'></i>
          </button>";
} else {
    echo "<button class='btn btn-sm btn-warning' style='margin-right: 5px;' onclick='editRow(\"$refno\", \"$invoiceNo\", \"$wbselement\", \"$wbsamount\",\"$division\",\"$userHris\",\"$amount\",\"$bpCode\",\"$balanceAmount\")'>
            <i class='fas fa-edit'></i>
          </button>";
}
if ($status == 'Approved') {
    echo "<button class='btn btn-sm btn-danger' disabled>
        <i class='fas fa-trash-alt'></i>
      </button>";
    
} else {
    echo "<button class='btn btn-sm btn-danger' onclick='deleteRow(\"$invoiceNo\")'>
        <i class='fas fa-trash-alt'></i>
      </button>";
}

echo "
      </td>
      </tr>";

            }
        } else {
            echo "<tr><td colspan='8'>No data available</td></tr>";
        }

        $stmt->close();
    } else {
        echo "Reference number not provided";
    }
} else {
    echo "Session not valid";
}
?>
