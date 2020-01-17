<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/configs.php';

setcookie("token", null, time() - (60 * COOKIE_EXPIRE_TIME));
header("Location: /");
