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
class retencion_venta extends fbase_controller
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
    $this->mostrar  = 'html';
    if (isset($_GET['mostrar'])) {
        $this->mostrar = $_GET['mostrar'];
    }

    $this->url         = 'index.php?page=retencion_factura_venta';
    $this->urlClient   = 'index.php?page=retencion_venta';
    $this->urlFacturas = 'index.php?page=retencion_venta&mostrar=resultados';

    if (isset($_REQUEST['buscar_cliente']))
        $this->fbase_buscar_cliente($_REQUEST['buscar_cliente']);

    if ($this->mostrar == 'resultados'){
      $this->agente      = new agente();
      $this->almacenes   = new almacen();
      $this->factura     = new factura_cliente();
      $this->serie       = new serie();

      $this->offset = 0;
      if (isset($_GET['offset'])) {
          $this->offset = intval($_GET['offset']);
      }

      $this->order = 'fecha DESC';

      if (isset($_GET['ref'])) {
          $this->template = 'extension/compras_facturas_articulo';

          $articulo = new articulo();
          $this->articulo = $articulo->get($_GET['ref']);

          $linea = new linea_factura_cliente();
          $this->resultados = $linea->all_from_articulo($_GET['ref'], $this->offset);
      } else {
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

          if (!isset($_GET['mostrar']) && ( $this->query != '' || isset($_REQUEST['codagente']) || isset($_REQUEST['codproveedor']) || isset($_REQUEST['codserie']))) {
              /**
               * si obtenermos un codagente, un codproveedor o un codserie pasamos direcatemente
               * a la pestaña de búsqueda, a menos que tengamos un mostrar, que
               * entonces nos indica donde tenemos que estar.
               */
              $this->mostrar = 'buscar';
          }

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

          if (isset($_GET['id_cliente'])){
            $cliente = $_GET['id_cliente'];
            $this->resultados = $this->factura->all_from_cliente($cliente,$this->offset);
          } else {
            $this->resultados = $this->factura->all_from_cliente($this->offset, FS_ITEM_LIMIT, $this->order . $order2);
          }
        
          $this->template = FALSE;
          header('Content-Type: application/json');
          echo json_encode($this->resultados);
          exit();
      }
    }
  }

}
