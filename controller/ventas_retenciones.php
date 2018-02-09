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
class ventas_retenciones extends fs_controller
{
   public $texto;
   public $texto2;
   public $lista;
   public $resultados_sql;
   
   public function __construct()
   {
      parent::__construct(__CLASS__, 'Retenciones', 'ventas');
   }
   
   protected function private_core()
   {
      $this->texto = 'hola mundo';
      $this->texto2 = 'Bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla, bla.';
      $this->lista = array('peras', 'manzanas', 'puerros', 'naranjas');
      
      $this->resultados_sql = $this->db->select("select * from paises;");
   }
}
