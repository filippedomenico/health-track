<?php
use PHPMailer\PHPMailer\PHPMailer;
require './PHPMailer-master/vendor/autoload.php';
$fromEmail = $_POST['email'];
$fromName = $_POST['name'];
$sendToEmail = 'name@mydomain.com';
$sendToName = 'Name';
$subject = 'New message from contact form';
$fields = array('name' => 'Name:', 'email' => 'Email:', 'message' => 'Message:');
$okMessage = 'Successfully submitted - we will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';
error_reporting(E_ALL & ~E_NOTICE);

try
{
    
    if(count($_POST) == 0) throw new \Exception('Form is empty');
    $emailTextHtml .= "<h3>New message from the w3newbie Theme:</h3><hr>";
    $emailTextHtml .= "<table>";

    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailTextHtml .= "<tr><th>$fields[$key]</th><td>$value</td></tr>";
        }
    }
    $emailTextHtml .= "</table><hr>";
    $emailTextHtml .= "<p>Have a great day!<br><br>Sincerely,<br><br>w3newbie Theme</p>";
    
    $mail = new PHPMailer;

    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($sendToEmail, $sendToName);
    $mail->addReplyTo($_POST['email'], $_POST['name']);
    


    $mail->Subject = $subject;

    $mail->Body = $emailTextHtml;
    $mail->isHTML(true);
    if(!$mail->send()) {
     throw new \Exception('Email send failed. ' . $mail->ErrorInfo);
    }
    
    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    // $responseArray = array('type' => 'danger', 'message' => $errorMessage);
    $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
}


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}
?>