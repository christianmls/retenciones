<?php

/*
 * @author Christian Puchaicela      christianmls@hotmail.com
 * @copyright 2017, InfinityCSoft. All Rights Reserved.
 */

class retencion_compra_guardar extends fs_controller
{
  public function __construct()
  {
    parent::__construct(__CLASS__);
  }

  protected function private_core()
  {
    $mRetenciones = new retencion;

    $retenciones = $_POST['retenciones'];

    $lineasFactura = $this->db->select('SELECT * FROM lineasfacturasprov WHERE idfactura='.$_POST['idFactura']);
    $factura       = $this->db->select('SELECT * FROM facturasprov WHERE idfactura='.$_POST['idFactura']);
    //hacemos las sumatorias
    $this->sumaIva         = 0;
    $this->sumaRetenciones = 0;
    $this->sumaSubTotales  = 0;

    foreach ($lineasFactura as $k => $v) {
      $this->sumaSubTotales  += $v['pvptotal'];
      $this->sumaRetenciones += $v['pvptotal']/100*$mRetenciones->getPorcentajeRetencion($retenciones[$v['idlinea']]['retencion']);
      $this->sumaIva         += $v['pvptotal']/100*$v['iva'];

      $lineaRetencion = new retenciones_lineas_compra();
      $lineaRetencion->factura        = $_POST['idFactura'];
      $lineaRetencion->porcentaje     = $mRetenciones->getPorcentajeRetencion($retenciones[$v['idlinea']]['retencion']);
      $lineaRetencion->fecha_emision  = $factura[0]['fecha'];
      $lineaRetencion->serie          = $factura[0]['codserie'];
      $lineaRetencion->total          = $v['pvptotal']/100*$mRetenciones->getPorcentajeRetencion($retenciones[$v['idlinea']]['retencion']);
      $lineaRetencion->tipo_retencion = $retenciones[$v['idlinea']]['retencion'];
      $lineaRetencion->id_linea       = $v['idlinea'];
      $lineaRetencion->save();
    }

    $this->total    = $this->sumaSubTotales + $this->sumaRetenciones + $this->sumaIva;

    $totalRetencion                 = new retenciones_factura_compra();
    $totalRetencion->factura        = $_POST['idFactura'];
    $totalRetencion->serie          = $factura[0]['codserie'];
    $totalRetencion->fecha_emision  = $factura[0]['fecha'];
    $totalRetencion->total_retenido = $this->total;
    $totalRetencion->save();
  }

  private function is_assoc($var)
  {
        return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
  }

}
