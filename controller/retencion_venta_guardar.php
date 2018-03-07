<?php

/*
 * @author Christian Puchaicela      christianmls@hotmail.com
 * @copyright 2017, InfinityCSoft. All Rights Reserved.
 */


/**
 * Description of retenciones
 *
 * @author Christian Puchaicela
 */
class retencion_venta_guardar extends fs_controller
{
  public function __construct()
  {
    parent::__construct(__CLASS__);
  }

  protected function private_core()
  {
    $mRetenciones = new retencion;
    //obtenemos las lineas de factura correspondientes
    
    $retenciones = $_POST['retenciones'];

    $lineasFactura = $this->db->select('SELECT * FROM lineasfacturascli WHERE idfactura='.$_POST['idFactura']);

    //hacemos las sumatorias
    $this->sumaIva         = 0;
    $this->sumaRetenciones = 0;
    $this->sumaSubTotales  = 0;

    foreach ($lineasFactura as $k => $v) {
      $this->sumaSubTotales  += $v['pvptotal'];
      $this->sumaRetenciones += $v['pvptotal']/100*$mRetenciones->getPorcentajeRetencion($retenciones[$v['idlinea']]['retencion']);
      $this->sumaIva         += $v['pvptotal']/100*$v['iva'];
    }

    $this->total = $this->sumaSubTotales + $this->sumaRetenciones + $this->sumaIva;
  }

  private function is_assoc($var)
  {
        return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
  }
}
