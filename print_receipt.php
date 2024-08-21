<?php
require_once 'dompdf/autoload.inc.php';

if (isset($_GET['refno'])) {
    $refno = $_GET['refno'];
    include('../connect.php');
    include('../../CRM/public/EMP_DB_connect.php');

    ini_set('display_errors', 'On');
    session_start();


    $sql = "SELECT cd.*, 
                   cw.DIVISION as WALLET_DIVISION, 
                   cw.INVOICE_NO, 
                   cw.WBS_ELEMENT, 
                   cw.WBS_AMOUNT, 
                   cw.BALANCE
            FROM CHEQUE_DEPOSIT cd
            LEFT JOIN CASH_WALLET cw ON cd.REFNO = cw.REF_NO
            WHERE cd.REFNO = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $refno);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    // Start output buffering
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Receipt</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
                   <style>
                .receipt-container {
                    max-width: 900px;
                    margin: 30px auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    background: #fff;
                }
                .receipt-header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .receipt-body {
                    font-size: 16px;
                }
                .receipt-body p {
                    margin: 0 0 10px;
                }
                .receipt-footer {
                    margin-top: 20px;
                    text-align: center;
                }
                .title-bar {
                    font-size: 24px;
                    font-weight: bold;
                    margin-bottom: 20px;
                    color: #18078a;
                }
                .heading-bar {
                    background-color: #edf0f2;
                    padding: 10px;
                    text-align: center;
                    font-size: 1rem;
                    font-weight: bold;
                    color: #010a0f;
                }
               
                 .table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .table thead {
            background-color: #f8f9fa;
            color: #333;
        }
        .table thead th {
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table tbody tr:hover {
            background-color: #e2e6ea;
        }
        .table td {
            vertical-align: middle;
        }
        .table .no-data {
            text-align: center;
            font-style: italic;
        }
            </style>
    </head>
    <body>
        <div class="receipt-container">
            <div class="receipt-header">
                <div class="row align-items-center g-0">
                    <div class="col">
                        <?php
                        $logo_path = 'FENTONS.webp';
                        $type = pathinfo($logo_path, PATHINFO_EXTENSION);
                        $data = file_get_contents($logo_path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        ?>
                        <img class="me-2" src="<?php echo $base64; ?>" alt="Fentons Logo" width="140" />
                    </div>
                    <div class="col-auto">
                        <div class="heading-bar">
                            PAYMENT DEPOSIT RECEIPT
                        </div>
                    </div>
                </div>
            </div>
            <div class="receipt-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <p><strong>Ref No:</strong> <?php echo htmlspecialchars($rows[0]['REFNO']); ?></p>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($rows[0]['DATE']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Payment Type:</strong> <?php echo htmlspecialchars($rows[0]['PAYMENT_TYPE']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Division:</strong> <?php echo htmlspecialchars($rows[0]['DIVISION']); ?></p>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <p><strong>Customer Code:</strong> <?php echo htmlspecialchars($rows[0]['CUSTOMER_CODE']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Submitted By:</strong> <?php echo htmlspecialchars($rows[0]['SUBMITTED_BY']); ?></p>
                    </div>
                    <?php if (!empty($rows[0]['CHEQUE_NO'])): ?>
                        <div class="col-md-4">
                            <p><strong>Cheque No:</strong> <?php echo htmlspecialchars($rows[0]['CHEQUE_NO']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <p><strong>Bank:</strong> <?php echo htmlspecialchars($rows[0]['BANK']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Amount:</strong> <?php echo htmlspecialchars($rows[0]['AMOUNT']); ?></p>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <p><strong>Advance:</strong> <?php echo htmlspecialchars($rows[0]['ADVANCE']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Debtor Recovery:</strong> <?php echo htmlspecialchars($rows[0]['DEBTOR_RECOVERY']); ?></p>
                        </div>
                    </div>

                <!-- Table for WBS Elements, Invoice Numbers, and WBS Amounts -->
                <div class="mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                 <th>Invoice Number</th>
                                 
                                <th>WBS Element</th>
                               
                                <th>WBS Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rows[0]['WBS_ELEMENT']) && empty($rows[0]['INVOICE_NO']) && empty($rows[0]['WBS_AMOUNT'])): ?>
                                <tr>
                                    <td colspan="3" class="no-data">No data available</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?php echo !empty($row['INVOICE_NO']) ? htmlspecialchars($row['INVOICE_NO']) : 'N/A'; ?></td>
                                        
                                        <td><?php echo !empty($row['WBS_ELEMENT']) ? htmlspecialchars($row['WBS_ELEMENT']) : 'N/A'; ?></td>
                                        
                                        <td><?php echo !empty($row['WBS_AMOUNT']) ? htmlspecialchars($row['WBS_AMOUNT']) : 'N/A'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="receipt-footer">
                <p>Thank you</p>
            </div>
        </div>
    </body>
    </html>
    <?php
    // Get the HTML content
    $html = ob_get_clean();

    // Initialize dompdf
    $dompdf = new Dompdf\Dompdf();
    $dompdf->loadHtml($html);

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF (force download)
    $dompdf->stream("receipt_$refno.pdf", array("Attachment" => true));

    $stmt->close();
    $conn->close();
} else {
    echo "<p>No reference number provided.</p>";
}
?>
