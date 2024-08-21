<?php
include('../connect.php');
include('../SERVICE_DESK_connect.php');
include('../../CRM/public/EMP_DB_connect.php');

ini_set('display_errors', 'On');
session_start();


if (isset($_SESSION["Validete_session"]) == '1') {
    //     //session is set
    //     header('Location: ../login.php');
} else {

    header('Location: ../login.php');

}

$PAGE_REDIRECT_PRIVILLEDGE = $_SESSION['PAGE_REDIRECT_PRIVILLEDGE'];
$hris_no = $_SESSION['HRIS_NO'];
$log_division = $_SESSION['DIVISION'];


//$email= $_SESSION['Email_Address'];

?>


<!DOCTYPE html>
<html data-bs-theme="dark" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>iAssist | Finance Dashboard </title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
   <link rel="apple-touch-icon" sizes="180x180" href="../../CRM/public/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../CRM/public/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../CRM/public/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../CRM/public/assets/img/favicons/favicon.ico">
    <link rel="manifest" href="../../CRM/public/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../../CRM/public/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="../../CRM/public/assets/js/config.js"></script>
    <script src="../../CRM/public/vendors/simplebar/simplebar.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
     <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="../../CRM/public/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link href="../../CRM/public/assets/css/theme-rtl.css" rel="stylesheet" id="style-rtl">
    <link href="../../CRM/public/assets/css/theme.css" rel="stylesheet" id="style-default">
    <link href="../../CRM/public/assets/css/user-rtl.css" rel="stylesheet" id="user-style-rtl">
    <link href="../../CRM/public/assets/css/user.css" rel="stylesheet" id="user-style-default">
    <script src="../../CRM/public/vendors/choices/choices.min.js"></script>
    <style>
        .title-bar {
            background-color: #033261;
            padding: 10px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #5dbdf5;

        }

    </style>
   <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>

            <div class="content">
                <nav class="navbar navbar-dark navbar-glass navbar-top navbar-expand">

                                                                                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3"                                                         type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls                                                                    ="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle                                                         -icon"><span class="toggle-line"></span></span></button>
                                <a class="navbar-brand me-1 me-sm-3" href="../index.html" id="loader">
                                    <div class="d-flex align-items-center">
                                        <img class="me-2" src="../main.png" alt="" width="100" />
                                    </div>
                                </a>
            
                                <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">


                                    <li class="nav-item dropdown px-1">
                                        <div class="row d-flex justify-content-between">
                                            <!--
                                                                                           <div class="col-auto">
                                                                                              <input class="form-control form-control-sm datetimepicker" id="datefrom" name="datefrom" type="date"/>
                                                                                          </div>
                                                                                           <div class="col-auto">
                                                                                              <input class="form-control form-control-sm datetimepicker" id="dateto" name="dateto"  type="date" />
                                                                                          </div>
                                                                                          -->
                                            <div class="col-auto">
                                                <div class="dropdown font-sans-serif btn-reveal-trigger">
                                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-top-products" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
            
                                                </div>
            
                                            </div>
                                        </div>
                                    </li>
                                    <?php echo $_SESSION['CallingName']; ?>
                                    <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown"                                       aria-haspopup="true" aria-expanded="false">
                                        <div class="avatar avatar-xl">
                                            <img class="rounded-circle" src="../../CRM/public/assets/img/team/avatar.png" alt="" />
                                        </div>
                                    </a>
                                        <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                            <div class="bg-white dark__bg-1000 rounded-2 py-2">
            
                                                <a class="dropdown-item" href="../logout.php">Logout</a>
                                            </div>
                                        </div>
                                    </li>
                </nav>

                    <!--All deposits-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card font-sans-serif" style="background-image: url('bgimg.webp'); background-size: cover; background-position: center; height:170px;">

                                <div class="card-body">
                                    <div class="row g-0">

                                        <div class="col-6 mt-n4 d-flex justify-content-end">
                                            <div class="echart-default" data-echart-responsive="true" data-echarts='{"xAxis":{"data":["Day 1","Day 2","Day 3","Day 4","Day 5","Day 6","Day 7","Day 8","Day 9","Day 10"]},"series":[{"type":"line","data":[85,60,120,70,100,15,65,80,60,75,45],"smooth":true,"lineStyle":{"width":2}}],"grid":{"bottom":"2%","top":"2%","right":"0px","left":"0px"}}' style="user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;">
                                                <div style="position: relative; width: 138px; height: 80px; padding: 0px; margin: 0px; border-width: 0px; cursor: pointer;">
                                                    <canvas data-zr-dom-id="zr_0" width="172" height="100" style="position: absolute; left: 0px; top: 0px; width: 138px; height: 80px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                                                </div>
                                                <div class=""></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Admin access-->

                                    <div class="row g-0 justify-content-end mt-3">
                                        <div class="col-md-4">
                                            <div class="card font-sans-serif "style="background-color: #1b2240;">
                                                <div class="card-header pb-0">
                                                    <h6 class="mb-0 text-info">Your all deposits</h6>
                                                </div>

                                                <?php

                                                $sql = "SELECT count(*) as total FROM CHEQUE_DEPOSIT WHERE USER_HRIS = '$hris_no'";
                                                $result = $conn->query($sql);

                                                if ($result) {
                                                    $row = $result->fetch_assoc(); // Fetch associative array
                                                    $total = $row['total']; // Access the 'total' column
                                                } else {
                                                    $total = 0; // Default to 0 if the query fails
                                                }

                                                ?>


                                                <div class="card-body">
                                                    <div class="row g-0">
                                                        <div class="col-6">

                                                            <h4 class="text-700 lh-1 mb-1"><?php echo $total; ?></h4>
                                                            <small class="badge rounded badge-subtle-success false">
                                                                <a href="" style="color: inherit; text-decoration: none;">View the details below</a>
                                                            </small>

                                                        </div>
                                                        <div class="col-6 mt-n4 d-flex justify-content-end">
                                                            <div class="echart-default" data-echart-responsive="true" data-echarts='{"xAxis":{"data":["Day 1","Day 2","Day 3","Day 4","Day 5","Day 6","Day 7","Day 8","Day 9","Day 10"]},"series":[{"type":"line","data":[85,60,120,70,100,15,65,80,60,75,45],"smooth":true,"lineStyle":{"width":2}}],"grid":{"bottom":"2%","top":"2%","right":"0px","left":"0px"}}' style="user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;">
                                                                <div style="position: relative; width: 138px; height: 80px; padding: 0px; margin: 0px; border-width: 0px; cursor: pointer;">
                                                                    <canvas data-zr-dom-id="zr_0" width="172" height="100" style="position: absolute; left: 0px; top: 0px; width: 138px; height: 80px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                                                                </div>
                                                                <div class=""></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="content">
                        <div class="d-flex mb-4 mt-3">
                            <span class="fa-stack me-2 ms-n1"><i class="fas fa-circle fa-stack-2x text-300"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-percentage"></i></span>
                            <div class="col">
                                <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">PAYMENT DEPOSIT SLIP</span><span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span></h5>
                                <p class="mb-0">
                                    Easily manage your Payment deposits with this slip.
                                </p>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-xxl-8">
                                <div class="card rounded-3 overflow-hidden h-100 mb-3">
                                    <div class="card border h-100 border-info">
                                        <div class="card-body bg-line-chart-gradient d-flex flex-column justify-content-between">
                                            <div class="row align-items-center g-0">
                                                <div class="col" data-bs-theme="light">
                                                    <img class="me-2" src="FENTONS.webp" alt="" width="140" />
                                                </div>
                                                <div class="col-auto">
                                                    <?php
                                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                        if (isset($_POST['refno'])) {
                                                            $refno = $_POST['refno'];
                                                            // Process the reference number
                                                            echo "Reference Number: " . htmlspecialchars($refno);
$query = "SELECT * FROM CHEQUE_DEPOSIT WHERE REFNO = '" . $conn->real_escape_string($refno) . "'";



                                                            $result = $conn->query($query);

                                                            if ($result->num_rows > 0 && $refno) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $userHris1 = htmlspecialchars($row['USER_HRIS']);
                                                                    $refno1 = htmlspecialchars($row['REFNO']);
                                                                    
                                                                    $division1 = htmlspecialchars($row['DIVISION']);
                                                                    $amount1 = htmlspecialchars($row['AMOUNT']);
                                                                    $customerCode1 = htmlspecialchars($row['CUSTOMER_CODE']);
                                                                    $submittedBy1 = htmlspecialchars($row['SUBMITTED_BY']);
                                                                    $chequeNo1 = htmlspecialchars($row['CHEQUE_NO']);
                                                                   
                                                                   
                                                                    $CrossDivision1 = htmlspecialchars($row['CROSS_DIVISION']);
                                                                    $advance1 = htmlspecialchars($row['ADVANCE']);
                                                                    $debtorRecovery1 = htmlspecialchars($row['DEBTOR_RECOVERY']);
                                                                    $date1 = htmlspecialchars($row['DATE']);
                                                                    $payment_type1 = isset($row['PAYMENT_TYPE']) ? htmlspecialchars($row['PAYMENT_TYPE']) : '';
                                                                    $bank1 = isset($row['BANK']) ? htmlspecialchars($row['BANK']) : '';


                                                                }

                                                            }
                                                        }
                                                        // unset($_POST['refno']);
                                                    }

                                                    ?>
                                                </div>
                                                <div class="title-bar">
                                                    PAYMENT DEPOSIT SLIP
                                                </div>
                                            </div>

                                            <form class="row g-3 needs-validation" id="chequeDepositForm" novalidate>
                                                <input type="hidden" id="REFNO" value="<?php echo $refno1 ?? ''; ?>" name="refno" />

                                                <div class="col-md-4">
                                                    <label class="form-label text-info" for="Date">Date</label>
                                                    <input class="form-control" value='<?php echo $date1 ?? ''; ?>' id="Date" name="date" type="date" required />
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid date.
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label text-info" for="payment_type">Payment Type</label>
                                                    <select class="form-control" id="payment_type" name="payment_type" required>
                                                        <option value="">Select a Payment Type</option>
                                                        <option value="Cash deposit" <?php echo (isset($payment_type1) && $payment_type1 == 'Cash deposit') ? 'selected' : ''; ?>>Cash deposit</option>
                                                        <option value="Cheque deposit" <?php echo (isset($payment_type1) && $payment_type1 == 'Cheque deposit') ? 'selected' : ''; ?>>Cheque deposit</option>
                                                        <option value="Bank Transfers" <?php echo (isset($payment_type1) && $payment_type1 == 'Bank Transfers') ? 'selected' : ''; ?>>Bank Transfers</option>
                                                    </select>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Please select a Payment type.
                                                    </div>
                                                </div>



                                                <div class="col-md-4">
                                                    <label class="form-label text-info" for="Division">Division</label>
                                                    <div class="input-group has-validation">
                                                        <input class="form-control" id="Division" value="<?php echo $log_division ?? ''; ?>" name="division" type="text" aria-describedby="inputGroupPrepend" required readonly />
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please enter the division.
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-md-4">
                                                    <label class="form-label text-info" for="CustomerCode">Customer Code</label>
                                                    <input class="form-control" value='<?php echo $customerCode1 ?? ''; ?>' id="CustomerCode" name="customerCode" type="number"/>
                                                   
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label text-info" for="SubmittedBy">Submitted By (HRIS NO:)</label>
                                                    <input class="form-control" value="<?php echo $hris_no ?? ''; ?>" id="SubmittedBy" name="submittedBy" type="text" required readonly />
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Please provide the submitted by information.
                                                    </div>
                                                </div>

                                                <div class="col-md-4" id="chequeNoContainer">
                                                    <label class="form-label text-info" for="ChequeNo">Cheque No</label>
                                                    <input class="form-control" value='<?php echo $chequeNo1 ?? ''; ?>' id="ChequeNo" name="chequeNo" type="number" required />
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid cheque number.
                                                    </div>
                                                </div>
                             



                                                <div class="col-md-4">
                                                    <label class="form-label text-info" for="Amount">Amount</label>
                                                    <input class="form-control" value='<?php echo $amount1 ?? ''; ?>' id="Amount" name="amount" type="float" required />
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid amount.
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <label class="form-label text-info" for="Bank">Bank</label>
                                                    <select class="form-control" id="Bank" name="bank" required>
                                                        <option value="" disabled selected>Select a bank</option>
                                                    </select>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Please select a bank.
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
    <div class="form-check">
        <input class="form-check-input" value='yes' id="CROSSDivision" name="CrossDivision" type="checkbox" 
        <?php echo isset($CrossDivision1) && $CrossDivision1 == 'yes' ? 'checked' : ''; ?> />
        <label class="form-check-label mb-0 text-success" for="CROSSDivision">Cross Division</label>
    </div>
</div>

                                                
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" value='yes' id="Advance" name="advance" type="checkbox" 
                                                        <?php echo isset($advance1) && $advance1 == 'yes' ? 'checked' : ''; ?> />
                                                        <label class="form-check-label mb-0 text-info" for="Advance">Advance</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" value='yes' id="DebtorRecovery" name="debtorRecovery" type="checkbox" 
                                                        <?php echo isset($debtorRecovery1) && $debtorRecovery1 == 'yes' ? 'checked' : ''; ?> />
                                                        <label class="form-check-label mb-0 text-info" for="DebtorRecovery">Debtor Recovery</label>
                                                    </div>
                                                </div>
                                                
                                                
                                                

                                                <div class="col-12">
                                                    <button class="btn btn-primary" id="submitBtn" type="submit">Save</button>
                                                    <?php if (isset($refno1) && !empty($refno1)): ?>
                                                    <button class="btn btn-success" id="newFormBtn" type="button" style="margin-left: 10px;">New Form</button>
                                                    <?php endif; ?>
                                                </div>
                                            </form>


                                            <!-- Note Section -->
                                            <div style="color: #ffb703; font-size: 13px;" class="mt-3">
                                                <div style="color: #ff0303; font-weight: bold;">Note:</div>
                                                <div style="margin-top: 5px;">
                                                    If these payments are made for an advance, please provide the customer code or WBS element. 
                                                    If these payments are made for debtor recovery, please provide the invoice number and customer code.
                                                    If the deposit is divided among multiple divisions, please ensure the "Cross Division" checkbox is selected.
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- WBS Model -->
                            <div
                              class="modal fade"
                              id="wbsElementModal"
                              data-bs-keyboard="false"
                              data-bs-backdrop="static"
                              tabindex="-1"
                              aria-labelledby="staticBackdropLabel"
                              aria-hidden="true"
                            >
                                                        
                                                        
                      
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">WBS Elements</h5>
                                        <div id=balanceAmount></div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closewbsModel()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modal-body-content">
                                        <div class="table-responsive scrollbar">
                                            <table id="invoiceTable" class="table table-sm table-striped fs-10 mb-0 overflow-hidden">
                                                <thead class="bg-200">
                                                    <tr>

                                                        <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="user_hris">USER HRIS</th>
                                                        <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="refno">REF NO</th>
                                                        <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="invoice_no">INVOICE NO</th>
                                                        <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="wbs_status">STATUS</th>
                                                        <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="amount">AMOUNT</th>
                                                        <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="wbsamount">WBS AMOUNT</th>
                                                        <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="wbs_element">WBS ELEMENT</th>
                                                        <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="bp_code">BP CODE</th>
                                                        <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="division">DIVISION</th>

                                                        <th class="align-middle no-sort"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list" id="table-customers-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal HTML -->
                        
                            <div
                              class="modal fade"
                              id="addInvoiceModal"
                              data-bs-keyboard="false"
                              data-bs-backdrop="static"
                              tabindex="-1"
                              aria-labelledby="staticBackdropLabel"
                              aria-hidden="true"
                            >
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Invoice</h5>

                                        <div id=balanceAmountinmodal></div>
                                    
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModel()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                      <form id="invoiceForm">
                                        <input type="hidden" id="refno">
                                        <input type="hidden" id="hris">
                                        <input type="hidden" id="division">
                                        <input type="hidden" id="amount">
                                        <input type="hidden" id="balanceamount">
                                        <div class="form-group">
                                            <label for="invoiceNo">Invoice No</label>
                                            <input type="text" class="form-control" id="invoiceNo" onchange="fetchWbsData()">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="BPcode">BP code</label>
                                            <input type="text" class="form-control" id="BPcode">
                                        </div>

                                        <div class="form-group">
                                            <label for="wbs">WBS Element</label>
                                            <input type="text" class="form-control" id="wbs">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">WBS Amount</label>
                                            <input type="float" class="form-control" id="wbsamount">
                                        </div>
                                    </form>    
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModel()">Close</button>
                                        <button type="button" class="btn btn-primary" id="addInvoiceBtn">Add</button>
                                        <button type="button" class="btn btn-primary" id="updateInvoiceBtn">Update</button> 
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="d-flex mb-4 mt-3">
                            <span class="fa-stack me-2 ms-n1"><i class="fas fa-circle fa-stack-2x text-300"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-percentage"></i></span>
                            <div class="col">
                                <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">PAYMENT DEPOSIT SLIP LIST</span><span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span></h5>
                                <p class="mb-0">
                                    You can view your past diposit lists.
                                </p>
                            </div>
                        </div>

                        <div class="card mb-3" id="customersTable" data-list='{"valueNames":["user_hris","refno","invoice_no","division","amount","customer_code","submitted_by","cheque_no","order_no","bank","advance","debtor_recovery","date","form_submited_date"],"page":10,"pagination":true}'>
                            <div class="card-header">
                                <div class="row flex-between-center">
                                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                                        <h5 class="fs-12 mb-0 text-nowrap py-2 py-xl-0 text-success">Payment Deposits</h5>
                                    </div>
                                    <div class="col-8 col-sm-auto text-end ps-2">
                                        <form>
                                            <div class="input-group">
                                                <input class="form-control form-control-sm shadow-none search" type="search" placeholder="Search..." aria-label="search" />
                                                <div class="input-group-text bg-transparent">
                                                    <span class="fa fa-search fs-10 text-600"></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive scrollbar">
                                    <table id="invoiceTable" class="table table-sm table-striped fs-10 mb-0 overflow-hidden">
                                        <thead class="bg-200">
                                            <tr>
                                                <th class="text-info align-middle white-space-nowrap">Add Invoice</th>

                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="user_hris">USER HRIS</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="refno">REF NO</th>
                                                
                                                
                                               
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="payment_type">PAYMENT_TYPE</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="refno">CHEQUE DEPOSIT STATUS</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="division">DIVISION</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="crossdivision">CROSS DIVISION</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="amount">AMOUNT</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="balance">BALANCE</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="customer_code">CUSTOMER</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="submitted_by">SUBMITTED BY</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="cheque_no">CHEQUE NO</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="bank">BANK</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="advance">ADVANCE</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="debtor_recovery">DEBTOR RECOVERY</th>
                                                <th class="text-info sort pe-1 align-middle white-space-nowrap" data-sort="date">DATE</th>

                                                <th class="align-middle no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="table-customers-body">
                                            <?php
                                            $sql = "SELECT * FROM CHEQUE_DEPOSIT WHERE USER_HRIS = '$hris_no' OR CROSS_DIVISION = 'yes'";

                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $userHris = htmlspecialchars($row['USER_HRIS']);
                                                    $refno = htmlspecialchars($row['REFNO']);
                                                    $payment_type = htmlspecialchars($row['PAYMENT_TYPE']);
                                                    $division = htmlspecialchars($row['DIVISION']);
                                                    $amount = htmlspecialchars($row['AMOUNT']);
                                                    $deposit_status = htmlspecialchars($row['DEPOSIT_STATUS']);
                                                    $customerCode = htmlspecialchars($row['CUSTOMER_CODE']);
                                                    $submittedBy = htmlspecialchars($row['SUBMITTED_BY']);
                                                    $chequeNo = htmlspecialchars($row['CHEQUE_NO']);
                                                    
                                                    $bank = htmlspecialchars($row['BANK']);
                                                    $advance = htmlspecialchars($row['ADVANCE']);
                                                    $debtorRecovery = htmlspecialchars($row['DEBTOR_RECOVERY']);
                                                    $date = htmlspecialchars($row['DATE']);
                                                   
                                                    $CrossDivision = htmlspecialchars($row['CROSS_DIVISION']);




                                                    echo "<tr class='btn-reveal-trigger'>

<td class='align-middle text-center py-2'>";
                                                    //   if ($payment_type == 'Cheque deposit') {
                                                    $queryA = "SELECT (CHEQUE_AMOUNT - SUM(WBS_AMOUNT)) AS balance_amount FROM CASH_WALLET WHERE REF_NO = ?";
                                                    $stmt = $conn->prepare($queryA);
                                                    $stmt->bind_param("s", $refno);
                                                    $stmt->execute();
                                                    $resultA = $stmt->get_result();

                                                    if ($resultA->num_rows > 0) {
                                                        $row = $resultA->fetch_assoc();
                                                        $balanceAmount = htmlspecialchars($row['balance_amount']);
                                                        $disabled = ($balanceAmount === '0' || $balanceAmount === '0.00') ? 'disabled' : '';
                                                        echo "<button class='btn btn-sm btn-primary' data-bs-toggle='modal' id='addInvoice' data-bs-target='#addInvoiceModal'
        onclick='setRefNo(\"$refno\",\"$hris_no\" , \"$log_division\",\"$amount\", \"$balanceAmount\")' $disabled>
        <i class='fas fa-plus'></i>
    </button>";
                                                    }


                                                    // }
                                                    echo "</td>

      <td class='user_hris align-middle white-space-nowrap py-2' style='color: #83f7cb;'>$userHris</td>
      <td class='refno align-middle py-2' style='color:#f7c579;'>$refno</td>
     
    
      <td class='date align-middle white-space-nowrap py-2' style='color: #31d907;'>$payment_type</td>
       <td class='refno align-middle py-2' style='color:#b879f7;'>$deposit_status</td>
      <td class='division align-middle white-space-nowrap py-2'>$division</td>
      <td class='crossdivision align-middle white-space-nowrap py-2'style='color: #f7f383;'>$CrossDivision</td>
      <td class='amount align-middle py-2'>$amount</td>
      <td class='amount align-middle py-2'>$balanceAmount</td>
      <td class='customer_code align-middle white-space-nowrap py-2'>$customerCode</td>
      <td class='submitted_by align-middle py-2'>$submittedBy</td>
      <td class='cheque_no align-middle white-space-nowrap py-2'>$chequeNo</td>
      
      <td class='bank align-middle white-space-nowrap py-2'>$bank</td>
      <td class='advance align-middle py-2'>$advance</td>
      <td class='debtor_recovery align-middle white-space-nowrap py-2'>$debtorRecovery</td>
      <td class='date align-middle white-space-nowrap py-2'>$date</td>

      <td class='align-middle white-space-nowrap py-2 text-end'>
        <div class='dropdown font-sans-serif position-static'>
          <button class='btn btn-link text-600 btn-sm dropdown-toggle btn-reveal' type='button' id='customer-dropdown-$userHris' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false'>
            <span class='fas fa-ellipsis-h fs-10'></span>
          </button>
          <div class='dropdown-menu dropdown-menu-end border py-0' aria-labelledby='customer-dropdown-$userHris'>
            <div class='py-2'>
                <button type='submit' class='dropdown-item text-success' name='refno' onclick='openWbs(\"$refno\")'>WBS Elements</button>
                 <button type='button' class='dropdown-item dropdown-item text-info' onclick='redirectToReceiptPage(\"$refno\")'>Print Receipt</button>

              <form method='post' action=''>
                <button type='submit' class='dropdown-item ' name='refno' value='$refno'>Edit</button>
              </form>
              <a class='dropdown-item text-danger deleteButton' href='#' data-refno='$refno'>Delete</a>
            </div>
          </div>
        </div>
      </td>
    </tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='16'>No data available</td></tr>";
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                                    <ul class="pagination mb-0"></ul>
                                    <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                                </div>
                            </div>
                        </div>



                    </div>





                    <footer class="footer">
                        <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                            <div class="col-12 col-sm-auto text-center">
                                <p class="mb-0 text-600">
                                    A product of SmartConnect Systems <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 2023 &copy; <a href="#">SmartConnect</a>
                                </p>
                            </div>
                            <div class="col-12 col-sm-auto text-center">
                                <p class="mb-0 text-600">
                                    v3.16.0
                                </p>
                            </div>
                        </div>
                    </footer>


                </div>

            </div>
        </main>
        <!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->

        <!-- ===============================================-->
        <!--    JavaScripts-->
        <!-- ===============================================-->
        <script src="../../CRM/public/vendors/popper/popper.min.js"></script>
        <script src="../../CRM/public/vendors/bootstrap/bootstrap.min.js"></script>
        <script src="../../CRM/public/vendors/anchorjs/anchor.min.js"></script>
        <script src="../../CRM/public/vendors/is/is.min.js"></script>
        <script src="../../CRM/public/vendors/chart/chart.min.js"></script>
        <script src="../../CRM/public/vendors/countup/countUp.umd.js"></script>
        <script src="../../CRM/public/vendors/echarts/echarts.min.js"></script>
        <script src="../../CRM/public/vendors/dayjs/dayjs.min.js"></script>
        <script src="../../CRM/public/vendors/fontawesome/all.min.js"></script>
        <script src="../../CRM/public/vendors/lodash/lodash.min.js"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
        <script src="../../CRM/public/vendors/list.js/list.min.js"></script>
        <script src="../../CRM/public/assets/js/theme.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../../CRM/public/vendors/list.js/list.min.js"></script>


        <script>
           document.addEventListener('DOMContentLoaded', function() {
    var paymentTypeInput = document.getElementById('payment_type');
    var chequeNoContainer = document.getElementById('chequeNoContainer');
    var chequeNoInput = document.getElementById('ChequeNo');

    function updateChequeNoField() {
        if (paymentTypeInput.value === 'Cheque deposit') {
            chequeNoContainer.style.display = 'block';
            chequeNoInput.required = true;
        } else {
            chequeNoContainer.style.display = 'none';
            chequeNoInput.required = false;
            chequeNoInput.value = ''; // Optional: Clear the Cheque No value if not required
        }
    }

    // Run the update function when the DOM is ready
    updateChequeNoField();

    // Also add an event listener to update the field based on user input
    paymentTypeInput.addEventListener('change', updateChequeNoField);
});

        </script>


        <script>
            $(document).ready(function() {
                $('#newFormBtn').on('click', function() {
                    // Redirect to the specified URL
                    window.location.href = 'https://demo.secretary.lk/finance/cheque/cheque_deposit_slip.php';
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#chequeDepositForm').on('submit', function(event) {

                    $.ajax({
                        url: 'submit_cheque_deposit.php',
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                if (response.refno) {
                                    alert('Slip submitted successfully. REFNO: ' + response.refno);
                                    $('#chequeDepositForm')[0].reset(); // Clear the form values
                                    $('input[type="hidden"]').val('');
                                    // location.reload();
                                    window.location.reload();
                                } else {
                                    alert('Slip updated successfully.');

                                    window.location.href = window.location.href;
                                }
                                // Refresh the page
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                            alert('An error occurred. Please try again.');
                        }
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var paymentTypeInput = document.getElementById('payment_type');
                var chequeNoContainer = document.getElementById('chequeNoContainer');

                function updateChequeNoField() {
                    if (paymentTypeInput.value === 'Cheque deposit') {
                        chequeNoContainer.style.display = 'block';
                    } else {
                        chequeNoContainer.style.display = 'none';
                    }
                }

                // Run on page load
                updateChequeNoField();

                // Add event listener to update the field based on user input
                paymentTypeInput.addEventListener('change', updateChequeNoField);
            });
        </script>




        <script>
            $(document).ready(function() {
                // Handle delete button click
                $(document).on('click', '.deleteButton', function(e) {
                    e.preventDefault(); // Prevent default link behavior

                    var refno = $(this).data('refno'); // Get REFNO from data attribute

                    if (confirm('Are you sure you want to delete this record?')) {
                        $.ajax({
                            url: 'delete_cheque_deposit.php',
                            type: 'POST',
                            data: {
                                refno: refno
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    alert('Record deleted successfully.');
                                    location.reload(); // Refresh the page to reflect changes
                                } else {
                                    alert('Error: ' + response.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr);
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }
                });
            });

        </script>

        <script>
            $(document).ready(function() {
                function fetchBanks(url) {
                    return $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: 'json'
                    });
                }

                function populateBankSelect(banks, selectedBank) {
                    var $bankSelect = $('#Bank');
                    $bankSelect.empty();
                    $bankSelect.append('<option value="" disabled selected>Select a bank</option>');
                    $.each(banks, function(index,
                        bank) {
                        $bankSelect.append('<option value="' + bank + '">' + bank + '</option>');
                    });
                    if (selectedBank) {
                        $bankSelect.val(selectedBank);
                    }
                }

                function updateBankOptions(selectedBank) {
                    var paymentType = $('#payment_type').val();
                    var bankFetchUrl;

                    if (paymentType === 'Cash deposit') {
                        bankFetchUrl = 'get_finance_banks.php';
                    } else if (paymentType === 'Cheque deposit' || paymentType === 'Bank Transfers') {
                        bankFetchUrl = 'get_cheque_deposit_banks.php';
                    }

                    if (bankFetchUrl) {
                        fetchBanks(bankFetchUrl).done(function(data) {
                            populateBankSelect(data, selectedBank);
                        }).fail(function() {
                            alert('Failed to fetch bank names');
                        });
                    }
                }

                $('#payment_type').on('change', function() {
                    updateBankOptions();
                });

                var selectedBank = '<?php echo $bank1 ?? ''; ?>';
                if (selectedBank) {
                    updateBankOptions(selectedBank);
                } else {
                    $('#payment_type').trigger('change');
                }
            });

        </script>

        <!--modal open-->

        <script>
            function setRefNo(refno, hris, division, amount, balanceAmount) {

                const addInvoiceModal = document.getElementById('addInvoiceModal');

                addInvoiceModal.querySelector('#refno').value = refno;
                addInvoiceModal.querySelector('#amount').value = amount;
                addInvoiceModal.querySelector('#balanceamount').value = balanceAmount;

                addInvoiceModal.querySelector('#division').value = division;
                addInvoiceModal.querySelector('#hris').value = hris;

                console.log("Balance amount", balanceAmount , typeof(balanceAmount))
                if(balanceAmount == ""){
                    balanceAmount = amount;
                }
                // Update the balance amount div
                document.getElementById('balanceAmountinmodal').innerHTML = 'Balance Amount: ' + balanceAmount;

                
            }

            //fetch wbs elements when updating wbs Elements
            
              
            function editRow(refno, invoiceNo, wbselement, wbsamount, division, hris, amount, BPcode, balanceAmount) {
                
                
                const addInvoiceModal = document.getElementById('addInvoiceModal');
                addInvoiceModal.querySelector('#refno').value = refno;
                addInvoiceModal.querySelector('#invoiceNo').value = invoiceNo;
                addInvoiceModal.querySelector('#BPcode').value = BPcode;
                addInvoiceModal.querySelector('#hris').value = hris;
                addInvoiceModal.querySelector('#amount').value = amount;
                addInvoiceModal.querySelector('#division').value = division;
                addInvoiceModal.querySelector('#wbs').value = wbselement;
                addInvoiceModal.querySelector('#wbsamount').value = wbsamount;
                
                console.log("balance",balanceAmount)
                
                
            
                // Open the Add Invoice Modal
                $('#addInvoiceModal').modal('show');
                document.getElementById('balanceAmountinmodal').innerHTML = 'Balance Amount: ' + (balanceAmount || amount);
                document.getElementById('addInvoiceBtn').style.display = 'none'
            }
            
            // Function to set the reference number and other data in the Add Invoice Modal
            function setRefNo(refno, hris, division, amount, balanceAmount) {
                const addInvoiceModal = document.getElementById('addInvoiceModal');
            
                addInvoiceModal.querySelector('#refno').value = refno;
                addInvoiceModal.querySelector('#hris').value = hris;
                addInvoiceModal.querySelector('#division').value = division;
                addInvoiceModal.querySelector('#amount').value = amount;
                addInvoiceModal.querySelector('#balanceamount').value = balanceAmount || amount; // Set balanceAmount or default to amount
            
                // Update the balance amount display
                document.getElementById('balanceAmountinmodal').innerHTML = 'Balance Amount: ' + (balanceAmount || amount);
                document.getElementById('updateInvoiceBtn').style.display = 'none'
            }





            function closeModel() {
                $('#addInvoiceModal').modal('hide');
            }

            // jQuery to handle the Add button click
            $(document).ready(function() {
                $('#addInvoiceBtn').on('click', function() {

                    var invoiceNo = $('#invoiceNo').val();
                    var wbs = $('#wbs').val();
                    var wbsamount = $('#wbsamount').val();
                    var refno = $('#refno').val();
                    var hris = $('#hris').val();
                    var division = $('#division').val();
                    var amount = $('#amount').val();
                    var balanceamount = $('#balanceamount').val();
                    var BPcode = $('#BPcode').val();
                    //var balanceamountinmodal = $('#balanceamountinmodal').val();
                    // console.log("A",wbsamount,amount,balanceamount)
                    // $('#balanceforinput').html('<div>balanceamount</div>');
                    if(balanceamount == ""){
                        balanceamount = amount;
                    }
                    
                    if (balanceamount && Number(balanceamount) < wbsamount) {
                        
                        alert('Please Enter low amount to the balance or equal amount to the balance. Your Balance:' + ' ' + balanceamount)
                    } else {
                        var data = {
                            invoiceNo: invoiceNo,
                            wbs: wbs,
                            amount: amount,
                            refno: refno,
                            wbsamount: wbsamount,
                            hris: hris,
                            division: division,
                            balanceamount: balanceamount,
                            BPcode: BPcode,
                            //balanceamountinmodal:balanceamountinmodal,

                        }


                        $.ajax({
                            url: 'add_invoice.php',
                            method: 'POST',
                            data: data,
                            success: function(response) {
                                // console.log("Response", response);
                                if (response.status == 'success') {
                                    alert('successfully added a wbs item.')
                                    // Update the table row (optional, for UI feedback)
                                    // You might need to reload the table or update the specific row
                                    location.reload(); // or update the specific row
                                    // Close the modal
                                    $('#addInvoiceModal').modal('hide');
                                } else {
                                    if(response.status == 'error'){
                                        alert("Error: " + response.message);
                                    }else{
                                        alert('Error: ' + response.error);
                                                                            }
                                }
                            },
                            error: function(xhr, status, error) {
                                // console.error(xhr);
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }


                });
            });
            
            // update the ebs elements
            $(document).ready(function() {
                $('#updateInvoiceBtn').on('click', function() {

                    var invoiceNo = $('#invoiceNo').val();
                    var wbs = $('#wbs').val();
                    var wbsamount = $('#wbsamount').val().trim();
                    var refno = $('#refno').val();
                    var hris = $('#hris').val();
                    var division = $('#division').val().trim();
                    var amount = $('#amount').val();
                    var balanceamount = $('#balanceamount').val();
                    var BPcode = $('#BPcode').val();
                    //var balanceamountinmodal = $('#balanceamountinmodal').val();
                    // console.log("A",wbsamount,amount,balanceamount)
                    // $('#balanceforinput').html('<div>balanceamount</div>');
                    if(balanceamount == ""){
                        balanceamount = amount;
                    }
                    
                    if (balanceamount && Number(balanceamount) < wbsamount) {
                        
                        alert('Please Enter low amount to the balance or equal amount to the balance. Your Balance:' + ' ' + balanceamount)
                    } else {
                        
                        var data = {
                            invoiceNo: invoiceNo,
                            wbs: wbs,
                            amount: amount,
                            refno: refno,
                            wbsamount: wbsamount,
                            hris: hris,
                            division: division,
                            balanceamount: balanceamount,
                            BPcode: BPcode,
 
                        }
    
                        console.log("Came here",data);
                        $.ajax({
                            url: 'wbs_update.php',
                            method: 'POST',
                            data: data,
                            success: function(response) {
                                console.log("Response", response);
                                if (response.status == 'success') {
                                    console.log("Hee hee")
                                    alert('successfully updated a wbs item.')
                                    // Update the table row (optional, for UI feedback)
                                    // You might need to reload the table or update the specific row
                                    location.reload(); // or update the specific row
                                    // Close the modal
                                    $('#addInvoiceModal').modal('hide');
                                    document.getElementById('invoiceForm').reset();
                                } else {
                                    if(response.status == 'error'){
                                        alert("Error: " + response.message);
                                    }else{
                                        console.log("This")
                                        alert('Error: ' + response.error);
                                                                            }
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr);
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }


                });
            });
        </script>

        <script>
            function openWbs(refno) {
                var data = {
                    refno: refno
                }

                $.ajax({
                    url: 'fetch_data.php',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        $('#table-customers-body').html(response);
                        $.ajax({
                            url: 'fetch_balance_amount.php',
                            method: 'POST',
                            data: data,
                            success: function(response) {
                                $('#balanceAmount').html(response);
                                $('#wbsElementModal').modal('show');
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr);
                                alert('An error occurred. Please try again.');
                            }
                        });
                        // $('#wbsElementModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                        alert('An error occurred. Please try again.');
                    }
                });
            }

            function closewbsModel() {
                $('#wbsElementModal').modal('hide');
            }
        </script>

<script>
    function deleteRow(invoiceNo) {
    if (confirm("Are you sure you want to delete this record?")) {
        $.ajax({
            url: 'delete_wbs_record.php', // URL of the PHP file to handle the delete request
            type: 'POST',
            data: { invoiceNo: invoiceNo },
            success: function(response) {
                console.log("Response:", response);

                // Ensure response is parsed as a JSON object
                try {
                    var jsonResponse = JSON.parse(response);

                    if (jsonResponse.status === 'success') {
                        // Remove the row from the table
                        $('td:contains("' + invoiceNo + '")').closest('tr').remove();
                        location.reload();
                        $('#wbsElementModal').modal('hide');
                    } else {
                        alert("Error: " + (jsonResponse.message || "Could not delete the record."));
                    }
                } catch (e) {
                    alert("Error: Invalid response from server.");
                }
            },
            error: function() {
                alert("Error: Could not communicate with the server.");
            }
        });
    }
}


</script>

<script>
    function fetchWbsData() {
    var invoiceNo = $('#invoiceNo').val();

    if(invoiceNo) {
        $.ajax({
            url: 'fetch_wbs_data.php',  
            method: 'POST',
            data: { invoiceNo: invoiceNo },
            success: function(response) {
                if(response.status == 'success') {
                    $('#wbs').val(response.data.wbsElement);
                    $('#wbsamount').val(response.data.wbsAmount);
                    $('#BPcode').val(response.data.BPcode);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                alert('An error occurred. Please try again.');
            }
        });
    } else {
        alert('Please enter an Invoice No.');
    }
}

</script>

        <!--add another invoice number-->
        <script>
            function redirectToReceiptPage(refno) {
                window.location.href = `print_receipt.php?refno=${refno}`;
            }

        </script>



    </body>

</html>