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
require_once 'plugins/facturacion_base/extras/fbase_controller.php';
class retencion_compra extends fbase_controller
{
  public $agente;
  public $almacenes;
  public $articulo;
  public $buscar_lineas;
  public $codagente;
  public $codalmacen;
  public $codserie;
  public $desde;
  public $estado;
  public $factura;
  public $hasta;
  public $lineas;
  public $mostrar;
  public $num_resultados;
  public $offset;
  public $order;
  public $proveedor;
  public $resultados;
  public $serie;
  public $total_resultados;
  public $total_resultados_txt;

  public function __construct()
  {
   parent::__construct(__CLASS__);
  }

  protected function private_core()
  {
    $this->mostrar = 'html';
    if (isset($_GET['mostrar'])) $this->mostrar = $_GET['mostrar'];

    $this->url         = 'index.php?page=retencion_factura_compra';
    $this->urlProb     = 'index.php?page=retencion_compra';
    $this->urlFacturas = 'index.php?page=retencion_compra&mostrar=resultados';
    
    if (isset($_REQUEST['buscar_proveedor']))
        $this->fbase_buscar_proveedor($_REQUEST['buscar_proveedor']);

    if ($this->mostrar == 'resultados'){
      $this->agente      = new agente();
      $this->almacenes   = new almacen();
      $this->factura     = new factura_proveedor();
      $this->serie       = new serie();

      $this->offset = 0;
      $this->order = 'fecha DESC';
      $this->proveedor = FALSE;
      $this->codagente = '';
      $this->codalmacen = '';
      $this->codserie = '';
      $this->desde = '';
      $this->estado = '';
      $this->hasta = '';
      $this->num_resultados = '';
      $this->total_resultados = [];
      $this->total_resultados_txt = '';

      if (isset($_REQUEST['codproveedor']) && $_REQUEST['codproveedor'] != '') {
        $pro0 = new proveedor();
        $this->proveedor = $pro0->get($_REQUEST['codproveedor']);
      }

      if (isset($_REQUEST['codagente'])) {
        $this->codagente = $_REQUEST['codagente'];
      }

      if (isset($_REQUEST['codserie'])) {
        $this->codserie = $_REQUEST['codserie'];
      }

      if (isset($_REQUEST['desde'])) {
        $this->desde = $_REQUEST['desde'];
        $this->hasta = $_REQUEST['hasta'];
        $this->estado = $_REQUEST['estado'];
      }


      /// añadimos segundo nivel de ordenación
      $order2 = '';
      if ($this->order == 'fecha DESC') {
        $order2 = ', hora DESC, numero DESC';
      } else if ($this->order == 'fecha ASC') {
        $order2 = ', hora ASC, numero ASC';
      }

      $this->resultados = $this->factura->all($this->offset, FS_ITEM_LIMIT, $this->order . $order2);

      $this->template = FALSE;
      header('Content-Type: application/json');
      echo json_encode($this->resultados);
      exit();
    }
  }
}
