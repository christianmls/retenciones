<?php

/*
 * @author Christian Puchaicela      christianmls@hotmail.com
 * @copyright 2017, InfinityCSoft. All Rights Reserved.
 */


/**
 * Description of retenciones
 *
 * @author Christian Puchaicela <christianmls@hotmail.com>
 */
class contabilidad_retenciones extends fs_controller
{
  public $allow_delete;
  public $retencion;
  public $codsubcuentasop;
  public $codsubcuentarep;

  public function __construct()
  {
    parent::__construct(__CLASS__, 'Retenciones', 'contabilidad');
  }

  protected function private_core()
  {
    $this->allow_delete = $this->user->allow_delete_on($this->class_name);
    $this->retencion = new retencion();

    if (isset($_GET['delete'])) {
        $this->eliminar_retencion();
    } else if (isset($_POST['codretencion'])) {
        $this->editar_retencion();
    } else if (isset($_GET['set_default'])) {
        $this->save_codretencion($_GET['set_default']);
    }
  }

  private function editar_retencion()
  {
      $retencion = $this->retencion->get($_POST['codretencion']);
      if (!$retencion) {
          $retencion = new retencion();
          $retencion->codretencion = $_POST['codretencion'];
      }

      $retencion->descripcion = $_POST['descripcion'];
      $retencion->porcentaje = floatval($_POST['porcentaje']);
      $retencion->tiporetencion = $_POST['tiporetencion'];
      $retencion->codsubcuentasop = $_POST['codsubcuentasop'];
      $retencion->codsubcuentarep = $_POST['codsubcuentarep'];

      if ($retencion->save()) {
          $this->new_message("Retención " . $retencion->codretencion . " guardado correctamente.");
      } else
          $this->new_error_msg("¡Error al guardar el retención!");
  }

  private function eliminar_retencion()
  {
      if (!$this->user->admin) {
          $this->new_error_msg('Sólo un administrador puede eliminar retenciones.');
      } else {
          $retencion = $this->retencion->get($_GET['delete']);
          if ($retencion) {
              if ($retencion->delete()) {
                  $this->new_message('Retención eliminado correctamente.');
              } else
                  $this->new_error_msg('Ha sido imposible eliminar la retención.');
          } else
              $this->new_error_msg('Retención no encontrado.');
      }
  }
}
