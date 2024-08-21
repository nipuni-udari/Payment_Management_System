<?php
include('../connect.php');
include('../SERVICE_DESK_connect.php');
include('../../CRM/public/EMP_DB_connect.php');
include('../debtor_monitoring_connect.php');

ini_set('display_errors', 'On');
session_start();

header('Content-Type: application/json; charset=UTF-8');

if (isset($_SESSION["Validete_session"]) && $_SESSION["Validete_session"] == '1') {
    if (isset($_POST['invoiceNo'])) {

        $invoiceNo = $_POST['invoiceNo'];

      
        if ($SERVICE_DESK_conn->connect_error) {
            echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
            exit();
        }

  
        $stmt = $SERVICE_DESK_conn->prepare("SELECT WBS_RAW_WBS, WBS_RAW_INVOICE, WBS_RAW_BP FROM WBS_RAW WHERE WBS_RAW_INVOICE_NO = ?");
        $stmt->bind_param('s', $invoiceNo);
        $stmt->execute();
        $stmt->bind_result($wbsElement, $wbsAmount, $bpcode);
        
        if($wbsElement && $wbsAmount && $bpcode){
            if ($stmt->fetch()) {
          
                echo json_encode([
                    'status' => 'success',
                    'data' => [
                        'wbsElement' => $wbsElement,
                        'wbsAmount' => $wbsAmount,
                        'BPcode' => $bpcode,
                    ]
                ]);
            }else {
                echo json_encode(['status' => 'error', 'message' => 'No matching data found']);
            }
        }else {
            $stmt = $debtor_monitoring_conn->prepare("SELECT DEBTORS_RAW_DATA_InvoiceAmount, DEBTORS_RAW_DATA_Customer FROM                                                                 DEBTORS_RAW_DATA WHERE DEBTORS_RAW_DATA_DocumentNumber = ?");
            $stmt->bind_param('s', $invoiceNo);
            $stmt->execute();
            $stmt->bind_result($wbsAmount , $bpcode);
            if ($stmt->fetch()) {
                $wbsElement = 'NA';
                echo json_encode([
                    'status' => 'success',
                    'data' => [
                        'wbsElement' => $wbsElement,
                        'wbsAmount' => $wbsAmount,
                        'BPcode' => $bpcode,
                    ]
                ]);
            }else {
                echo json_encode(['status' => 'error', 'message' => 'No matching data found']);
            }
        }
         

       
        $stmt->close();
        $SERVICE_DESK_conn->close();
        $debtor_monitoring_conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invoice No not provided']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Session not valid']);
}
?>
