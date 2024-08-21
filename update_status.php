<?php

include('../connect.php');
include('../../CRM/public/EMP_DB_connect.php');

session_start();

if (isset($_SESSION["Validete_session"]) && $_SESSION["Validete_session"] == '1') {
    // session is valid
} else {
    header('Location: ../login.php');
    exit();
}

$PAGE_REDIRECT_PRIVILLEDGE = $_SESSION['PAGE_REDIRECT_PRIVILLEDGE'];
$hris_no = $_SESSION['HRIS_NO'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $refNo = $_POST['refNo'];
    $invoiceNo = $_POST['invoice_no'];
    $USERhrisNo = $_POST['user_hris'];
    $status = $_POST['status'];
    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';

    // Update the database
    if ($reason) {
        $query = "UPDATE CASH_WALLET SET WBS_STATUS = ?, REJECT_REMARK = ? WHERE REF_NO = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $status, $reason, $refNo);
    } else {
        $query = "UPDATE CASH_WALLET SET WBS_STATUS = ? WHERE REF_NO = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $status, $refNo);
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['status'] = 'success';

        $hrisquery = "SELECT HRIS_NO FROM CASH_WALLET where REF_NO='".$_POST['refNo']."'";
        $result = $conn->query($hrisquery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_hris_no = $row['HRIS_NO'];
        } else {
            echo "0 results";
            exit();
        }

        $qrt_HRIS = "SELECT CallingName,Email_Address FROM EMB_DB WHERE HRIS_NO ='".$user_hris_no."'";
        $result_HRIS = mysqli_query($DB_HRIS_conn, $qrt_HRIS);

        if (mysqli_num_rows($result_HRIS) > 0) {
            $row_HRIS = mysqli_fetch_assoc($result_HRIS);
            $USER_EMAIL = $row_HRIS['Email_Address'];
            $USER_name = $row_HRIS['CallingName'];
        }

        // Send email notification after successful update
        if (sendEmailNotification($USER_EMAIL, $status, $reason, $refNo, $invoiceNo)) {
            $response['email_status'] = 'sent';
        } else {
            $response['email_status'] = 'failed';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = $stmt->error;
    }

    $stmt->close();
}

echo json_encode($response);

// Function to send an email notification
function sendEmailNotification($umail, $newStatus, $reason = '', $refNo, $invoiceNo) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Host = "smtp.hostinger.com";
        $mail->Username = "feedback@smartconnect.lk";
        $mail->Password = "Tr2l2ven@123";

        // Recipients
        $mail->setFrom("intranet.finance@smartconnect.lk", "Finance Team");
        $mail->addCC('udariweeraman@gmail.com');
        //$mail->addAddress($umail);
        $mail->addAddress('rwudari@outlook.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Status Update Notification for Payment Deposit Ref No: ' . $refNo;
     $mail->Body = '
     
<!DOCTYPE html><html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en"><head>
    <title>Status Update Notification</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {box-sizing: border-box;}
        body {margin: 0; padding: 0; background-color: #f4f4f4; color: #333;}
        a[x-apple-data-detectors] {color: inherit!important; text-decoration: inherit!important;}
        #MessageViewBody a {color: inherit; text-decoration: none;}
        p {line-height: 1.5;}
        .container {background-color: #ffffff; margin: 0 auto; width: 80%; max-width: 800px; padding: 20px; border-radius: 8px;}
        .header, .footer {background-color: #f8f8f8; padding: 10px; text-align: center; border-bottom: 1px solid #e0e0e0;}
        .footer {border-top: 1px solid #e0e0e0; border-bottom: none;}
        .content {padding: 20px;}
        .highlight {color: #bf223e; font-weight: bold;}
    </style>
</head>

<body class="body" style="background-color:#fff;margin:0;padding:0;-webkit-text-size-adjust:none;text-size-adjust:none"><table class="row row-2" align="center" width="100%" border="0" cellpadding="0" 
cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#840010;border-radius:0;color:#000;width:800px;margin:0 auto" width="800"><tbody><tr><td class="column column-1" width="100%" 
style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="image_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad" style="width:100%"><div class="alignment" align="center" style="line-height:10px"><div style="max-width:800px"><img 
src="https://d15k2d11r6t6rl.cloudfront.net/pub/r388/l239mmxz/fzt/em6/ewg/Red%20and%20White%20Modern%20Sport%20Shoes%20Fashion%20Instagram%20Post_1.png" style="display:block;height:auto;border:0;width:100%" width="800" height="auto"></div></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table><table class="row row-3" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tbody><tr><td><table 
class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:800px;margin:0 auto" width="800"><tbody><tr><td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-bottom:60px;padding-left:60px;padding-right:60px;padding-top:40px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
<table class="text_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class style="font-size:14px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:16.8px;color:#555;line-height:1.2"><p 
style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="word-break: break-word; font-size: 14px;">We would like to inform you that the status of your payment deposit with reference number <strong>'.$refNo.'</strong> has been updated.</span></p></div></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table><table class="row row-4" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" 
style="mso-table-lspace:0;mso-table-rspace:0"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:800px;margin:0 auto" width="800"><tbody><tr><td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table 
class="image_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad" style="width:100%"><div class="alignment" align="center" style="line-height:10px"><div style="max-width:731px"><img src="https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/0db9f180-d222-4b2b-9371-cf9393bf4764/0bd8b69e-4024-4f26-9010-6e2a146401fb/HOTL07/hotl-07-divider.png" 
style="display:block;height:auto;border:0;width:100%" width="731" height="auto"></div></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table><table class="row row-5" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" 
style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:800px;margin:0 auto" width="800"><tbody><tr><td class="column column-1" width="33.333333333333336%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-bottom:45px;padding-top:45px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" 
style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class style="font-size:14px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:16.8px;color:#555;line-height:1.2"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><strong><span style="word-break: break-word; font-size: 16px;">Invoice No:</span></strong></p></div>
</div></td></tr></table><table class="text_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad" style="padding-bottom:15px;padding-top:5px"><div style="font-family:sans-serif"><div class 
style="font-size:14px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:16.8px;color:#bf223e;line-height:1.2"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="word-break: break-word; font-size: 22px;"><strong>'.$invoiceNo.'</strong></span></p></div></div></td></tr></table><table class="image_block block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" 
style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad" style="width:100%;padding-right:0;padding-left:0"><div class="alignment" align="center" style="line-height:10px"><div style="max-width:200px"><img src="https://d15k2d11r6t6rl.cloudfront.net/pub/r388/l239mmxz/oem/za4/3qi/invoice.png" style="display:block;height:auto;border:0;width:100%" width="200" height="auto"></div></div></td></tr></table></td><td class="column column-2" width="33.333333333333336%" 
style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-top:45px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class 
style="font-size:14px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:16.8px;color:#555;line-height:1.2"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><strong><span style="word-break: break-word; font-size: 16px;">Status:</span></strong></p></div></div></td></tr></table><table class="text_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" 
style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad" style="padding-bottom:15px;padding-top:5px"><div style="font-family:sans-serif"><div class style="font-size:14px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:16.8px;color:#bf223e;line-height:1.2"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px">
<span style="word-break: break-word; font-size: 22px;"><strong>'. $newStatus .'</strong></span></p></div></div></td></tr></table><table class="image_block block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad" style="width:100%;padding-right:0;padding-left:0"><div class="alignment" align="center" style="line-height:10px"><div style="max-width:200px"><img 
src="https://d15k2d11r6t6rl.cloudfront.net/pub/r388/l239mmxz/vjh/q39/r3c/status.png" style="display:block;height:auto;border:0;width:100%" width="200" height="auto"></div></div></td></tr></table></td><td class="column column-3" width="33.333333333333336%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-top:45px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block block-1" 
width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class style="font-size:14px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:16.8px;color:#555;line-height:1.2"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px">
<strong><span style="word-break: break-word; font-size: 16px;">Reject Reason:</span></strong></p></div></div></td></tr></table><table class="text_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad" style="padding-bottom:15px;padding-top:5px"><div style="font-family:sans-serif"><div class 
style="font-size:14px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:16.8px;color:#bf223e;line-height:1.2"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="word-break: break-word; font-size: 22px;"><strong>'.($reason ? "{$reason}" : "").'</strong></span></p></div></div></td></tr></table><table class="image_block block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" 
style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad" style="width:100%;padding-right:0;padding-left:0"><div class="alignment" align="center" style="line-height:10px"><div style="max-width:200px"><img src="https://d15k2d11r6t6rl.cloudfront.net/pub/r388/l239mmxz/rr6/0b3/xgn/reason.png" style="display:block;height:auto;border:0;width:100%" width="200" height="auto"></div></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table><table 
class="row row-6" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:800px;margin:0 auto" width="800"><tbody><tr><td class="column column-1" width="100%" 
style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-bottom:20px;padding-top:20px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class 
style="font-size:14px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:16.8px;color:#bf223e;line-height:1.2"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="word-break: break-word; font-size: 30px;"><strong>View the status of Payment Deposit</strong></span></p></div></div></td></tr></table><table class="button_block block-2" width="100%" border="0" cellpadding="0" 
cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad" style="padding-bottom:15px;padding-top:30px;text-align:center"><div class="alignment" align="center"><!--[if mso]>
<v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" style="height:58px;width:174px;v-text-anchor:middle;" arcsize="21%" stroke="false" fillcolor="#bf223e">
<w:anchorlock/>
<v:textbox inset="0px,0px,0px,0px">
<center dir="false" style="color:#ffffff;font-family:"Trebuchet MS", Tahoma, sans-serif;font-size:14px">
<![endif]--><div style="background-color:#bf223e;border-bottom:0 solid transparent;border-left:0 solid transparent;border-radius:12px;border-right:0 solid transparent;border-top:0 solid transparent;color:#fff;display:inline-block;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;font-size:14px;font-weight:700;mso-border-alt:none;padding-bottom:15px;padding-top:15px;text-align:center;text-decoration:none;width:auto;word-break:keep-all">
 <a href="https://demo.secretary.lk/finance/login.php" style="text-decoration: none;">
                    <span style="word-break: break-word; padding-left: 30px; padding-right: 30px; font-size: 16px; display: inline-block; letter-spacing: normal; background-color:#a80321; color: #ffffff; line-height: 40px; border-radius: 5px;">
                      View the status
                    </span></span></div><!--[if mso]></center></v:textbox></v:roundrect><![endif]--></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table><table class="row row-7" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" 
style="mso-table-lspace:0;mso-table-rspace:0"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;background-color:#a80321;width:800px;margin:0 auto" width="800"><tbody><tr><td class="column column-1" width="100%" 
style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-bottom:45px;padding-top:35px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class 
style="font-size:14px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:16.8px;color:#fff;line-height:1.2"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="word-break: break-word; color: #ffffff; font-size: 30px;"><strong>Finance Team</strong></span></p></div></div></td></tr></table><table class="text_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" 
style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad" style="padding-left:45px;padding-right:45px"><div style="font-family:sans-serif"><div class style="font-size:14px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:16.8px;color:#fff;line-height:1.2"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px">
<span style="word-break: break-word; color: #ffffff; font-size: 16px;">If you have any questions or need further assistance, please do not hesitate to contact us</span></p></div></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table><table class="row row-8" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" 
cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:800px;margin:0 auto" width="800"><tbody><tr><td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="image_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" 
style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad" style="width:100%"><div class="alignment" align="center" style="line-height:10px"><div style="max-width:800px"><img src="https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/0db9f180-d222-4b2b-9371-cf9393bf4764/0bd8b69e-4024-4f26-9010-6e2a146401fb/HOTL07/hotl-07-footer-img.png" style="display:block;height:auto;border:0;width:100%" width="800" height="auto"></div></div></td></tr></table></td></tr></tbody></table></td>
</tr></tbody></table><table class="row row-9" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;color:#000;width:800px;margin:0 auto" width="800"><tbody><tr><td class="column column-1" width="100%" 
style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-bottom:25px;padding-top:25px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class 
style="font-size:12px;font-family:Montserrat,"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif;mso-line-height-alt:14.399999999999999px;color:#555;line-height:1.2"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="word-break: break-word; font-size: 12px;"><strong>Our mailing address:</strong></span></p><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px">intranet.finance@smartconnect.lk</p>
</div></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><!-- End --><div style="background-color:transparent;">
    <div style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
            <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 500px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
            <!--[if (mso)|(IE)]><td align="center" width="500" style=" width:500px; padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:15px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;">
                <div style="background-color: transparent; width: 100% !important;">
                    <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:15px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
                        <!--<![endif]-->


                     

                        <!--[if (!mso)&(!IE)]><!-->
                    </div><!--<![endif]-->
                </div>
            </div>
            <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
    </div>
</div></body></html>';



        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
?>