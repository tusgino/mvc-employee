<?php

class Database
{
  private $db;

  public function __construct()
  {
    $this->db = new mysqli('localhost', 'root', '', 'qlnv');
    $this->db->set_charset('utf8');
    if ($this->db->connect_errno) {
      die('Lỗi kết nối database');
    }
  }

  public function __destruct()
  {
    $this->db->close();
  }

  public function getDb()
  {
    return $this->db;
  }
}
