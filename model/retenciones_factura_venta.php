<?php
/**
 * @author Christian Puchaicela <christianmls@hotmail.com>
*/
class retenciones_factura_venta extends \fs_model {

   private $id;
   private $factura;
   private $numero;
   private $serie;
   private $fecha_emision;
   private $total;
   private $tipo_retencion;
   private $porcentaje;
   private $observaciones;

   public function __construct($data = FALSE) {
      parent::__construct('retenciones_factura_venta');

      if ($data) {
         $this->load_from_data($data);
      } else {
         $this->clear();
      }
   }

   public function exists() {
      return parent::exists();
   }

   public function clear() {
      $this->id = '';
      $this->factura = '';
      $this->numero = '';
      $this->serie = '';
      $this->fecha_emision = '';
      $this->total = '';
      $this->tipo_retencion = '';
      $this->porcentaje = '';
      $this->observaciones = '';
   }

   public function load_from_data($data) {
      $this->id = $data['id'];
      $this->factura = $data['factura'];
      $this->numero = $data['numero'];
      $this->serie = $data['serie'];
      $this->fecha_emision = $data['fecha_emision'];
      $this->total = $data['total'];
      $this->tipo_retencion = $data['tipo_retencion'];
      $this->porcentaje = $data['porcentaje'];
      $this->observaciones = $data['observaciones'];
   }

   public function install() {
      return '';
   }

   protected function test() {
      /*
        PUT HERE MODEL DATA VALIDATIONS
        EXAMPLE:
        if($this->field_Numeric == 0) {
        $this->new_error_msg('Must be inform a code value');
        return FALSE;
        }
        return TRUE;
       */
      return parent::test();
   }

   public function delete(){

   }

   public function save(){

   }

   public function update() {
      $sql = 'UPDATE retenciones_factura_venta SET '
              . '  field1 = value1'
              . ', fieldN = valueN'
              . ' WHERE field_key1 = key_value1;';

      return $this->db->exec($sql);
   }

   public function insert() {
      $sql = 'INSERT INTO retenciones_factura_venta '
              . '(id,factura,numero,serie,fecha_emision,total,tipo_retencion,porcentaje,observaciones)'
              . ' VALUES '
              . '(...);';

      return $this->db->exec($sql);
   }

}
