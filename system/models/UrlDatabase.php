<?php
    require_once 'Cache.php';

class UrlDatabase {
    private static $table = 'short_urls';
    private $db;

    function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }

    // Insert link vào database
    public function insertToDB($url, $code, $userId, $fullname) {
        $stmt = $this->db->prepare("INSERT INTO ". self::$table ."(long_url, short_code, user_created, username_created, created_at, updated_at) VALUES (?, ?, ?, ?, now(), now())");
        $stmt->bind_param("ssis", $url, $code, $userId, $fullname);
        $stmt->execute();
        $cache = new Cache;

        $clickedCounter = $cache->getClickedCounter($code);
        $cache->delData($code);
        $cache->addData($code, [
            "originalShortCode" => $code,
            "longUrl" => $url,
            "status" => 1,
            "clickedCounter" => $clickedCounter,
          ], 0);

        return $stmt;
    }

    // Kiểm tra nếu link đã tồn tại
    public function urlExistsInDB($url) {
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table ." WHERE long_url = ? AND status BETWEEN 1 AND 2 LIMIT 1");
        $stmt->bind_param("s", $url);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (empty($result)) ? false : true;
    }

    public function updateUrlData($id, $longUrl, $shortCode, $oldShortCode, $status, $expire, $userId, $fullname) {
        $stmt = $this->db->prepare("UPDATE ". self::$table ." SET long_url = ?, short_code = ?, status = ?, user_created = ?, username_created = ?, updated_at = now() WHERE id = ?");
        $stmt->bind_param("ssiisi", $longUrl, $shortCode, $status, $userId, $fullname, $id);
        $stmt->execute();
        $result = $stmt->affected_rows;

        $cache = new Cache;
        $clickedCounter = $cache->getClickedCounter($oldShortCode);
        $originalShortCode = $cache->getOriginalShortCode($oldShortCode);

        $cache->delData($oldShortCode);
        $cache->addData($shortCode, [
            "originalShortCode" => $originalShortCode,
            "longUrl" => $longUrl,
            "status" => $status,
            "clickedCounter" => $clickedCounter
          ], 0);
        return $result;
    }

    public function deleteUrlData($id)
    {   $urlData = $this->getUrlData($id);
        $cache = new Cache;
        $cache->delData($urlData["short_code"]);
        $status = 3;
        $stmt = $this->db->prepare("UPDATE ". self::$table ." SET status = $status, updated_at = now() WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->affected_rows;

        return $result;
    }

    // Kiểm tra nếu link đã tồn tại
    public function checkIfShortCodeExists($shortCode) {
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table ." WHERE short_code = ? AND status BETWEEN 1 AND 2 LIMIT 1");
        $stmt->bind_param("s", $shortCode);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return (empty($result)) ? false : $result;
    }

    // Get short code từ url
    public  function getShortCodeByUrl($url) {
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table ." WHERE long_url = ? AND status BETWEEN 1 AND 2 LIMIT 1");
        $stmt->bind_param("s", $url);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        return (empty($result)) ? false : $result["short_code"];
    }

    // Get Url data từ id
    public function getUrlData($id) {
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table ." WHERE id = ? AND status BETWEEN 1 AND 2 LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return (empty($result)) ? false : $result;
    }

    // Get tất cả url trong database
    public function getShortUrls() {
        $arr = [];
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table . " WHERE status BETWEEN 1 AND 2");
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        return (empty($arr)) ? false : $arr;
    }

    public function getShortUrlsJson()
    {
        $urls = [];
        $urls["data"] = $this->getShortUrls();

        return json_encode($urls, JSON_PRETTY_PRINT);
    }
}
