<?php

include_once('Database.php');
include_once('E_PhongBan.php');
include_once('E_NhanVien.php');

class M_PhongBan
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getTenPB($idpb)
  {
    $sql = "SELECT TenPB FROM phongban WHERE IDPB = ?";
    $stmt = $this->db->getDb()->prepare($sql);
    $stmt->bind_param("i", $idpb);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
      return $row['TenPB'];
    } else {
      return null;
    }
  }

  // Lấy tất cả phòng ban
  public function getAll()
  {
    $sql = "SELECT * FROM phongban";
    $arr = [];
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
        $arr[] = new E_PhongBan($row['IDPB'], $row['TenPB'], $row['Mota']);
      }
      $stmt->close();
    }
    return $arr;
  }

  // Lấy thông tin một phòng ban dựa trên ID
  public function get($id)
  {
    $sql = "SELECT * FROM phongban WHERE IDPB = ?";
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("s", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stmt->close();

      if ($row) {
        return new E_PhongBan($row['IDPB'], $row['TenPB'], $row['Mota']);
      }
    }
    return null;
  }

  // Thêm một phòng ban mới
  public function add(E_PhongBan $pb)
  {
    $id = $pb->getIDPB();
    $tenPb = $pb->getTenPB();
    $mota = $pb->getMoTa();
    $sql = "INSERT INTO phongban (IDPB, TenPB, MoTa) VALUES (?, ?, ?)";
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("sss", $id, $tenPb, $mota);
      $result = $stmt->execute();
      $stmt->close();
      return $result;
    }
    return false;
  }

  // Cập nhật thông tin phòng ban
  public function update(E_PhongBan $pb)
  {
    $sql = "UPDATE phongban SET TenPB = ?, MoTa = ? WHERE IDPB = ?";
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("sss", $pb->getTenPB(), $pb->getMoTa(), $pb->getIDPB());
      $result = $stmt->execute();
      $stmt->close();
      return $result;
    }
    return false;
  }

  // Xóa một phòng ban
  public function delete($id)
  {
    $sql = "DELETE FROM phongban WHERE IDPB = ?";
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("s", $id);
      $result = $stmt->execute();
      $stmt->close();
      return $result;
    }
    return false;
  }

  // Tìm kiếm phòng ban dựa trên từ khóa
  public function search($textSearch, $key)
  {
    $sql = "SELECT * FROM phongban WHERE $key LIKE CONCAT('%', ?, '%')";
    $arr = [];
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("s", $textSearch);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
        $arr[] = new E_PhongBan($row['IDPB'], $row['TenPB'], $row['MoTa']);
      }
      $stmt->close();
    }
    return $arr;
  }

  // Lấy danh sách nhân viên của một phòng ban
  public function getNhanVien($id)
  {
    $sql = "SELECT * FROM nhanvien WHERE IDPB = ?";
    $arr = [];
    if ($stmt = $this->db->getDb()->prepare($sql)) {
      $stmt->bind_param("s", $id);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
        $arr[] = new E_NhanVien($row['IDNV'], $row['Hoten'], $row['IDPB'], $row['Diachi'], null);
      }
      $stmt->close();
    }
    return $arr;
  }
}
