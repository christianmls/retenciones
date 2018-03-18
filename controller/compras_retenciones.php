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
class compras_retenciones extends fs_controller
{
  public $mostrar;

  public function __construct()
  {
    parent::__construct(__CLASS__, 'Retenciones', 'compras');
  }

  protected function private_core()
  {
    $this->mostrar = 'facturas';
    $retencionesModel = new retenciones_factura_compra();

    $this->retenciones  = $retencionesModel->getAll();
    $this->allow_edit   = true;
  }
}
