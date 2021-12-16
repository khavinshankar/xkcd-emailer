<?php

namespace app\helpers;

class Mailer
{
    private $from_email = null;
    private $from_name = null;
    private $semi_rand = null;
    private $mime_boundary = null;
    private $headers = null;
    private $message = null;
    private $subject = null;

    public function __construct($from_email = null, $from_name = null)
    {
        $this->from_email = $from_email ?? getenv("MAIL_USER_EMAIL") ?? "bot@xkcd-emailer.com";
        $this->from_name = $from_name ?? getenv("MAIL_USER_NAME") ?? "Service Bot";
        $this->semi_rand = md5(time());
        $this->mime_boundary = "==Multipart_Boundary_x{$this->semi_rand}x";
    }

    public function compose($subject, $content)
    {
        $this->subject = $subject;

        $this->headers = "From: $this->from_name" . " <" . $this->from_email . ">";
        $this->headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$this->mime_boundary}\"";
        $this->message = "--{$this->mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $content . "\n\n";
    }

    public function add_url_attachment($url)
    {
        if ($url) {
            $this->message .= "--{$this->mime_boundary}\n";

            $file_data = base64_encode(file_get_contents($url));
            $file_name = substr(strrchr($url, '/'), 1);

            $this->message .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"\n" .
                "Content-Description: " . $file_name . "\n" .
                "Content-Disposition: attachment;\n" . " filename=\"" . $file_name . "\"; size=" . strlen($file_data) . ";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $file_data . "\n\n";
        }
    }

    public function send($to)
    {
        $this->message .= "--{$this->mime_boundary}--";
        $return_path = "-f" . $this->from_email;

        return @mail($to, $this->subject, $this->message, $this->headers, $return_path);
    }
}