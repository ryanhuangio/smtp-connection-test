<?php

require 'env.php';

if ($debug==true) {
    ini_set('error_reporting', E_ALL);
}


require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();
$mail->isSMTP();

$i = 0;
foreach ($smtpConnections as $connection) {

    $smtpEmail = $connection['email'];
    $smtpHost = $connection['host'];
    $smtpPort = $connection['port'];
    $smtpUsername = $connection['username'];
    $smtpPassword = $connection['password'];

    $mail->Host = $smtpHost;
    $mail->Port = $smtpPort;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->setFrom($smtpEmail);
    $mail->addAddress($testEmailTo);
    $mail->Subject = $testEmailSubject;
    $mail->Body = $testEmailBody;
    $mail->CharSet = 'UTF-8';

    try {
        $i++;
        if($mail->send()) {
            echo "✅ Email sent from $smtpEmail successfully!\n";
        } else {
            throw new \Exception();
        }
    } catch (\Exception $e) {
        echo "❌ Email failed to send from $smtpEmail.\n";
        if ($debug==true) {
            throw new \Exception("Mailer error: \n" . $e->getMessage() . "\n\n");
        }
    }

    $mail->clearAddresses();

}
