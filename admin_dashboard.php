<?php

include('../connect.php');
include('../../CRM/public/EMP_DB_connect.php');

ini_set('display_errors', 'On');
session_start();


     if(isset($_SESSION["Validete_session"]) == '1') {
    //     //session is set
    //     header('Location: ../login.php');
     }else{
         
        header('Location: ../login.php');
         
     }

$PAGE_REDIRECT_PRIVILLEDGE = $_SESSION['PAGE_REDIRECT_PRIVILLEDGE'];
$hris_no = $_SESSION['HRIS_NO'];
$emp_privilage = $_SESSION['emp_privilege'];

$da = date('Y-m-d H:i:s');
$date_now = date('Y-m-d');
//session_start();
$startDate = null;
$endDate = null;

if (isset($_POST['dateRange'])) {
    $dateRange = $_POST['dateRange'];
    error_log("Received date range: " . $dateRange);

    $dates = explode(" to ", $dateRange);
    if (count($dates) == 2) {
        $startDate = $dates[0];
        $endDate = $dates[1];
    } elseif (count($dates) == 1) {
        $startDate = $dates[0];
        $endDate = $dates[0];
    }

    error_log("Start date: " . $startDate);
    error_log("End date: " . $endDate);
}

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
    <script src="../../CRM/public/vendors/flatpickr/flatpickr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <link href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" rel="stylesheet" />


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="../../CRM/public/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link href="../../CRM/public/assets/css/theme-rtl.css" rel="stylesheet" id="style-rtl">
    <link href="../../CRM/public/assets/css/theme.css" rel="stylesheet" id="style-default">
    <link href="../../CRM/public/assets/css/user-rtl.css" rel="stylesheet" id="user-style-rtl">
    <link href="../../CRM/public/assets/css/user.css" rel="stylesheet" id="user-style-default">
    <link href="../../CRM/public/vendors/flatpickr/flatpickr.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->


<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

            <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
            <a class="navbar-brand me-1 me-sm-3" href="../index.html" id="loader">
              <div class="d-flex align-items-center"><img class="me-2" src="../main.png" alt="" width="100" />
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
               <?php echo $_SESSION['CallingName'];?>
              <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                          <a class="navbar-brand" href="cheque_deposit_slip.php">
                        <i class="fas fa-chevron-left text-secondary"></i> 
                    </a>
              <div class="card font-sans-serif" style="background-image: url('bgg.jpeg'); background-size: cover; background-position: center; height:170px;">
                  
                  <div class="card-body">
            
                    <div class="row g-0">
          <div class="position-relative text-center">
   <h4 style="color: white;">Admin dashboard</h4>

  </div>
  
    <div class="row g-0 justify-content-end mt-3">
      <div class="col-md-4">
        <div class="card font-sans-serif" style="background-color: #012d38;">
          <div class="card-header pb-0">
            <h6 class="mb-0 text-info">All Deposits</h6>
          </div>
    
          <?php 
          // Initialize total as 0 in case no conditions are met
          $total = 0;
    
          if ($emp_privilage == 200) {
              $sql = "SELECT count(*) as total FROM CASH_WALLET WHERE WBS_STATUS = 'Pending'"; 
              $result = $conn->query($sql);
    
              if ($result) {
                  $row = $result->fetch_assoc(); // Fetch associative array
                  $total = $row['total']; // Access the 'total' column
              }
          } elseif ($emp_privilage == 51) {
              $sql = "SELECT count(*) as total FROM CHEQUE_DEPOSIT WHERE DEPOSIT_STATUS = 'Pending'"; 
              $result = $conn->query($sql);
    
              if ($result) {
                  $row = $result->fetch_assoc(); 
                  $total = $row['total']; // Access the 'total' column
              }
          }
          ?>
    
          <div class="card-body">
            <div class="row g-0">
              <div class="col-6">
                <h4 class="text-700 lh-1 mb-1"><?php echo $total; ?></h4>
                <small class="badge rounded badge-subtle-success false">
                  <a href="Admin_report.php" style="color: inherit; text-decoration: none;">View Reports</a>
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



          
          
        <div class="content">
                  <div class="d-flex mb-4 mt-3"><span class="fa-stack me-2 ms-n1"><i class="fas fa-circle fa-stack-2x text-300"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-percentage"></i></span>
                    <div class="col">
                      <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">CHEQUE DEPOSIT SLIP LIST</span><span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span></h5>
                      <p class="mb-0">You can view All deposits.</p>
                    </div>
                  </div>

                <form id="dateRangeForm" method="POST" action="">
                            <div class="row mt-2">
                                <div class="d-flex justify-content-between align-items-end">
                                    <div class="col-6">
                                        <label class="form-label" for="timepicker2">Select Date Range</label>
                                        <input class="form-control datetimepicker" name="dateRange" type="text"
                                            placeholder="Y-m-d to Y-m-d"
                                            data-options='{"mode":"range","dateFormat":"Y-m-d","disableMobile":true}' />
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-primary" type="submit"
                                            value="searchbutton">Search</button>
                                            <button class="btn btn-secondary" type="button" id="resetButton">Reset</button>
                                    </div>
                                </div>
                            </div>
                </form>
                
                
                   <div style="margin-top: 15px;" >
                    <!-- The table will be dynamically loaded here -->
                    <div class="card overflow-hidden mt-3">
                <div class="p-4">
                    <div class="table-responsive scrollbar">
                        <?php
                            if($emp_privilage == 200){
                               ?>
                               <table class="table table-bordered table-striped fs-10 mb-0" id="PaymentsTable">
                            <thead class="bg-200">
                                <tr>
                                    <th class="text-info" data-sort="user_hris">USER HRIS</th>
                                    <th class="text-info" data-sort="refno">REF NO</th>
                                    <th class="text-info" data-sort="payment type">PAYMENT TYPE</th>
                                    <th class="text-info" data-sort="division">DIVISION</th>
                                    <th class="text-info" data-sort="amount">AMOUNT</th>
                                    <th class="text-info" data-sort="invoice_no">INVOICE NO</th>
                                    <th class="text-info" data-sort="wbs_element">WBS ELEMENT</th>
                                    <th class="text-info" data-sort="wbs_amount">WBS AMOUNT</th>
                                    <th class="text-info" data-sort="wbs_division">WBS DIVISION</th>
                                    <th class="text-info" data-sort="customer_code">CUSTOMER CODE</th>
                                    <th class="text-info" data-sort="submitted_by">SUBMITTED BY</th>
                                    <th class="text-info" data-sort="cheque_no">CHEQUE NO</th>
                                    <th class="text-info" data-sort="bank">BANK</th>
                                    <th class="text-info" data-sort="advance">ADVANCE</th>
                                    <th class="text-info" data-sort="debtor_recovery">DEBTOR RECOVERY</th>
                                    <th class="text-info" data-sort="date">DATE</th>
                                    <th class="text-info" data-sort="action">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php
                                    $sql = "SELECT 
                                        cd.*, 
                                        cw.INVOICE_NO, 
                                        cw.WBS_ELEMENT, 
                                        cw.WBS_AMOUNT, 
                                        cw.DIVISION AS wbs_division
                                    FROM 
                                        CHEQUE_DEPOSIT cd
                                    LEFT JOIN 
                                        CASH_WALLET cw 
                                    ON 
                                        cd.REFNO = cw.REF_NO
                                    WHERE 
                                        cw.WBS_STATUS = 'Pending'";
                                    
                                    if ($startDate && $endDate) {
                                        $sql .= " AND cd.DATE BETWEEN '$startDate' AND '$endDate'";
                                    }
                                    
                                    
                                    $result = $conn->query($sql);
                                     while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td class='text-nowrap' style='color: #83f7cb;'>" . $row['USER_HRIS'] . "</td>";
                                        echo "<td class='text-nowrap' style='color: #f7c579;'>" . $row['REFNO'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['PAYMENT_TYPE'] . "</td>";
                                       
                                        echo "<td class='text-nowrap'>" . $row['DIVISION'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['AMOUNT'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['INVOICE_NO'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['WBS_ELEMENT'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['WBS_AMOUNT'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['wbs_division'] . "</td>";
                                        
                                        echo "<td class='text-nowrap'>" . $row['CUSTOMER_CODE'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['SUBMITTED_BY'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['CHEQUE_NO'] . "</td>";
                                       
                                        
                                        echo "<td class='text-nowrap'>" . $row['BANK'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['ADVANCE'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['DEBTOR_RECOVERY'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['DATE'] . "</td>";
                                        echo "<td class='text-nowrap'>
        <button id='button-action" . $row['REFNO'] . "' class='btn btn-primary' onclick='performAction(\"" . $row['REFNO'] . "\",\"" . $row['INVOICE_NO'] . "\")'>Action</button>
      </td>";
echo "</tr>";   
                                    echo "</tr>";
                                    }

                                    // $stmt->close();
                                ?>
                                </tbody>
                        </table>
                               <?php 
                            } else if($emp_privilage == 51){
                                ?>
                                    <table class="table table-bordered table-striped fs-10 mb-0" id="PaymentsTable">
                                        <thead class="bg-200">
                                            <tr>
                                                <th class="text-info" data-sort="user_hris">USER HRIS</th>
                                                <th class="text-info" data-sort="refno">REF NO</th>
                                                <th class="text-info" data-sort="payment type">PAYMENT TYPE</th>
                                                <th class="text-info" data-sort="division">DIVISION</th>
                                                <th class="text-info" data-sort="amount">AMOUNT</th>
                                                <th class="text-info" data-sort="customer_code">CUSTOMER CODE</th>
                                                <th class="text-info" data-sort="submitted_by">SUBMITTED BY</th>
                                                <th class="text-info" data-sort="cheque_no">CHEQUE NO</th>
                                                <th class="text-info" data-sort="bank">BANK</th>
                                                <th class="text-info" data-sort="advance">ADVANCE</th>
                                                <th class="text-info" data-sort="debtor_recovery">DEBTOR RECOVERY</th>
                                                <th class="text-info" data-sort="date">DATE</th>
                                                <th class="text-info" data-sort="action">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                        <?php
                                    $sql = "SELECT 
                                        cd.*
                                    FROM 
                                        CHEQUE_DEPOSIT cd
                                    WHERE 
                                        DEPOSIT_STATUS = 'Pending'";
                                    
                                    if ($startDate && $endDate) {
                                        $sql .= " AND cd.DATE BETWEEN '$startDate' AND '$endDate'";
                                    }
                                    
                                    
                                    $result = $conn->query($sql);
                                     while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td class='text-nowrap' style='color: #83f7cb;'>" . $row['USER_HRIS'] . "</td>";
                                        echo "<td class='text-nowrap' style='color: #f7c579;'>" . $row['REFNO'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['PAYMENT_TYPE'] . "</td>";
                                       
                                        echo "<td class='text-nowrap'>" . $row['DIVISION'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['AMOUNT'] . "</td>";
                                        
                                        echo "<td class='text-nowrap'>" . $row['CUSTOMER_CODE'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['SUBMITTED_BY'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['CHEQUE_NO'] . "</td>";
                                       
                                        
                                        echo "<td class='text-nowrap'>" . $row['BANK'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['ADVANCE'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['DEBTOR_RECOVERY'] . "</td>";
                                        echo "<td class='text-nowrap'>" . $row['DATE'] . "</td>";
                                        echo "<td class='text-nowrap'>
        <button id='button-action" . $row['REFNO'] . "' class='btn btn-primary' onclick='chequeAction(\"" . $row['REFNO'] . "\")'>Action</button>
      </td>";
echo "</tr>";   
                                    echo "</tr>";
                                    }

                                    // $stmt->close();
                                ?>
                                </tbody>
                        </table>
                                <?php
                            }
                        ?>
                        
                        
                    </div>
                </div>
            </div>
                    
                    </div>
    


           
          
         </div>
       
          
          <!-- Modal HTML -->

<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-content" style="background-color: #0f1e4d;"> 
        
            <div class="modal-header" style="background-color: #072170; color: #fff;">
                <h5 class="modal-title" id="actionModalLabel">Perform Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="actionForm">
                    <input type="hidden" id="refNo" name="refNo" />
                    <input type="hidden" id="invoiceNo" name="refNo" />
                    <div id="rejectReasonContainer" style="display:none;">
                        <label for="rejectReason">Reason for Rejection:</label>
                        <textarea id="rejectReason" name="rejectReason" class="form-control"></textarea>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" id="approveButton" class="btn btn-success me-2">Approve</button>
                        <button type="button" id="rejectButton" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Deposit Modal HTML -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-content" style="background-color: #0f1e4d;"> 
        
            <div class="modal-header" style="background-color: #072170; color: #fff;">
                <h5 class="modal-title" id="actionModalLabel">The mobile number of the recipient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="depositForm">
                    <input type="hidden" id="refNo" name="refNo" />
                    <div id="accountNoContainer">
                        <label for="accountNo">Mobile Number:</label>
                        <input class="form-control" id="accountNo" name="accountNo" required/>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" id="receiveButton" class="btn btn-success me-2">Done</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

          
       
      
      
        </div>
      </div>'
      
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
      <script src="../../CRM/public/vendors/list.js/list.min.js"></script>
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
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>

    <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>

    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
    
    
<script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr(".datetimepicker", {
                mode: "range",
                dateFormat: "Y-m-d",
                disableMobile: true,
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 1) {
                        instance.input.value = dateStr + " to " + dateStr;
                    }
                }
            });
        });
        
            // Reset button functionality
            $('#resetButton').click(function () {
                $('input[name="dateRange"]').val('');
                $('#dateRangeForm').submit();
            });
    </script>

    <script>
        $(document).ready(function () {

            new DataTable('#PaymentsTable', {

                layout: {

                    topStart: {

                       buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape', // Set the orientation to landscape
                    pageSize: 'A4', // You can specify the page size as well (optional)
                    title: 'Payments Report' // Add a title to the PDF (optional)
                }
            ]

                    }

                }

            });

        });
        
    
      
    </script>
    
<script>
$(document).ready(function () {
    window.performAction = function (refNo,invoice_no) {
        console.log("WWW",refNo,invoice_no);
        $('#refNo').val(refNo);
        $('#invoiceNo').val(invoice_no);
        $('#rejectReasonContainer').hide();
        $('#actionModal').modal('show');
    }

    // Approve button click handler
    $('#approveButton').click(function () {
        updateStatus('Approved', '');
        $('#approveButton').hide(); // Hide Approve button
        $('#rejectButton').hide(); // Hide Reject button
    });

    // Reject button click handler
    $('#rejectButton').click(function () {
        if ($('#rejectReasonContainer').is(':visible')) {
            var reason = $('#rejectReason').val();
            if (reason.trim() === '') {
                alert('Please enter a reason for rejection.');
                return;
            }
            updateStatus('Rejected', reason);
            $('#approveButton').hide(); // Hide Approve button
            $('#rejectButton').hide(); // Hide Reject button
        } else {
            $('#rejectReasonContainer').show();
        }
    });

    function updateStatus(status, reason) {
        var refNo = $('#refNo').val();
        var invoice_no = $('#invoiceNo').val();
        $.ajax({
            url: 'update_status.php',
            type: 'POST',
            data: { refNo: refNo,invoice_no: invoice_no ,status: status, reason: reason },
            success: function (response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#actionModal').modal('hide');
                    alert('Status updated successfully.');
                    location.reload(); // Refresh the page

                    // Hide the button and show the Applied text
                    var button = document.getElementById('button-action' + refNo);
                    if (button) {
                        button.style.display = 'none';

                        var newDiv = document.createElement('div');
                        newDiv.innerHTML = 'Applied';
                        newDiv.classList.add('text-success');
                        newDiv.style.pointerEvents = 'none';

                        button.parentElement.appendChild(newDiv);
                    }
                } else {
                    alert('Failed to update status. Please try again.');
                    console.error('Error:', res.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                alert('Failed to update status. Please try again.');
            }
        });
    }
    
});
</script>
<script>
    $(document).ready(function() {
    // Define window function
    window.chequeAction = function(refNo) {
        $('#refNo').val(refNo);
        $('#depositModal').modal('show');
    }

    // Click event for receive button
    $('#receiveButton').click(function() {
        var accountNo = $('#accountNo').val(); // Assuming you have an input with id 'refNo'
        var refNo = $('#refNo').val();
        updateDepositStatus('Received', accountNo, refNo);
        $('#receiveButton').hide();
    });

    // Function to update deposit status via AJAX
    function updateDepositStatus(status, accountNo, refNo) {
        console.log("Updating status:", status, "for account:", accountNo, "with refNo:", refNo);

        $.ajax({
            url: 'deposit_receive_status.php',
            type: 'POST',
            data: { refNo: refNo, status: status, accountNo: accountNo },
            success: function(response) {
                console.log("Response:", response);
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#depositModal').modal('hide');
                    alert('Status updated successfully.');
                    location.reload();
                } else {
                    alert('Failed to update status. Please try again.');
                    console.error('Error:', res.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                alert('Failed to update status. Please try again.');
            }
        });
    }
});

</script>



  </body>

</html>

