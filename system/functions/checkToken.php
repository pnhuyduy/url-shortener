<?php
session_start();
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/functions/configs.php';

// Nếu có token, check token đã hết hạn chưa
if (isset($_COOKIE["token"])) {
    $token = URL_ANJ_SERVICES . '/employee/check-token?token=' . $_COOKIE["token"];
    $ch = curl_init($token);

    // Bypass SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    // Thiết lập có return
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    curl_close($ch);
    $res = json_decode($result, 1);

    if (!$res["status"]) {
      // require_once 'checkLogin.php';
    } else {
      // setcookie("userId", $res["data"]["id"], time() + (60 * COOKIE_EXPIRE_TIME), "/");
      // setcookie("fullname", $res["data"]["name"], time() + (60 * COOKIE_EXPIRE_TIME), "/");
    }
} else {
    // require_once 'checkLogin.php';
}
