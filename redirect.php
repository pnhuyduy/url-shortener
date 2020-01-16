<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Cache.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/UrlDatabase.php';

$cache = new Cache;
$db = new UrlDatabase;

if (isset($_GET['shortUrl'])) {
    $shortUrl = strtolower($_GET['shortUrl']);
    $url = $cache->getData($shortUrl);
    $longUrl = $url["longUrl"];
    if ($url) {
      if (!$url["status"]) {
        echo "Debug at".__FILE__." ".__LINE__." ".__FUNCTION__; echo "<pre>"; print_r('status 0'); echo "</pre>"; die;
      } else {
        $longUrl = $url["longUrl"];
        header("Location: {$longUrl}", true, 301);
        exit();
      }
    } else {
        $exists = $db->checkIfShortCodeExists($shortUrl);
        if ($exists) {
          $cache->addData($shortUrl, [
            "longUrl" => $exists["long_url"],
            "status" => $exists["status"],
          ], 5);
          $longUrl = $exists["long_url"];
          header("Location: {$longUrl}", true, 301);
          exit();
        }

    }

}

header("Location: index.php");
