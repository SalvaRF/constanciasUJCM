<?php
require_once './core/Modelo.php';

class Entidad extends Modelo {
    
    
    private $_tabla='institucion';
    /* private $_vista='v_constanciaEco'; */

    public function __construct(){

        parent::__construct($this->_tabla);
    }

    public function get(){
        return $this->getAll()['data'];
    }
}