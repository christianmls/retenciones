<?php
/**
 * @author Christian Puchaicela <christianmls@hotmail.com>
*/
class retenciones_lineas_venta extends \fs_model {

   public $id;
   public $factura;
   public $numero;
   public $serie;
   public $fecha_emision;
   public $total;
   public $tipo_retencion;
   public $porcentaje;
   public $id_linea;

   public function __construct($data = FALSE) {
      parent::__construct('retenciones_lineas_venta');

      if ($data) {
         $this->load_from_data($data);
      } else {
         $this->clear();
      }
   }

   public function getAll(){
     return $this->db->select(
       'SELECT a.total AS total_retencion,b.nombrecliente, a.tipo_retencion, b.fecha
       FROM retenciones_lineas_venta a
       INNER JOIN facturascli b ON a.factura = b.idfactura');
   }

   public function getAllByFactura($id_factura){
     return $this->db->select(
       'SELECT a.total AS total_retencion,b.nombrecliente, a.tipo_retencion,a.id, b.fecha,lf.*
       FROM retenciones_lineas_venta a
       INNER JOIN lineasfacturascli lf ON lf.idlinea = a.id_linea
       INNER JOIN facturascli b ON a.factura = b.idfactura
       WHERE b.idfactura = '.$id_factura);
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
   }

   public function load_from_data($data) {
      $this->id             = $data['id'];
      $this->factura        = $data['factura'];
      $this->numero         = $data['numero'];
      $this->serie          = $data['serie'];
      $this->fecha_emision  = $data['fecha_emision'];
      $this->total          = $data['total'];
      $this->tipo_retencion = $data['tipo_retencion'];
      $this->porcentaje     = $data['porcentaje'];
   }

   public function install() {
      return '';
   }

   protected function test() {

      return parent::test();
   }

   public function delete(){
     $sql = 'DELETE FROM retenciones_lineas_venta WHERE id='.$this->id;
     return $this->db->exec($sql);
   }

   public function save(){
     $sql = 'INSERT INTO retenciones_lineas_venta '
             . '(factura,numero,serie,fecha_emision,total,tipo_retencion,porcentaje,id_linea)'
             . ' VALUES '
             . '('.$this->factura.',"'.$this->numero.'","'.$this->serie.'","'.$this->fecha_emision.'",'.
             $this->total.',"'.$this->tipo_retencion.'",'.$this->porcentaje.',"'.$this->id_linea.'")';
     return $this->db->exec($sql);
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
              . '(id,factura,numero,serie,fecha_emision,total,tipo_retencion,porcentaje)'
              . ' VALUES '
              . '(...);';

      return $this->db->exec($sql);
   }

}
