<?php

/*
 * @author Christian Puchaicela      christianmls@hotmail.com
 * @copyright 2017, InfinityCSoft. All Rights Reserved.
 */

class edit_retencion_venta extends fs_controller
{
  public function __construct()
  {
    parent::__construct(__CLASS__);
  }

  protected function private_core()
  {
    $this->id_factura = 0;
    if (isset($_GET['id_factura'])){
      $this->id_factura = strip_tags($_GET['id_factura']);
    }

    $lineasVenta  = new retenciones_lineas_venta();
    $this->lineas = $lineasVenta->getAllByFactura($this->id_factura);

    $this->reten   = $this->db->select('SELECT * FROM retenciones_sri WHERE tiporetencion = "renta"');

    $this->urlRetenciones = 'index.php?page=retencion_venta_guardar';
  }

}
