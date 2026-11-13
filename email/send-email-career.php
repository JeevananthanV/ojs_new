<?php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

// Function to get the base URL
function url() {
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']
    );
}

// Set upload folder path
$upload_folder = '../uploads/';
$uploadFilePath = '';

if ($_POST) {
    // Retrieve form data
    $firstName = trim(stripslashes($_POST['firstName']));
    $lastName = trim(stripslashes($_POST['lastName']));
    $email = trim(stripslashes($_POST['email']));
    $phone = trim(stripslashes($_POST['phone']));
    $currentEmployeeStatus = trim(stripslashes($_POST['currentEmployeeStatus']));
    $position = trim(stripslashes($_POST['position']));
    $currentCTC = trim(stripslashes($_POST['currentCTC']));
    $expectedCTC = trim(stripslashes($_POST['expectedCTC']));
    $experience = trim(stripslashes($_POST['experience']));
    $relocate = trim(stripslashes($_POST['relocate']));
    $immediateJoin = trim(stripslashes($_POST['immediateJoin']));
    $rqrecaptcha = $_POST['g-recaptcha-response'];

    // Subject
    $subject = "OJS WIN Logistics - Career Form Submission";

    // Prepare HTML message
    $message = '<table width="400" cellpadding="0" cellspacing="0" border="1" style="border-collapse:collapse;">      
        <tr style="padding:10px;">
            <td colspan="2" style="padding:5px;text-align:center;">
                <img src="https://ojs-winfreight.com/assets/images/header-logo.png" width="100px" />
            </td> 
        </tr>      
        <tr style="padding:10px;">
            <td style="background-color:#005683;padding:5px;color:white">First Name:</td>     
            <td style="padding:5px;">' . $firstName . '</td>		  
        </tr>
        <tr style="padding:10px;">
            <td style="background-color:#005683;padding:5px;color:white">Last Name:</td>     
            <td style="padding:5px;">' . $lastName . '</td>		  
        </tr>
        <tr style="padding:10px">
            <td style="background-color:#005683;padding:5px;color:white">Email:</td>     
            <td style="padding:5px;">' . $email . '</td>		  
        </tr>
        <tr style="padding:10px">
            <td style="background-color:#005683;padding:5px;color:white">Phone:</td>     
            <td style="padding:5px;">' . $phone . '</td>		  
        </tr>
        <tr style="padding:10px">
            <td style="background-color:#005683;padding:5px;color:white">Current Employee Status:</td>     
            <td style="padding:5px;">' . $currentEmployeeStatus . '</td>		  
        </tr>
        <tr style="padding:10px">
            <td style="background-color:#005683;padding:5px;color:white">Position:</td>     
            <td style="padding:5px;">' . $position . '</td>		  
        </tr>
        <tr style="padding:10px">
            <td style="background-color:#005683;padding:5px;color:white">Current CTC:</td>     
            <td style="padding:5px;">' . $currentCTC . '</td>		  
        </tr>
        <tr style="padding:10px">
            <td style="background-color:#005683;padding:5px;color:white">Expected CTC:</td>     
            <td style="padding:5px;">' . $expectedCTC . '</td>		  
        </tr>
        <tr style="padding:10px">
            <td style="background-color:#005683;padding:5px;color:white">Experience:</td>     
            <td style="padding:5px;">' . $experience . '</td>		  
        </tr>
        <tr style="padding:10px">
            <td style="background-color:#005683;padding:5px;color:white">Relocate:</td>     
            <td style="padding:5px;">' . $relocate . '</td>		  
        </tr>
        <tr style="padding:10px">
            <td style="background-color:#005683;padding:5px;color:white">Immediate Join:</td>     
            <td style="padding:5px;">' . $immediateJoin . '</td>		  
        </tr>
    </table>';

    $message .= "<br /> This email was sent from your site " . url() . " career form. <br />";

    // Handle file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $uploadedFileName = basename($_FILES['resume']['name']);
        $fileInfo = pathinfo($uploadedFileName);
        $newFileName = $fileInfo['filename'] . "." . $fileInfo['extension'];

        // Check if file already exists and rename if necessary
        $uploadFilePath = $upload_folder . $newFileName;
        $i = 1;
        while (file_exists($uploadFilePath)) {
            $newFileName = $fileInfo['filename'] . "_" . $i . "." . $fileInfo['extension'];
            $uploadFilePath = $upload_folder . $newFileName;
            $i++;
        }

        // Move the uploaded file to the new location
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $uploadFilePath)) {
            echo "File uploaded successfully as " . $newFileName;
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "No file uploaded or an error occurred during file upload.";
    }

    // reCAPTCHA validation
    if (!empty($rqrecaptcha)) {
        try {
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Disable verbose debug output
            $mail->isSMTP(); // Send using SMTP
            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   = 'noreply.fivetwo@gmail.com'; // SMTP username
            $mail->Password   = 'qyznnzlseruanhld'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable implicit TLS encryption
            $mail->Port       = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('noreply.fivetwo@gmail.com', 'OJS WIN Logistics');
            $mail->addAddress('hr@ojs-winfreight.com', 'HR OJS WIN'); 
           
            // Attachments
            if (!empty($uploadFilePath)) {
                $mail->addAttachment($uploadFilePath);
            }

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message); // Plain-text body for non-HTML mail clients

            $mail->send();
            echo 'OK';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "reCAPTCHA validation failed.";
    }
}

?>
