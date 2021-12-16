<?php

use app\helpers\DotEnv;
use app\helpers\Mailer;
use app\Database;

require_once __DIR__ . '/vendor/autoload.php';

(new DotEnv(__DIR__ . '/.env'))->load();
new Database();

function get_random_xkcd_comic()
{
    $ch = curl_init();

    $random_comic_id = random_int(1, 2554);
    $url = "https://xkcd.com/$random_comic_id/info.0.json";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $resp = curl_exec($ch);
    if ($e = curl_error($ch)) echo $e;
    else {
        $jresp = json_decode($resp, true);
    }

    curl_close($ch);
    return [$jresp["safe_title"], $jresp["img"]];
}


function send_comic()
{
    $db = Database::$db;
    $users = $db->getAllVerifiedUsers();
    [$title, $img_url] = get_random_xkcd_comic();
    $app_url = getenv("APP_URL");

    foreach ($users as $user) {
        $email = $user["email"];
        $otp = $user["verification_code"];
        $subject = "XKCD Emailer -- $title";
        $body_content = "<h3>$title</h3></br></br><img src='$img_url' /></br></br><a href='$app_url/unsubscribe?id=$email&code=$otp'>unsubscribe</a>";

        $mailer = new Mailer();
        $mailer->compose($subject, $body_content);
        $mailer->add_url_attachment($img_url);
        $mailer->send($email);
    }
}


send_comic();
