<?php
require_once './core/Modelo.php';

class ConstanciaNoAdeudo extends Modelo {
    private $id;
    private $nombre;
    
    private $_tabla='constancias';
    private $_vista='v_constancia';

    public function __construct($id=null,$nombre=null){
        $this->id = $id;
        $this->nombre=$nombre;
        parent::__construct($this->_tabla);
    }
    public function getTodo(){
        return $this->getAll();
    }
    public function eliminar(){
        return $this->deleteById($this->id);
    }
    public function guardar(){
        $datos = [
            'id'=>$this->id,
            'nombre'=>"'$this->nombre'",
        ];
        return $this->insert($datos);
    }
    public function editar(){
        return $this->getById($this->id);
    }
    public function actualizar(){
        $datos = [
            'id'=>$this->id,
            'nombre'=>"'$this->nombre'",
        ];
        $wh = "id=$this->id";
        return $this->update($wh,$datos);
    }
}