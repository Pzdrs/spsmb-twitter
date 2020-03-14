<?php

class Database {

  private static $instance;

  private $connection;

  private $hostname = "localhost";

  private $username = "root";

  private $password = "root";

  private function __construct() {
    try {
      $this->connection
        = new PDO('mysql:host=' . $this->hostname . ';dbname=spsmbTwitter',
        $this->username, $this->password);
    } catch
    (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  public static function getInstance() {
    if (self::$instance == NULL) {
      self::$instance = new Database();
    }
    return self::$instance;
  }

  public function getConnection() {
    return $this->connection;
  }

}
