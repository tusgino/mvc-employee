<?php

include_once('M_PhongBan.php');

class E_NhanVien
{
  private $IDNV;
  private $Hoten;
  private $IDPB;
  private $Diachi;

  public function __construct($IDNV, $Hoten, $IDPB, $Diachi)
  {
    $this->IDNV = $IDNV;
    $this->Hoten = $Hoten;
    $this->IDPB = $IDPB;
    $this->Diachi = $Diachi;
  }

  public function getTenPB()
  {
    $modelPB = new M_PhongBan();
    return $modelPB->getTenPB($this->IDPB);
  }

  public function getIDNV()
  {
    return $this->IDNV;
  }

  public function setIDNV($IDNV)
  {
    $this->IDNV = $IDNV;
  }

  public function getHoten()
  {
    return $this->Hoten;
  }

  public function setHoten($Hoten)
  {
    $this->Hoten = $Hoten;
  }

  public function getIDPB()
  {
    return $this->IDPB;
  }

  public function setIDPB($IDPB)
  {
    $this->IDPB = $IDPB;
  }

  public function getDiachi()
  {
    return $this->Diachi;
  }

  public function setDiachi($Diachi)
  {
    $this->Diachi = $Diachi;
  }
}
