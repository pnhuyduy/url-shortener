<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Cache.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/UrlDatabase.php';

$cache = new Cache;
$db = new UrlDatabase;

if (isset($_GET['shortUrl'])) {
    $shortUrl = strtolower($_GET['shortUrl']);
    $url = $cache->getData($shortUrl);
    if ($url) {
      if (!$url["status"]) {
        echo "Debug at".__FILE__." ".__LINE__." ".__FUNCTION__; echo "<pre>"; print_r('status 0'); echo "</pre>"; die;
      } else {
        $longUrl = $url["longUrl"];
        $cache->pushClickedCounter($shortUrl);

        header("Location: {$longUrl}", true, 301);
        exit();
      }
    } else {
        $existsUrl = $db->checkIfShortCodeExists($shortUrl);
        if ($existsUrl) {
          if ($existsUrl["status"]) {
              $cache->addData($shortUrl, [
                "longUrl" => $existsUrl["long_url"],
                "status" => $existsUrl["status"],
                "clickedCounter" => $existsUrl["clicked_counter"],
              ], 0);
              $longUrl = $existsUrl["long_url"];
              $cache->pushClickedCounter($shortUrl);
              header("Location: {$longUrl}", true, 301);
              exit();
          } else {
            echo "Debug at".__FILE__." ".__LINE__." ".__FUNCTION__; echo "<pre>"; print_r('Link đã vô hiệu hoá'); echo "</pre>"; die;
          }

        } else {
          echo "Debug at".__FILE__." ".__LINE__." ".__FUNCTION__; echo "<pre>"; print_r('Không tìm thấy link'); echo "</pre>"; die;
        }

    }

}

header("Location: index.php");
