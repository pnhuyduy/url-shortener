<?php
    require_once 'ShortCode.php';
    require_once 'UrlDatabase.php';
    require_once 'Cache.php';
/**
 *
 */
class UrlShortener {
    private $db;

    function __construct() {
        $this->db = new UrlDatabase;
    }

    public function createShortCode($url, $duplicateURL = 0) {
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

        if ($duplicateURL) { // option cho phép một url đích có nhiều short code
            $this->db->insertToDB($url, $shortCode);
            return $shortCode;

        } else {
            if ($this->db->urlExistsInDB($url)) { // trả về short code nếu url đích đã tồn tại
                $shortCode = $this->db->getShortCodeByUrl($url);
                return $shortCode;
            } else { // tạo mới nếu chưa tồn tại
                $this->db->insertToDB($url, $shortCode);
                return $shortCode;
            }
        }
    }

    // Validate url
    protected function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
    }
}
