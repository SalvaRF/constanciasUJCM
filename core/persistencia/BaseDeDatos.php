<?php
require_once "MySQL.php";
require_once "SQL.php";
class BaseDeDatos {
    
    private $_manejador;

    public function __construct(ManejadorBDInterface $manejador){
        $this->_manejador  = $manejador;
    }
    public function ejecutar(SQL $sql){
        $this->_manejador->conectar();
        
        $retorno = $this->_manejador->traerDatos($sql);
        
        $this->_manejador->desconectar();
        return $retorno;
    }
}