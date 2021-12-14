<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use app\helpers\DotEnv;

require_once __DIR__ . '/../vendor/autoload.php';

(new DotEnv(__DIR__ . '/../.env'))->load();

function send_mail($to, $subject, $message, $attachments = [])
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = getenv("MAIL_HOST");
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv("MAIL_USER_ID");
        $mail->Password   = getenv("MAIL_USER_PASS");
        $mail->SMTPSecure = getenv("MAIL_SEC_STD");
        $mail->Port       = getenv("MAIL_PORT");

        $mail->setFrom(getenv("MAIL_USER_ID"), getenv("MAIL_USER_NAME"));
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $mail->addStringAttachment(file_get_contents($attachment["url"]), $attachment["name"]);
            }
        }
        $mail->send();
        echo "Mail has been sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
