<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/configs.php';

/**
 *
 */
class Cache {
    private $connection = null;
    public $enabled = false;

    function __construct() {
        if (class_exists("Memcache")) {
            $this->connection = new Memcache();
            $this->enabled = true;
            if (!$this->connection->connect(MEMCACHED_HOST, MEMCACHED_PORT)) {
                $this->connection = null;
                $this->enabled = false;
            }
        }

    }
    public function checkIfKeyExists($key)
    {
      return (empty($this->getData($key))) ? false : true;
    }
    // Lấy dữ liệu cache bằng key
    public function getData($key) {
        return $this->connection->get($key);
    }

    // Set/Update dữ liệu cache
    public function setData($key, $value, $expire) {
        return $this->connection->set($key, $value, false, $expire);
    }

    /*  Thêm cache
    *   return false nếu key đã tồn tại
    */
    public function addData($key, $value, $expire) {
        return $this->connection->add($key, $value, false, $expire);
    }

    // Xoá cache theo key
    public function delData($key) {
        return $this->connection->delete($key);
    }

    // Xoá toàn bộ cache
    public function flushData() {
        return $this->connection->flush();
    }

    // Get số lần click của key
    public function getClickedCounter($key) {
        $urlData = $this->getData($key);
        return $urlData["clickedCounter"];
    }

    // Thêm số lần click khi click vào link
    public function pushClickedCounter($key)
    {
        $data = $this->getData($key);
        $data["clickedCounter"]++;
        $this->setData($key, $data, 0);
    }
}
