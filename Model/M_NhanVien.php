<?php

include_once('E_NhanVien.php');
include_once('Database.php');

class M_NhanVien
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getAll()
  {
    $sql = "SELECT * FROM nhanvien";
    $arr = [];
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
        $arr[] = new E_NhanVien($row['IDNV'], $row['Hoten'], $row['IDPB'], $row['Diachi']);
      }
      $stmt->close();
    }
    return $arr;
  }

  public function get($IDNV)
  {

    $sql = "SELECT * FROM nhanvien WHERE IDNV = ?";
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("s", $IDNV);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stmt->close();

      if ($row) {
        return new E_NhanVien($row['IDNV'], $row['Hoten'], $row['IDPB'], $row['Diachi']);
      }
    }
    return null;
  }

  public function add(E_NhanVien $nv)
  {
    $id = $nv->getIDNV();
    $hoten = $nv->getHoten();
    $idpb = $nv->getIDPB();
    $diachi = $nv->getDiachi();

    $sql = "INSERT INTO nhanvien (IDNV, Hoten, IDPB, Diachi) VALUES (?, ?, ?, ?)";
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("ssss", $id, $hoten, $idpb, $diachi);
      $result = $stmt->execute();
      $stmt->close();
      return $result;
    }
    return false;
  }

  public function update(E_NhanVien $nv)
  {
    $id = $nv->getIDNV();
    $hoten = $nv->getHoten();
    $idpb = $nv->getIDPB();
    $diachi = $nv->getDiachi();

    $sql = "UPDATE nhanvien SET Hoten = ?, IDPB = ?, Diachi = ? WHERE IDNV = ?";

    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("ssss", $hoten, $idpb, $diachi, $id);
      $result = $stmt->execute();
      $stmt->close();
      return $result;
    }
    return false;
  }

  public function delete($IDNV)
  {
    $sql = "DELETE FROM nhanvien WHERE IDNV = ?";
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("s", $IDNV);
      $result = $stmt->execute();
      $stmt->close();
      return $result;
    }
    return false;
  }

  public function search($searchText, $key)
  {
    $sql = "SELECT * FROM nhanvien WHERE $key LIKE CONCAT('%', ?, '%')";
    $arr = [];
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("s", $searchText);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
        $arr[] = new E_NhanVien($row['IDNV'], $row['Hoten'], $row['IDPB'], $row['Diachi']);
      }
      $stmt->close();
    }
    return $arr;
  }
}
