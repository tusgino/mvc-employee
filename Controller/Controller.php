<?php

include_once('../Model/M_NhanVien.php');
include_once('../Model/M_PhongBan.php');

class C_NhanVien
{
  private $modelNV;
  private $modelPB;

  public function __construct()
  {
    $this->modelNV = new M_NhanVien();
    $this->modelPB = new M_PhongBan();
  }

  public function nhanVienList()
  {
    $nhanVienList = null;
    if (isset($_GET['searchText'])) {
      $searchText = $_GET['searchText'];
      $searchKey = $_GET['searchKey'];
      $nhanVienList = $this->modelNV->search($searchText, $searchKey);
    } else {
      $nhanVienList = $this->modelNV->getAll();
    }
    include_once('../View/NhanVienList.html');
  }

  public function phongBanList()
  {
    $phongBanList = $this->modelPB->getAll();
    include_once('../View/PhongBanList.html');
  }

  public function checkIDExist($id)
  {
    $nhanVien = $this->modelNV->get($id);
    if ($nhanVien == null) {
      return false;
    } else {
      return true;
    }
  }

  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['idnv'];
      if ($this->checkIDExist($id)) {
        echo "Mã nhân viên đã tồn tại";
        return;
      }
      $hoten = $_POST['hoten'];
      $idpb = $_POST['idpb'];
      $diachi = $_POST['diachi'];

      $nhanVien = new E_NhanVien($id, $hoten, $idpb, $diachi);
      try {
        $result = $this->modelNV->add($nhanVien);
        if ($result) {
          header('Location: Controller.php?action=nhanVienList');
        } else {
          echo "Thêm nhân viên thất bại";
        }
      } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {

          echo "Đã trùng ID";
        } else {
          echo "Database error: " . $e->getMessage();
        }
      }
    } else {
      $phongBans = $this->modelPB->getAll();
      include_once('../View/FormNhanVien.html');
    }
  }

  public function checkIDPBExist($idpb)
  {
    $phongBan = $this->modelPB->get($idpb);
    if ($phongBan == null) {
      return false;
    } else {
      return true;
    }
  }

  public function addPhongBan()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $idpb = $_POST['idpb'];
      if ($this->checkIDPBExist($idpb)) {
        echo "Mã phòng ban đã tồn tại";
        return;
      }
      $tenpb = $_POST['tenpb'];
      $mota = $_POST['mota'];

      $phongBan = new E_PhongBan($idpb, $tenpb, $mota);

      $result = $this->modelPB->add($phongBan);
      if ($result) {
        header('Location: Controller.php?action=phongBanList');
      } else {
        echo "Thêm phòng ban thất bại";
      }
    } else {
      include_once('../View/FormPhongBan.html');
    }
  }

  public function update()
  {
    $id = $_GET['id'];

    if (!$this->checkIDExist($id)) {
      echo "Mã nhân viên không tồn tại";
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $hoten = $_POST['hoten'];
      $idpb = $_POST['idpb'];
      $diachi = $_POST['diachi'];

      $nhanVien = new E_NhanVien($id, $hoten, $idpb, $diachi);

      $result = $this->modelNV->update($nhanVien);
      if ($result) {
        header('Location: Controller.php?action=nhanVienList');
      } else {
        echo "Cập nhật nhân viên thất bại";
      }
    } else {
      $phongBans = $this->modelPB->getAll();
      $nhanVien = $this->modelNV->get($id);
      include_once('../View/FormNhanVien.html');
    }
  }

  public function detail()
  {
    $id = $_GET['id'];

    if (!$this->checkIDExist($id)) {
      echo "Mã nhân viên không tồn tại";
      return;
    }

    $nhanVien = $this->modelNV->get($id);
    include_once('../View/NhanVienDetail.html');
  }

  public function delete()
  {
    $id = $_GET['id'];

    if (!$this->checkIDExist($id)) {
      echo "Mã nhân viên không tồn tại";
      return;
    }

    $result = $this->modelNV->delete($id);
    if ($result) {
      header('Location: Controller.php?action=nhanVienList');
    } else {
      echo "Xóa nhân viên thất bại";
    }
  }

  public function detailPhongBan()
  {
    $idpb = $_GET['id'];

    if (!$this->checkIDPBExist($idpb)) {
      echo "Mã phòng ban không tồn tại";
      return;
    }

    $phongBan = $this->modelPB->get($idpb);
    $nhanVienList = null;
    if (isset($_GET['searchText'])) {
      $searchText = $_GET['searchText'];
      $searchKey = $_GET['searchKey'];
      $nhanVienList = $this->modelNV->search($searchText, $searchKey);
    } else {
      $nhanVienList = $this->modelNV->getAll();
    }
    include_once('../View/PhongBanDetail.html');
  }


  public function check()
  {
    $action = $_GET['action'] ?? 'nhanVienList';
    switch ($action) {
      case 'addNhanVien':
        $this->add();
        break;
      case 'editNhanVien':
        $this->update();
        break;
      case 'detailNhanVien':
        $this->detail();
        break;
      case 'deleteNhanVien':
        $this->delete();
        break;
      case 'phongBanList':
        $this->phongBanList();
        break;
      case 'addPhongBan':
        $this->addPhongBan();
        break;
      case 'detailPhongBan':
        $this->detailPhongBan();
        break;
      case 'nhanVienList':
      default:
        $this->nhanVienList();
        break;
    }
  }
}

// Main execution
$controller_NV = new C_NhanVien();
$controller_NV->check();
