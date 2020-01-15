<?php
    require_once 'configs.php';
    require_once 'ShortCode.php';
    require_once 'UrlDatabase.php';
    require_once 'Cache.php';
/**
 *
 */
class UrlShortener {
    private static $table = 'short_urls';
    private $db;

    function __construct() {
        $this->db = new UrlDatabase;
    }

    public function createShortCode($url, $duplicateURL = false) {
        // if (empty($url)) {
        //     throw new Exception("URL truyền vào trỗng");
        // }
        // if (!$this->validateUrl($url)) {
        //     throw new Exception("URL không hợp lệ");
        // }

        $cache = new Cache;
        $shortCode = ShortCode::generateRandomString();

        while ($cache->checkIfKeyExists($shortCode)) {
          $shortCode = ShortCode::generateRandomString();
        };
        if ($duplicateURL) {
            $this->db->insertToDB($url, $shortCode);
            $cache->addData($shortCode, [
                "longUrl" => $url,
                "status" => 1
              ], 0);
            return $shortCode;

        } else {
            if ($this->db->urlExistsInDB($url)) {
                $shortCode = $this->db->getShortCode($url);
                $cache->addData($shortCode, [
                    "longUrl" => $url,
                    "status" => 1
                  ], 0);
                return $shortCode;
            } else {
                $this->db->insertToDB($url, $shortCode);
                $cache->addData($shortCode, [
                    "longUrl" => $url,
                    "status" => 1
                  ], 0);
                return $shortCode;
            }
        }
    }

    // Validate url
    protected function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
    }
}
