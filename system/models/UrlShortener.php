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

    public function createShortCode($url, $duplicateURL = 0, $userId = null, $fullname) {
        // if (empty($url)) {
        //     throw new Exception("URL truyền vào trỗng");
        // }
        // if (!$this->validateUrl($url)) {
        //     throw new Exception("URL không hợp lệ");
        // }

        $cache = new Cache;
        
        do {
            $shortCode = ShortCode::generateRandomString();
        } while ($cache->checkIfKeyExists($shortCode));

        if ($duplicateURL) { // option cho phép một url đích có nhiều short code
            $this->db->insertToDB($url, $shortCode, $userId, $fullname);
            return $shortCode;

        } else {
            if ($this->db->urlExistsInDB($url)) { // trả về short code nếu url đích đã tồn tại
                $shortCode = $this->db->getShortCodeByUrl($url);
                return $shortCode;
            } else { // tạo mới nếu chưa tồn tại
                $this->db->insertToDB($url, $shortCode, $userId, $fullname);
                return $shortCode;
            }
        }
    }

    public function validateUpdateInput($id, $input)
    {
        $errors = [];
        $exists = $this->db->getUrlData($id);

        if ($exists["long_url"] !== $input["long_url"]) {
            if ($this->db->urlExistsInDB($input["long_url"])) {
                $errors["long_url"] = "Url đích đã tồn tại: " . $input["long_url"];
            }
        }
        if ($exists["short_code"] !== $input["short_code"]) {
            if ($this->db->checkIfShortCodeExists($input["short_code"])) {
                $errors["short_code"] = "Short code đã tồn tại: " . $input["short_code"];
            }
        }

        return $errors;
    }

    // Validate url
    protected function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
    }
}
