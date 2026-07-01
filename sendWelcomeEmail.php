<?php

if (!isset($student_email) || !isset($student_name)) {
    return;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    // EMAIL SISTEM
    $mail->Username = 'utemeventify@gmail.com';

    // APP PASSWORD
    $mail->Password = 'dcmxubommmkxdseu';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom(
        'utemeventify@gmail.com',
        'UTeM Eventify'
    );

    // EMAIL STUDENT
    $mail->addAddress($student_email);

    $mail->isHTML(true);

    $mail->Subject = "Welcome to UTeM Eventify";

    $mail->Body = "
    <h2>Welcome, $student_name!</h2>

    <p>Your account has been created successfully.</p>

    <p>You may now log in to <b>UTeM Eventify</b> and start registering for events.</p>

    <hr>

    <p><b>Email :</b> $student_email</p>

    <p>Thank you for joining UTeM Eventify.</p>
    ";

    $mail->send();

} catch (Exception $e) {

    // Jika gagal hantar email, sistem tetap teruskan
}