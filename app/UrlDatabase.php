<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/configs.php';
    require_once 'Cache.php';

class UrlDatabase {
    private static $table = 'short_urls';
    private $db;

    function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }

    // Insert link vào database
    public function insertToDB($url, $code) {
        $stmt = $this->db->prepare("INSERT INTO ". self::$table ."(long_url, short_code, created_at) VALUES (?, ?, now())");
        $stmt->bind_param("ss", $url, $code);
        $stmt->execute();
        $cache = new Cache;
        $cache->addData($code, [
            "longUrl" => $url,
            "status" => 1,
          ], 5);
        return $stmt;
    }

    // Kiểm tra nếu link đã tồn tại
    public function urlExistsInDB($url) {
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table ." WHERE long_url = ? LIMIT 1");
        $stmt->bind_param("s", $url);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (empty($result)) ? false : true;
    }

    public function updateUrlData($id, $longUrl, $shortCode, $status, $expire) {
        $stmt = $this->db->prepare("UPDATE ". self::$table ." SET long_url = ?, short_code = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssii", $longUrl, $shortCode, $status, $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $cache = new Cache;
        $cache->delData($code);
        $cache->addData($shortCode, [
            "longUrl" => $longUrl,
            "status" => $status
          ], 100);
        return $result;
    }

    // Kiểm tra nếu link đã tồn tại
    public function checkIfShortCodeExists($shortCode) {
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table ." WHERE short_code = ? LIMIT 1");
        $stmt->bind_param("s", $shortCode);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (empty($result)) ? false : $result;
    }

    // Get short code từ url
    public  function getShortCodeByUrl($url) {
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table ." WHERE long_url = ? LIMIT 1");
        $stmt->bind_param("s", $url);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (empty($result)) ? false : $result["short_code"];
    }

    // Get Url data từ id
    public function getUrlData($id) {
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table ." WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return (empty($result)) ? false : $result;
    }

    // Get tất cả url trong database
    public function getShortUrls() {
        $arr = [];
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        return (empty($arr)) ? false : $arr;
    }
}
