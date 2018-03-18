<?php
/**
 * @author Christian Puchaicela <christianmls@hotmail.com>
*/
class retenciones_lineas_compra extends \fs_model {

   public $id;
   public $factura;
   public $numero=' ';
   public $serie=' ';
   public $fecha_emision;
   public $total;
   public $tipo_retencion;
   public $porcentaje;

   public function __construct($data = FALSE) {
      parent::__construct('retenciones_lineas_compra');

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
      $this->numero = ' ';
      $this->serie = ' ';
      $this->fecha_emision = '';
      $this->total = '';
      $this->tipo_retencion = '';
      $this->porcentaje = '';
      $this->observaciones = ' ';
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
   }

   public function install() {
      return '';
   }

   public function getAll(){
     return $this->db->select(
       'SELECT a.total AS total_retencion, a.tipo_retencion, a.fecha_emision, c.nombre AS nombre_prov
       FROM retenciones_lineas_compra a
       INNER JOIN facturasprov b ON a.factura = b.idfactura
       INNER JOIN proveedores c ON b.codproveedor = c.codproveedor');
   }

   public function getAllByFactura($id_factura){
     return $this->db->select(
       'SELECT a.total AS total_retencion, a.tipo_retencion, a.fecha_emision, c.nombre AS nombre_prov
       FROM retenciones_lineas_compra a
       INNER JOIN facturasprov b ON a.factura = b.idfactura
       INNER JOIN proveedores c ON b.codproveedor = c.codproveedor WHERE b.idfactura = '.$id_factura);
   }


   protected function test() {

      return parent::test();
   }

   public function delete(){

   }

   public function save(){
     $sql = 'INSERT INTO retenciones_lineas_compra '
             . '(factura,numero,serie,fecha_emision,total,tipo_retencion,porcentaje)'
             . ' VALUES '
             . '('.$this->factura.',"'.$this->numero.'","'.$this->serie.'","'.$this->fecha_emision.'",'.
             $this->total.',"'.$this->tipo_retencion.'",'.$this->porcentaje.')';
     return $this->db->exec($sql);
   }

   protected function update() {
      $sql = 'UPDATE retenciones_factura_compra SET '
              . '  field1 = value1'
              . ', fieldN = valueN'
              . ' WHERE field_key1 = key_value1;';

      return $this->db->exec($sql);
   }

}
