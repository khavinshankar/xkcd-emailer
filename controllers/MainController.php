<?php

namespace app\controllers;

use app\helpers\Mailer;
use app\models\User;


class MainController
{

    public static function subscribe($router)
    {
        $data = ["is_valid_email" => true];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST["email"];
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                new User($email);

                header("Location: /send-otp?id=$email");
                exit;
            }

            $data["is_valid_email"] = false;
        }

        $router->render("subscribe", $data);
    }

    public static function unsubscribe($router)
    {
        $email = $_GET["id"];
        $otp = $_GET["code"];

        $user = new User($email);
        $user->verify_delete($otp);

        header("Location: /");
        exit;
    }

    public static function send_otp()
    {
        $email = $_GET["id"];

        $user = new User($email);
        $otp = $user->reset_verification_code();

        if (!$otp) { // already verified user
            header("Location: /success");
            exit;
        }

        $subject = "(no reply) XKCD Emailer - Verify your Email";
        $body_content = "Here is your OTP for email verification<br><h1>$otp</h1></br>Thank you!";

        $mailer = new Mailer();
        $mailer->compose($subject, $body_content);
        $mailer->send($email);

        header("Location: /otp?id=$email");
        exit;
    }

    public static function verify_otp($router)
    {
        $data = ["email" => $_GET["id"], "wrong_otp" => false];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST["email"];
            $user_code = $_POST["first"] . $_POST["second"] . $_POST["third"] . $_POST["fourth"] . $_POST["fifth"] . $_POST["sixth"];

            $user = new User($email);
            if ($user->verify($user_code)) {
                header("Location: /success");
                exit;
            } else {
                $data["wrong_otp"] = true;
            }
        }

        $router->render("verify_otp", $data);
    }

    public static function all_done($router)
    {
        $router->render("all_done");
    }
}
