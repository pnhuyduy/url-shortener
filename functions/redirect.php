<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Cache.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/UrlDatabase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Log.php';

$cache = new Cache;
$db = new UrlDatabase;
$log = new Log;

if (isset($_GET['shortUrl'])) {
    $shortCode = strtolower($_GET['shortUrl']);
    $urlData = $cache->getData($shortCode);

    if ($urlData) {
      if (!$urlData["status"]) {
        echo "Debug at".__FILE__." ".__LINE__." ".__FUNCTION__; echo "<pre>"; print_r('Link đã vô hiệu hoá'); echo "</pre>"; die;
      } else {
        $longUrl = $urlData["longUrl"];
        $log->writeFileLog($shortCode, $_SERVER);
        $cache->pushClickedCounter($shortCode);

        header("Location: {$longUrl}", true, 301);
        exit();
      }
    } else {
        $existsUrl = $db->checkIfShortCodeExists($shortCode);
        if ($existsUrl) {
          if ($existsUrl["status"]) {
              $cache->addData($shortCode, [
                "longUrl" => $existsUrl["long_url"],
                "status" => $existsUrl["status"],
                "clickedCounter" => $existsUrl["clicked_counter"],
              ], 0);
              $longUrl = $existsUrl["long_url"];
              $log->writeFileLog($shortCode, $_SERVER);
              $cache->pushClickedCounter($shortCode);
              
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
