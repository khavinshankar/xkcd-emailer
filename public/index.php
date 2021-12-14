<?php

require_once __DIR__ . "/../vendor/autoload.php";

use app\Router;
use app\Database;
use app\controllers\MainController;
use app\helpers\DotEnv;

(new DotEnv(__DIR__ . '/../.env'))->load();
$router = new Router();
new Database();

$router->get("/", [MainController::class, "index"]);
$router->post("/", [MainController::class, "subscribe"]);
$router->get("/send-otp", [MainController::class, "send_otp"]);
$router->get("/otp", [MainController::class, "verify_otp"]);
$router->post("/otp", [MainController::class, "verify_otp"]);
$router->get("/success", [MainController::class, "all_done"]);

$router->resolve();
