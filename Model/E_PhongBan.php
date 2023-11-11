<?php

class E_PhongBan
{
  private $IDPB;
  private $TenPB;
  private $MoTa;

  public function __construct($IDPB, $TenPB, $MoTa)
  {
    $this->IDPB = $IDPB;
    $this->TenPB = $TenPB;
    $this->MoTa = $MoTa;
  }

  public function getIDPB()
  {
    return $this->IDPB;
  }

  public function setIDPB($IDPB)
  {
    $this->IDPB = $IDPB;
  }

  public function getTenPB()
  {
    return $this->TenPB;
  }

  public function setTenPB($TenPB)
  {
    $this->TenPB = $TenPB;
  }

  public function getMoTa()
  {
    return $this->MoTa;
  }

  public function setMoTa($MoTa)
  {
    $this->MoTa = $MoTa;
  }
}
