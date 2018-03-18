<?php
/**
 * @author Christian Puchaicela <christianmls@hotmail.com>
*/
class retenciones_factura_venta extends \fs_model {

   public $id;
   public $factura;
   public $numero;
   public $serie;
   public $fecha_emision;
   public $total_retenido;

   public function __construct($data = FALSE) {
      parent::__construct('retenciones_factura_venta');

      if ($data) {
         $this->load_from_data($data);
      } else {
         $this->clear();
      }
   }

   public function getAll(){
     return $this->db->select(
       'SELECT a.total_retenido, a.fecha_emision, c.nombre AS nombre_prov, b.codserie,b.codigo
       FROM retenciones_factura_venta a
       INNER JOIN facturasprov b ON a.factura = b.idfactura
       INNER JOIN proveedores c ON b.codproveedor = c.codproveedor');
   }

   public function getAllByFactura($id_factura){
     return $this->db->select(
       'SELECT a.total_retenido, a.fecha_emision, c.nombre AS nombre_prov, b.codserie,b.codigo
       FROM retenciones_factura_venta a
       INNER JOIN facturasprov b ON a.factura = b.idfactura
       INNER JOIN proveedores c ON b.codproveedor = c.codproveedor WHERE b.idfactura = '.$id_factura);
   }

   public function exists() {
      return parent::exists();
   }

   public function clear() {
      $this->id             = '';
      $this->factura        = '';
      $this->numero         = '';
      $this->serie          = '';
      $this->fecha_emision  = '';
      $this->total_retenido = '';
   }

   public function load_from_data($data) {
      $this->id             = $data['id'];
      $this->factura        = $data['factura'];
      $this->numero         = $data['numero'];
      $this->serie          = $data['serie'];
      $this->fecha_emision  = $data['fecha_emision'];
      $this->total_retenido = $data['total_retenido'];
      $this->porcentaje     = $data['porcentaje'];
   }

   public function install() {
      return '';
   }

   protected function test() {

      return parent::test();
   }

   public function delete(){

   }

   public function save(){
     $sql = 'INSERT INTO retenciones_factura_venta '
             . '(factura,numero,serie,fecha_emision,total_retenido)'
             . ' VALUES '
             . '("'.$this->factura.'","'.$this->numero.'","'.$this->serie.'","'.$this->fecha_emision.'","'.
             $this->total_retenido.'")';
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
              . '(id,factura,numero,serie,fecha_emision,total_retenido)'
              . ' VALUES '
              . '(...);';

      return $this->db->exec($sql);
   }

}
