<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Cache.php';

$cache = new Cache;

if (isset($_GET["shortCode"])) {
    $urlData = $cache->getData($_GET["shortCode"]);
    echo "Debug at".__FILE__." ".__LINE__." ".__FUNCTION__; echo "<pre>"; print_r($urlData); echo "</pre>"; die;
}
