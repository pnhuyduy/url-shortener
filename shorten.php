<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/UrlShortener.php';


$UrlShortener = new UrlShortener;

if (isset($_POST['url'])) {
    $longUrl = $_POST['url'];
    // Tạo short code
    $shortCode = $UrlShortener->createShortCode($longUrl, CREATE_NEW_LINK_IF_EXISTS);

    $_SESSION['shortUrl'] = "<a href=". BASE_URL . $shortCode .">". BASE_URL . $shortCode . "</a>";

}

header('Location: /');
