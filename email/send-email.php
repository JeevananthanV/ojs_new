<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/*
require 'PHPMailer/PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer/PHPMailer.php';
require 'PHPMailer/PHPMailer/SMTP.php';
*/

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

   $firstName = trim(stripslashes($_POST['firstName']));
   $lastName = trim(stripslashes($_POST['lastName']));
   $email = trim(stripslashes($_POST['email']));
   $phone = trim(stripslashes($_POST['phone']));
   $work_type = isset($_POST['workType']) ? trim(stripslashes($_POST['workType'])) : 'Not Provided';

   $contact_message = trim(stripslashes($_POST['message']));
  $rqrecaptcha= $_POST['g-recaptcha-response'];
   if ($subject == '') { $subject = "OJS WIN Logistics - Contact Form Submission"; }

   // Set Message
 

   $message .= '<table width="400" cellpadding="0" cellspacing="0" border="1" style="border-collapse:collapse;">      
      <tr style="padding:10px;">
     <td colspan="2" style="padding:5px;text-align:center;">
     <img src="https://ojs-winfreight.com/assets/images/header-logo.png" style="width:100px" />
     </td> 
   </tr>      
   <tr style="padding:10px;">
     <td style="background-color:#005683;padding:5px;color:white">First Name:</td>     
     <td style="padding:5px;">'.$firstName.'</td>		  
   </tr>
     <tr style="padding:10px;">
     <td style="background-color:#005683;padding:5px;color:white">Last Name:</td>     
     <td style="padding:5px;">'.$lastName.'</td>		  
   </tr>
   <tr style="padding:10px">
   <td style="background-color:#005683;padding:5px;color:white">Email:</td>     
   <td style="padding:5px;">'.$email.'</td>		  
 </tr>
    <tr style="padding:10px">
   <td style="background-color:#005683;padding:5px;color:white">Phone:</td>     
   <td style="padding:5px;">'.$phone.'</td>		  
 </tr>
  <tr style="padding:10px">
            <td style="background-color:#005683;padding:5px;color:white">Line of Work:</td>     
            <td style="padding:5px;">' .  $work_type . '</td>
        </tr>
<tr style="padding:10px">
     <td style="background-color:#005683;padding:5px;color:white">Message:</td>     
     <td style="padding:5px;">'.$contact_message.'</td>
   </tr>

 </table>';


$message .= "<br /> This email was sent from your site " . url() . " contact form. <br />";

//reCAPTCHA validation
if (!empty($rqrecaptcha)) {
try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->SMTPDebug = 2;                      //Enable verbose debug output

    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'noreply.fivetwo@gmail.com';                     //SMTP username
    // $mail->Password   = 'qllsuznbzyugrvux';   
    $mail->Password   = 'ansnldwyarasqpce';                         //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('noreply.fivetwo@gmail.com', 'OJS WIN Logistics');
    //$mail->addAddress('prabhu.c@ojs-winfreight.com', 'Prabhu Chandhrasekar');  
  	    $mail->addAddress('aarthi@five2digitals.com', 'Prabhu Chandhrasekar');  

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = $message;

    $mail->send();
    echo 'OK';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
}
?>