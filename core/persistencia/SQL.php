<?php
class SQL
{
    private $_tabla;
    private $_colWhere;
    private $_colDatos;

    private $_comando;
    private $sql = null;

    # private $_colOrden;
    
    public function __construct($tabla=null, $comando='SELECT'){
        $this->_tabla = $tabla;
        $this->_comando=$comando;
    }

    public function setTabla($tabla){
        $this->_tabla = $tabla;
    }
    public function getTabla(){
        return $this->_tabla;
    }
    public function setSQL($sql){
        $this->sql=$sql;
    }
    public function addWhere($wh){
        $this->_colWhere[]=$wh;
    }
    public function addDato($dato){
        $this->_colDatos[]=$dato;
    }
    public function setDatos(array $datos){
        $this->_colDatos = $datos;
    }

    public function getComando(){
        return $this->_comando;
    }
    private function _getCampos(){
        $retorno = "*";
        if (is_array($this->_colDatos))
            $retorno = implode (",",array_unique(array_keys($this->_colDatos)));
        return $retorno;
    } 
    private function _getWhere(){
        $retorno = "1=1";
        if (is_array($this->_colWhere))
            $retorno = implode (" AND ",array_unique(array_values($this->_colWhere)));
        return $retorno;
    } 

    public function getSELECT(){
        $retorno='SELECT ';
        $retorno.= $this->_getCampos();
        $retorno.= ' FROM '. $this->_tabla;
        $retorno.=' WHERE '. $this->_getWhere();
        return $retorno;
    }
    public function setComando($comando){
        $this->_comando = strtoupper ($comando);
    }

    private function getINSERT(){
        $retorno = null;
        if (is_array($this->_colDatos)){
            $campos = implode (",",array_keys($this->_colDatos));
            $valores = implode (",", array_values($this->_colDatos));

            $retorno="INSERT INTO $this->_tabla";
            $retorno.= "( $campos )";
            $retorno.= " VALUES ( $valores )" ;
        }
        
        return $retorno;
    }
    private function getKeyValor($separador=","){
        foreach ($this->_colDatos as $key => $value) 
                $datos[]= "`$key`=$value";
            
        return implode ($separador, array_unique(array_values($datos)));
    }
    private function getUPDATE(){
        if (is_array($this->_colDatos))
            $datos = $this->getKeyValor();
        
        $retorno="UPDATE $this->_tabla";
        $retorno.= " SET  $datos ";
        $retorno.= " WHERE ".$this->_getWhere() ;
        return $retorno;
    }
    private function getDELETE(){
        $retorno="DELETE FROM $this->_tabla";
        $retorno.= " WHERE ".$this->_getWhere();
        return $retorno;
    }

    public function __toString(){
        $retorno=null;
        if ($this->sql!=null){
            $retorno= $this->sql;
            $this->sql = null;    // Liberamos para la prox. vez
        }else
        switch ($this->_comando) {
            case 'INSERT':
                $retorno = $this->getINSERT();
                break;
            case 'UPDATE':
                $retorno = $this->getUPDATE();
                break;
            case 'DELETE':
                $retorno = $this->getDELETE();
                break;
            default:
                $retorno = $this->getSELECT();
                break;
        }
        
        return $retorno;
    }
}