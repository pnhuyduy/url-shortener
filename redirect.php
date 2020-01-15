<?php
require_once "app/Cache.php";

$memcache = new Cache;

if (isset($_GET['shortUrl'])) {
    $shortUrl = strtolower($_GET['shortUrl']);
    $url = $memcache->getData($shortUrl);
    $longUrl = $url["longUrl"];

    if (!$url["status"]) {
      echo "Debug at".__FILE__." ".__LINE__." ".__FUNCTION__; echo "<pre>"; print_r('status 0'); echo "</pre>"; die;
    } else {
      header("Location: {$longUrl}", true, 301);
      die;
    }
}

header("Location: index.php");
