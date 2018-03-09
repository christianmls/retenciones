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
    $factura       = $this->db->select('SELECT * FROM facturascli WHERE idfactura='.$_POST['idFactura']);
    //hacemos las sumatorias
    $this->sumaIva         = 0;
    $this->sumaRetenciones = 0;
    $this->sumaSubTotales  = 0;

    foreach ($lineasFactura as $k => $v) {
      $this->sumaSubTotales  += $v['pvptotal'];
      $this->sumaRetenciones += $v['pvptotal']/100*$mRetenciones->getPorcentajeRetencion($retenciones[$v['idlinea']]['retencion']);
      $this->sumaIva         += $v['pvptotal']/100*$v['iva'];

      $modelRetencionVenta = new retenciones_factura_compra();
      $modelRetencionVenta->factura        = $_POST['idFactura'];
      $modelRetencionVenta->porcentaje     = $mRetenciones->getPorcentajeRetencion($retenciones[$v['idlinea']]['retencion']);
      $modelRetencionVenta->fecha_emision  = $factura[0]['fecha'];
      $modelRetencionVenta->serie          = $factura[0]['codserie'];
      $modelRetencionVenta->total          = $v['pvptotal']/100*$mRetenciones->getPorcentajeRetencion($retenciones[$v['idlinea']]['retencion']);
      $modelRetencionVenta->tipo_retencion = $retenciones[$v['idlinea']]['retencion'];
      $modelRetencionVenta->save();
    }

    $this->total = $this->sumaSubTotales + $this->sumaRetenciones + $this->sumaIva;
  }

  private function is_assoc($var)
  {
        return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
  }
}
