<?php
/**
 * @author Christian Puchaicela <christianmls@hotmail.com>
*/
class retencion extends \fs_model
{
  public $codretencion;
  public $descripcion;
  public $porcentaje;
  public $tiporetencion;
  public $codsubcuentasop;
  public $codsubcuentarep;

  public function __construct($data = FALSE)
  {
    parent::__construct('retenciones_sri');
    if ($data) {
      $this->codretencion = $data['codretencion'];
      $this->descripcion = $data['descripcion'];
      $this->porcentaje = floatval($data['porcentaje']);
      $this->tiporetencion = $data['tiporetencion'];
      $this->codsubcuentarep = $data['codsubcuentarep'];
      $this->codsubcuentasop = $data['codsubcuentasop'];
    } else {
      $this->codretencion = NULL;
      $this->descripcion = NULL;
      $this->porcentaje = 0.00;
      $this->tiporetencion = NULL;
      $this->codsubcuentarep = NULL;
      $this->codsubcuentasop = NULL;
    }
  }

  public function exists()
  {
    if (is_null($this->codretencion)) {
        return FALSE;
    }

    return $this->db->select("SELECT * FROM " . $this->table_name
            . " WHERE codretencion = " . $this->var2str($this->codretencion) . ";");
  }

  public function get($cod)
  {
    $data = $this->db->select("SELECT * FROM " . $this->table_name . " WHERE codretencion = " . $this->var2str($cod) . ";");
    if ($data) {
        return new \retencion($data[0]);
    }

    return FALSE;
  }

  public function test()
  {
    $status = FALSE;

    $this->codretencion = trim($this->codretencion);
    $this->descripcion = $this->no_html($this->descripcion);
    $this->tiporetencion = trim($this->tiporetencion);

    if (strlen($this->codretencion) < 1 || strlen($this->codretencion) > 10) {
        $this->new_error_msg("Código del impuesto no válido. Debe tener entre 1 y 10 caracteres.");
    } else if (strlen($this->descripcion) < 1 || strlen($this->descripcion) > 50) {
        $this->new_error_msg("Descripción de retención no válida.");
    } else if (strlen($this->tiporetencion) < 1 || strlen($this->tiporetencion) > 50) {
        $this->new_error_msg("Tipo de retención no seleccionado.");
    } else {
        $status = TRUE;
    }

    return $status;
  }

  public function save()
  {
    if ($this->test()) {
      $this->clean_cache();

      if ($this->exists()) {
        $sql = "UPDATE " . $this->table_name . " SET descripcion = " . $this->var2str($this->descripcion)
            . ", porcentaje = " . $this->var2str($this->porcentaje)
            . ", tiporetencion = " . $this->var2str($this->tiporetencion)
            . ", codsubcuentarep = " . $this->var2str($this->codsubcuentarep)
            . ", codsubcuentasop = " . $this->var2str($this->codsubcuentasop)
            . "  WHERE codretencion = " . $this->var2str($this->codretencion) . ";";
      } else {
        $sql = "INSERT INTO " . $this->table_name . " (codretencion,descripcion,porcentaje,tiporetencion,codsubcuentarep,codsubcuentasop) VALUES (" . $this->var2str($this->codretencion)
            . "," . $this->var2str($this->descripcion)
            . "," . $this->var2str($this->porcentaje)
            . "," . $this->var2str($this->tiporetencion)
            . "," . $this->var2str($this->codsubcuentarep)
            . "," . $this->var2str($this->codsubcuentasop)
            . ");";
      }

      return $this->db->exec($sql);
    }

      return FALSE;
  }

  public function delete()
  {
    $this->clean_cache();
    return $this->db->exec("DELETE FROM " . $this->table_name . " WHERE codretencion = " . $this->var2str($this->codretencion) . ";");
  }

  private function clean_cache()
  {
      $this->cache->delete('m_retencion_all');
  }

  public function all()
  {
    /// leemos la lista de la caché
    $retencionlist = $this->cache->get_array('m_retencion_all');
    if (!$retencionlist) {
      /// si no encontramos la lista en caché, leemos de la base de datos
      $data = $this->db->select("SELECT * FROM " . $this->table_name . " ORDER BY codretencion DESC;");
      if ($data) {
          foreach ($data as $i) {
              $retencionlist[] = new \retencion($i);
          }
      }

      /// guardamos la lista en caché
      $this->cache->set('m_retencion_all', $retencionlist);
    }

    return $retencionlist;
  }
}
