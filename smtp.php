<?php

require_once 'env.php';

foreach ($smtpConnections as $connection) {
    $smtpEmail = $connection['email'];
    $smtpHost = $connection['host'];
    $smtpPort = $connection['port'];
    $smtpUsername = $connection['username'];
    $smtpPassword = $connection['password'];

    ini_set('SMTP', $smtpHost);
    ini_set('smtp_port', $smtpPort);
    ini_set('sendmail_from', $smtpUsername);

    $isSent = mail(
        $testEmailTo,
        $testEmailSubject,
        $testEmailBody,
        "From: $smtpEmail\r\n"
    );

    if ($isSent) {
        echo "✅ $smtpEmail ($smtpHost) sent succcessfully.\n";
    } else {
        echo "❌ $smtpEmail ($smtpHost) failed.\n";
    }
}
