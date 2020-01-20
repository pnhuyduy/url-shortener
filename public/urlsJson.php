<?php
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/models/UrlDatabase.php';

$db = new UrlDatabase;
$data = $db->getShortUrlsJson();
header('Content-Type: application/json');
print_r($data);
