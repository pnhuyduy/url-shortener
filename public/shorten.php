<?php
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/functions/checkToken.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/models/UrlShortener.php';


$UrlShortener = new UrlShortener;

if (isset($_POST['url'])) {
    $longUrl = $_POST['url'];
    // Tạo short code
    $shortCode = $UrlShortener->createShortCode($longUrl, CREATE_NEW_LINK_IF_EXISTS, $_COOKIE["userId"], $_COOKIE["fullname"]);

    $_SESSION['shortUrl'] = "<a href=". BASE_URL . '/' . $shortCode .">". BASE_URL . '/' . $shortCode . "</a>";

}

header('Location: /');
