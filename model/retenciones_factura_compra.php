<?php
/**
 * @author Christian Puchaicela <christianmls@hotmail.com>
*/
class retenciones_factura_compra extends \fs_model {

   public $id;
   public $factura;
   public $numero;
   public $serie;
   public $fecha_emision;
   public $total_retenido;

   public $limit  = 0;
   public $offset = 0;
   public $canPPagina = 1;

   public function __construct($data = FALSE) {
      parent::__construct('retenciones_factura_compra');

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
      $this->id             = '';
      $this->factura        = '';
      $this->numero         = ' ';
      $this->serie          = ' ';
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
   }

   public function install() {
      return '';
   }

   public function getPaginas($url,$actual){
     $salida = [];

     $this->offset = 0;
     $this->limit  = 0;

     $resultados   = $this->getAll();
     $cantidad     = count($resultados);
     $paginas      = floor($cantidad/$this->canPPagina);

     for ($c=0;$c<$paginas;$c++){
        $n = $c+1;
        $e = ['actual' => false, 'num' => $n, 'url' => $url.'&p='.$n];
        if ($c+1 == $actual){
          $e['actual'] = true;
        }
        array_push($salida,$e);
     }

     return $salida;
   }

   private function getLimitOffset(){
     $t = '';

     if ($this->limit != 0){
       $t .= 'LIMIT '.$this->limit.' ';
     }

     if ($this->offset){
       $t .= 'OFFSET '.$this->offset.' ';
     }
     return $t;
   }

   public function getAll(){
     return $this->db->select(
       'SELECT a.total_retenido, a.fecha_emision, c.nombre AS nombre_prov, b.codserie,b.codigo,a.factura
       FROM retenciones_factura_compra a
       INNER JOIN facturasprov b ON a.factura = b.idfactura
       INNER JOIN proveedores c ON b.codproveedor = c.codproveedor ORDER BY a.id '.$this->getLimitOffset());
   }

   public function getAllByFactura($id_factura){
     return $this->db->select(
       'SELECT a.total_retenido, a.fecha_emision, c.nombre AS nombre_prov, b.codserie,b.codigo
       FROM retenciones_factura_compra a
       INNER JOIN facturasprov b ON a.factura = b.idfactura
       INNER JOIN proveedores c ON b.codproveedor = c.codproveedor WHERE b.idfactura = '.$id_factura.' ORDER BY a.id '.$this->getLimitOffset());
   }


   protected function test() {

      return parent::test();
   }

   public function delete(){

   }

   public function save(){
     $sql = 'INSERT INTO retenciones_factura_compra '
             . '(factura,numero,serie,fecha_emision,total_retenido)'
             . ' VALUES '
             . '('.$this->factura.',"'.$this->numero.'","'.$this->serie.'","'.$this->fecha_emision.'","'.
             $this->total_retenido.'")';
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
