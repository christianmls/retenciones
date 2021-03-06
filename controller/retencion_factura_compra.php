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
class retencion_factura_compra extends fs_controller
{
  public function __construct()
  {
    parent::__construct(__CLASS__);
  }

  protected function private_core()
  {
    $idFactura     = strip_tags($_POST['factura_seleccionada']);
    $this->factura = new factura_proveedor();
    $this->factura = $this->factura->get($idFactura);
    $this->lineas  = $this->db->select('SELECT * FROM lineasfacturasprov WHERE idfactura = '.$idFactura);  //falta hacer join para traer los valores de iva

    $this->reten   = $this->db->select('SELECT * FROM retenciones_sri WHERE tiporetencion = "renta"');

    $this->urlRetenciones = 'index.php?page=retencion_compra_guardar';

    //comprobamos si ya se hizo una retencion
    $modelRetenciones = new retenciones_lineas_compra();

    $this->retencionHecha = false;
    if (count($modelRetenciones->getAllByFactura($idFactura))>0){
      $this->retencionHecha = true;
    }
  }

}
