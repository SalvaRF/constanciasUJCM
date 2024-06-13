<?php
require_once "./core/persistencia/EntidadBase.php";
class Modelo extends EntidadBase{

    public function __construct($tabla=null){
        if ($tabla != null){
            parent::__construct($tabla);
        }
    }

}