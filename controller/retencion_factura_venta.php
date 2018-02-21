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
class retencion_factura_venta extends fs_controller
{

  public function __construct()
  {
    parent::__construct(__CLASS__);
  }

  protected function private_core()
  {
    $idFactura     = strip_tags($_POST['factura_seleccionada']);
    $this->factura = new factura_cliente();
    $this->factura = $this->factura->get($idFactura);
    $this->lineas  = $this->db->select('SELECT * FROM lineasfacturascli WHERE idfactura = '.$idFactura); //falta hacer join para traer los valores de iva

    $this->reten   = $this->db->select('SELECT * FROM retenciones_sri');
  }

}
