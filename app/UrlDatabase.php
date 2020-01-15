<?php
    require_once 'configs.php';

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

    // Get short code từ url
    public  function getShortCode($url) {
        $stmt = $this->db->prepare("SELECT * FROM ". self::$table ." WHERE long_url = ? LIMIT 1");
        $stmt->bind_param("s", $url);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (empty($result)) ? false : $result["short_code"];
    }

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
