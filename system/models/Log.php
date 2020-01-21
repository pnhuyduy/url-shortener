<?php
    require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/functions/configs.php';
/**
 *
 */
class Log {

    private $logDir;
    public function __construct()
    {
      $this->logDir = dirname($_SERVER['DOCUMENT_ROOT']) . "/log/";
      if (!file_exists($this->logDir)) {
        mkdir($this->logDir, 0777);
      }
    }

    public function collectClickData($shortCode, $server) {
         $clickData = [
          "shortCode" => $shortCode,
          "HTTP_HOST" => $server["HTTP_HOST"],
          "HTTP_CONNECTION" => $server["HTTP_CONNECTION"],
          "HTTP_CACHE_CONTROL" => $server["HTTP_CACHE_CONTROL"],
          "HTTP_UPGRADE_INSECURE_REQUESTS" => $server["HTTP_UPGRADE_INSECURE_REQUESTS"],
          "HTTP_USER_AGENT" => $server["HTTP_USER_AGENT"],
          "HTTP_ACCEPT" => $server["HTTP_ACCEPT"],
          "HTTP_REFERER" => $server["HTTP_REFERER"],
          "HTTP_ACCEPT_ENCODING" => $server["HTTP_ACCEPT_ENCODING"],
          "HTTP_ACCEPT_LANGUAGE" => $server["HTTP_ACCEPT_LANGUAGE"],
          "HTTP_COOKIE" => $server["HTTP_COOKIE"],
          "HTTP_X_FORWARDED_FOR" => $server["HTTP_X_FORWARDED_FOR"],
          "REMOTE_ADDR" => $server["REMOTE_ADDR"],
        ];

        return $clickData;
    }

    public function writeFileLog($shortCode, $server) {
        $logData = $this->collectClickData($shortCode, $server);

        $dir = $this->logDir . $shortCode;
        if (!file_exists($dir)) {
          mkdir($dir, 0777);
        }
        $fileName = $logData["shortCode"] . '_' . time() . '.log';

        file_put_contents($dir . "/" . $fileName, json_encode($logData, JSON_PRETTY_PRINT));
    }

}
