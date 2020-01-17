<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs.php';

// $token = URL_ANJ_SERVICES . '/employee/check-token?token=' . $_COOKIE["token"];
//
// $ch = curl_init($token);
//
// // Bypass SSL
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// // Thiết lập có return
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
// $result = curl_exec($ch);
//
// curl_close($ch);
// $res = json_decode($result, 1);
if (!isset($_COOKIE["token"])) {
  require_once 'checkLogin.php';
  // header("Location: /pages/login.php");
}
