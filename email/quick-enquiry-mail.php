<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}

if($_POST) {

   // 1. Catch all the fields from the Quick Enquiry Form
   $name = trim(stripslashes($_POST['name']));
   $phone = trim(stripslashes($_POST['phone']));
   $company = trim(stripslashes($_POST['company']));
   $gst_no = trim(stripslashes($_POST['gst_no']));
   $product = trim(stripslashes($_POST['product']));
   $quantity = trim(stripslashes($_POST['quantity']));
   
   $cargo_mode = isset($_POST['cargo_mode']) ? trim(stripslashes($_POST['cargo_mode'])) : 'Not Selected';
   $shipment = isset($_POST['shipment']) ? trim(stripslashes($_POST['shipment'])) : 'Not Selected';
   $company_type = isset($_POST['company_type']) ? trim(stripslashes($_POST['company_type'])) : 'Not Selected';
   
   $city = trim(stripslashes($_POST['city']));
   $email = trim(stripslashes($_POST['email']));
   $enquiry_message = trim(stripslashes($_POST['message']));
   
   $subject = "New Quick Enquiry - " . $company;

   // 2. Build the Email HTML Table
   $message = '<table width="600" cellpadding="0" cellspacing="0" border="1" style="border-collapse:collapse; font-family: Arial, sans-serif;">      
      <tr style="padding:10px;">
        <td colspan="2" style="padding:15px; text-align:center; background-color:#f4f4f4;">
          <img src="https://ojs-winfreight.com/assets/images/header-logo.png" style="width:150px" alt="OJS-WIN Logo" />
          <h2 style="color:#005580; margin-bottom:0;">New Quick Enquiry</h2>
        </td> 
      </tr>      
      
      <tr style="padding:10px">
        <td colspan="2" style="background-color:#e0e0e0; padding:10px; text-align:center; font-weight: bold;">Contact Information</td>     
      </tr>
      <tr style="padding:10px;">
        <td style="background-color:#005683; padding:10px; color:white; width: 40%; font-weight: bold;">Name:</td>     
        <td style="padding:10px;">'.$name.'</td>     
      </tr>
      <tr style="padding:10px;">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Email:</td>     
        <td style="padding:10px;">'.$email.'</td>      
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Phone Number:</td>     
        <td style="padding:10px;">'.$phone.'</td>     
      </tr>
      
      <tr style="padding:10px">
        <td colspan="2" style="background-color:#e0e0e0; padding:10px; text-align:center; font-weight: bold;">Company Details</td>     
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Company Name:</td>     
        <td style="padding:10px;">'.$company.'</td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">GST No:</td>     
        <td style="padding:10px;">'.$gst_no.'</td>     
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Company Type:</td>     
        <td style="padding:10px;">'.$company_type.'</td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">City:</td>     
        <td style="padding:10px;">'.$city.'</td>
      </tr>

      <tr style="padding:10px">
        <td colspan="2" style="background-color:#e0e0e0; padding:10px; text-align:center; font-weight: bold;">Enquiry Details</td>     
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Product Needed:</td>     
        <td style="padding:10px;"><strong>'.$product.'</strong></td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Order Quantity:</td>     
        <td style="padding:10px;">'.$quantity.'</td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Cargo Mode:</td>     
        <td style="padding:10px;">'.$cargo_mode.'</td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Shipment Type:</td>     
        <td style="padding:10px;">'.$shipment.'</td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Additional Message:</td>     
        <td style="padding:10px;">'.nl2br($enquiry_message).'</td>
      </tr>

   </table>';

   $message .= "<br /> This email was sent from your site " . url() . " Quick Enquiry form. <br />";

    // 3. Send the Email
    try {
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'noreply.fivetwo@gmail.com';                     
        $mail->Password   = 'ansnldwyarasqpce';                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
        $mail->Port       = 587;                                    

        // Recipients
        $mail->setFrom('noreply.fivetwo@gmail.com', 'OJS WIN Website');
        
        // --- THIS SENDS IT TO THE CORRECT INQUIRY INBOX ---
        $mail->addAddress('inquiry@ojswinsourcing.com', 'OJS-WIN Inquiries');  

        // Content
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo 'OK';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>