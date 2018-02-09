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
class retencion_compra extends fs_controller
{
  public $mostrar;

  public function __construct()
  {
    parent::__construct(__CLASS__, 'Retenciones', 'compras');
  }

  protected function private_core()
  {
    $this->mostrar = 'todo';
  }
}
