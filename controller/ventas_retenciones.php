<?php

/*
 * @author Christian Puchaicela      christianmls@hotmail.com
 * @copyright 2017, InfinityCSoft. All Rights Reserved.
 */

class ventas_retenciones extends fs_controller
{
  public $mostrar;
  public $canPPagina = 10; //cantida de elementos por pagina

   public function __construct()
   {
      parent::__construct(__CLASS__, 'Retenciones', 'ventas');
   }

   protected function private_core()
   {
      $limit      = 0;
      $offset     = 0;
      $page       = 0;

      if (isset($_GET['p'])){
        $page   = $_GET['p'];
        $limit  = $this->canPPagina;
        $offset = $this->canPPagina*($page-1);
      }

      $this->mostrar = 'facturas';
      $retencionesModel = new retenciones_factura_venta();
      $retencionesModel->limit  = $limit;
      $retencionesModel->offset = $offset;
      $retencionesModel->canPPagina = $this->canPPagina;


      $this->retenciones  = $retencionesModel->getAll();
      $this->allow_edit   = true;
   }

   public function paginas()
   {
       $p = 1;
       if (isset($_GET['p'])){
         $page   = $_GET['p'];
       }
       $retencionesModel             = new retenciones_factura_compra();
       $retencionesModel->canPPagina = $this->canPPagina;
       return $retencionesModel->getPaginas('?page=compras_retenciones',$p);
   }
}
