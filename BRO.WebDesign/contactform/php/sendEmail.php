<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'contactform';

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
$conn->query($sql);


$to = 'bro.web.c@gmail.com';

function url()
{
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']
    );
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Create an instance of PHPMailer
    $mail = new PHPMailer();

    // Set mailer to use SMTP
    $mail->isSMTP();

    // SMTP settings for Gmail
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'bro.web.c@gmail.com'; 
    $mail->Password = 'awdwquhpfrcuytlj'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Set the sender and recipient
    $mail->setFrom($email, $name);
    $mail->addAddress($to);

    // Set email subject and body
    $mail->Subject = $subject;
    $mail->Body = $message;

    if ($mail->send()) {
        echo 'OK';
    } else {
        echo 'Something went wrong. Please try again.';
    }
} else {
    echo 'Invalid request';
}
$conn->close();
?>