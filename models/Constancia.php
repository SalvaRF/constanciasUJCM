<?php
require_once './core/Modelo.php';

class Constancia extends Modelo {
    private $id;
    private $nombre;
    
    private $_tabla='constancias';
    // private $_vista='v_constanciaEco';

    public function __construct($id=null){
        $this->id = $id;

        parent::__construct($this->_tabla);
    }

    public function getXEstudiantePago($idEstudiante, $recibo){
        $sql = "Select * from $this->_tabla where id_estudiante='$idEstudiante' and recibo='$recibo'";
        $this->setSql($sql);
        return $this->_bd->ejecutar($this->_sql)['data'];
    }
    public function getConstanciaXDniRecibo($dni, $recibo){
        $sql = "Select * from $this->_tabla where id_estudiante in(Select id from Estudiantes where dni='$dni') and recibo='$recibo'";
        $this->setSql($sql);
        return $this->_bd->ejecutar($this->_sql)['data'];
    }
    public function guardar($numero,$fecha,$semestre,$url,$recibo,$idEstudiante,$idTipo){

        $datos=[
            'numero'=>"'$numero'",
            'fecha'=>"'$fecha'",
            'semestre'=>"'$semestre'",
            'url'=>"'$url'",
            'recibo'=>"'$recibo'",
            'id_estudiante'=>$idEstudiante,
            'id_tipo'=>$idTipo
        ];
        return $this->insert($datos);

    }
    public function siguienteNro(){
        $sql = 'Select getNumeroConstancia() as numero;';
        $this->setSql($sql);
        return $this->_bd->ejecutar($this->_sql)['data'][0];
    }
}