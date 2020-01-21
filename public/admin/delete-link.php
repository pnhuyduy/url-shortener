<?php
session_start();
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/models/Cache.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/models/UrlDatabase.php';

$cache = new Cache;
$db = new UrlDatabase;
$id = $_GET["id"];



$result = $db->deleteUrlData($id);

if ($result === 1) {
    $_SESSION['updateStatus'] = "Delete Url thành công!";
    header('Location: /admin/');
} else {
    $_SESSION['updateStatus'] = "Delete Url thất bại`!";
    header('Location: /admin/');
}
