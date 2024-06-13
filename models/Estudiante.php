<?php
require_once './core/Modelo.php';

class Estudiante extends Modelo {
    private $id;

    private $dni;
    
    private $_tabla='estudiantes';
    /* private $_vista='v_constanciaEco'; */

    public function __construct($dni=null){
        $this->dni = $dni;

        parent::__construct($this->_tabla);
    }

    public function getXDNI($dni=null){
        $this->dni = ($dni==null)?$this->dni:$dni;
        /* if ($dni==null) 
            $dni=$this->dni;
        else
            $this->dni=$dni; */

        $sql = "Select * from $this->_tabla where dni='$this->dni'";
        $this->setSql($sql);
        return $this->_bd->ejecutar($this->_sql);
    }

    public function getDeudas($dni=null){
        $this->dni = ($dni==null)?$this->dni:$dni;

        $sql = "Select * from deudas where id_estudiante in 
            (Select id from $this->_tabla where dni='$this->dni')";
        $this->setSql($sql);
        return $this->_bd->ejecutar($this->_sql);
    }
    public function getDeudasQ(){
        $sql = "Select e.codigo, sum(d.total) as deuda
            from estudiantes e LEFT JOIN deudas d ON e.id=d.id_estudiante
            where e.dni='$this->dni'
            group by e.codigo";
        $this->setSql($sql);
        return $this->_bd->ejecutar($this->_sql);
    }

    public function getPagoXNumero($pago){
       // $this->dni = ($dni==null)?$this->dni:$dni;

        $sql = "Select * from pagos where numero='$pago' and id_estudiante in 
            (Select id from $this->_tabla where dni='$this->dni')";
        $this->setSql($sql);
        return $this->_bd->ejecutar($this->_sql);
    }
}