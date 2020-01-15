<?php
session_start();
require_once "app/UrlShortener.php";

$UrlShortener = new UrlShortener;

if (isset($_POST['url'])) {
    $longUrl = $_POST['url'];
    // Tạo short code
    $shortCode = $UrlShortener->createShortCode($longUrl);

    $_SESSION['shortUrl'] = "<a href=". BASE_URL . $shortCode .">". BASE_URL . $shortCode . "</a>";

}

header('Location: '. $_SERVER['HTTP_REFERER']);
