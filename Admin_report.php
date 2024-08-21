<?php

include('../connect.php');
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
.header {
            position: relative;
            text-align: center;
            padding: 1rem;
            background-color: #04404b; /* Primary Bootstrap color */
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 0.375rem; /* Rounded corners */
        }
        .header h4 {
            margin: 0;
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
                            <a class="navbar-brand" href="admin_dashboard.php">
                                <i class="fas fa-chevron-left text-secondary"></i>
                            </a>
                            
                                <div class="card-body">


                                <div class="container" style=" margin: auto; padding: 20px; border-radius: 8px; box-shadow: 8px; box-shadow:0 0 10px rgba(148, 234, 239, 0.905);">
                                    <div class="row g-0">
                                        <div class="header">  
                                            <h4>REPORT</h4>
                                        </div>
                                    </div>
                                </div>

                                        <div>

                                        </div>

                                        <div class="content">
                                            

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


                                            <div style="margin-top: 15px;">

    <div class="card overflow-hidden mt-3">
        <div class="p-4">
            <div class="table-responsive scrollbar">
                <?php
                if ($emp_privilage == 200) {
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
                                cw.INVOICE_NO IS NOT NULL"; // Fixed the WHERE clause

                            if ($startDate && $endDate) {
                                $sql .= " AND cd.DATE BETWEEN '$startDate' AND '$endDate'";
                            }

                            $result = $conn->query($sql);

                            if (!$result) {
                                echo "Error: " . $conn->error;
                            } else {
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
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                } else if ($emp_privilage == 51) {
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
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php
                            $sql = "SELECT
                                *
                            FROM
                                CHEQUE_DEPOSIT";

                            if ($startDate && $endDate) {
                                $sql .= " AND DATE BETWEEN '$startDate' AND '$endDate'";
                            }

                            $result = $conn->query($sql);

                            if (!$result) {
                                echo "Error: " . $conn->error;
                            } else {
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
                                    echo "</tr>";
                                }
                            }
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











                                    </div>
                                </div>
                                '

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

                                    new DataTable('#PaymentsTable',
                                        {

                                            layout: {

                                                topStart: {

                                                    buttons: [
                                                        'copyHtml5',
                                                        'excelHtml5',
                                                        'csvHtml5',
                                                        {
                                                            extend: 'pdfHtml5',
                                                            orientation: 'landscape',
                                                            // Set the orientation to landscape
                                                            pageSize: 'A4',
                                                            // You can specify the page size as well (optional)
                                                            title: 'Payments Report' // Add a title to the PDF (optional)
                                                        }]

                                                }

                                            }

                                        });

                                });


                            </script>

                        </body>

                    </html>