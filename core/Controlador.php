<?php
require_once "Vista.php";
abstract class Controlador {
   # Código del CORE - Controlador
   static protected function show($vista,
                                        $datos='',
                                        $comoContenido=FALSE){
       return Vista::show($vista,$datos,$comoContenido);
   }
   public function __toString(){
      return __CLASS__;
   }
}
