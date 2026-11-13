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

   // 1. Catch all the new fields from the Business Trip Form
   $passport_no = trim(stripslashes($_POST['passport_no']));
   $passport_validity = trim(stripslashes($_POST['passport_validity']));
   $name = trim(stripslashes($_POST['name']));
   $phone = trim(stripslashes($_POST['phone']));
   $company = trim(stripslashes($_POST['company']));
   $position = trim(stripslashes($_POST['position']));
   $business_type = isset($_POST['business_type']) ? trim(stripslashes($_POST['business_type'])) : 'Not Provided';
   $city = trim(stripslashes($_POST['city']));
   $china_fair = isset($_POST['china_fair']) ? trim(stripslashes($_POST['china_fair'])) : 'Not Provided';
   $product = trim(stripslashes($_POST['product']));
   $email = trim(stripslashes($_POST['email']));
   $trip_message = trim(stripslashes($_POST['message']));
   
   $subject = "New China Business Trip Booking - " . $name;

   // 2. Build the Email HTML Table
   $message = '<table width="600" cellpadding="0" cellspacing="0" border="1" style="border-collapse:collapse; font-family: Arial, sans-serif;">      
      <tr style="padding:10px;">
        <td colspan="2" style="padding:15px; text-align:center; background-color:#f4f4f4;">
          <img src="https://ojs-winfreight.com/assets/images/header-logo.png" style="width:150px" alt="OJS-WIN Logo" />
          <h2 style="color:#005580; margin-bottom:0;">New Business Trip Booking</h2>
        </td> 
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
        <td colspan="2" style="background-color:#e0e0e0; padding:10px; text-align:center; font-weight: bold;">Passport & Company Details</td>     
      </tr>

      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Passport No:</td>     
        <td style="padding:10px;">'.$passport_no.'</td>     
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Passport Validity:</td>     
        <td style="padding:10px;">'.$passport_validity.'</td>     
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Company Name:</td>     
        <td style="padding:10px;">'.$company.'</td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Position:</td>     
        <td style="padding:10px;">'.$position.'</td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">City:</td>     
        <td style="padding:10px;">'.$city.'</td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Business Type:</td>     
        <td style="padding:10px;">'.$business_type.'</td>
      </tr>

      <tr style="padding:10px">
        <td colspan="2" style="background-color:#e0e0e0; padding:10px; text-align:center; font-weight: bold;">Trip Preferences</td>     
      </tr>

      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">China Fair Selected:</td>     
        <td style="padding:10px;"><strong>'.$china_fair.'</strong></td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Product Looking For:</td>     
        <td style="padding:10px;">'.$product.'</td>
      </tr>
      <tr style="padding:10px">
        <td style="background-color:#005683; padding:10px; color:white; font-weight: bold;">Additional Message:</td>     
        <td style="padding:10px;">'.nl2br($trip_message).'</td>
      </tr>

   </table>';

   $message .= "<br /> This email was sent from your site " . url() . " Book Your Trip form. <br />";

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