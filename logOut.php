<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs.php';

setcookie("token", null, time() - (60 * COOKIE_EXPIRE_TIME));
header("Location: /");
