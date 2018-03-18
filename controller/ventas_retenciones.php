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
class ventas_retenciones extends fs_controller
{
   public function __construct()
   {
      parent::__construct(__CLASS__, 'Retenciones', 'ventas');
   }

   protected function private_core()
   {
      $this->mostrar = 'facturas';
      $retencionesModel = new retenciones_factura_venta();

      $this->retenciones  = $retencionesModel->getAll();
      $this->allow_edit   = true;
   }
}
