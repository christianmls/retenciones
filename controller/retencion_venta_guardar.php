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
    //obtenemos los codigos de retenciones
    $this->reten   = $this->db->select('SELECT * FROM retenciones_sri WHERE tiporetencion = "renta"');
    //obtenemos las lineas de factura correspondientes
    if (!$this->is_assoc($_POST))
      die('Parametros incorrectos');

    $lineas = $_POST;
    var_dump($lineas);
  }

  private function is_assoc($var)
  {
        return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
  }
}
