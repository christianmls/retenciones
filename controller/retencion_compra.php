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
   parent::__construct(__CLASS__, 'Calcular retención', 'compras', FALSE, FALSE, TRUE);
  }

  protected function private_core()
  {
    $this->mostrar  = 'todo';

    $this->agente    = new agente();
    $this->almacenes = new almacen();
    $this->factura   = new factura_proveedor();
    $this->serie     = new serie();
    $this->url       = 'index.php?page=retencion_factura_compra';

    $this->mostrar = 'todo';
    if (isset($_GET['mostrar'])) {
        $this->mostrar = $_GET['mostrar'];
        setcookie('compras_fac_mostrar', $this->mostrar, time() + FS_COOKIES_EXPIRE);
    } else if (isset($_COOKIE['compras_fac_mostrar'])) {
        $this->mostrar = $_COOKIE['compras_fac_mostrar'];
    }

    $this->offset = 0;
    if (isset($_GET['offset'])) {
        $this->offset = intval($_GET['offset']);
    }

    $this->order = 'fecha DESC';
    if (isset($_GET['order'])) {
        $orden_l = $this->orden();
        if (isset($orden_l[$_GET['order']])) {
            $this->order = $orden_l[$_GET['order']]['orden'];
        }

        setcookie('compras_fac_order', $this->order, time() + FS_COOKIES_EXPIRE);
    } else if (isset($_COOKIE['compras_fac_order'])) {
        $this->order = $_COOKIE['compras_fac_order'];
    }

    if (isset($_POST['buscar_lineas'])) {
        $this->buscar_lineas();
    } else if (isset($_REQUEST['buscar_proveedor'])) {
        $this->fbase_buscar_proveedor($_REQUEST['buscar_proveedor']);
    } else if (isset($_GET['ref'])) {
        $this->template = 'extension/compras_facturas_articulo';

        $articulo = new articulo();
        $this->articulo = $articulo->get($_GET['ref']);

        $linea = new linea_factura_proveedor();
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

        $this->resultados = $this->factura->all($this->offset, FS_ITEM_LIMIT, $this->order . $order2);
    }

  }

}
