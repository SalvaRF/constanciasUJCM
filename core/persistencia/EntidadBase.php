<?php
require_once "BaseDeDatos.php";
class EntidadBase
{
    private $_tabla;
    protected $_bd;
    private $_colColumnas;
    private $_colWhere;
    private $_colOrderBy;

    protected $_sql;
 
    public function __construct($tabla) {
        $this->_tabla=(string) $tabla;
        $this->_bd = new BaseDeDatos(new MySQL()); 
        $this->_sql = new SQL($this->_tabla);
    }

    public function setTabla($tabla){
        $this->_tabla = (string) $tabla;
    }
    public function setSql($sql){
        $this->_sql->setSQL($sql);
    }
    public function ejecutarSql(){
        return $this->_bd->ejecutar($this->_sql);
    }

    public function getAll(){
        $this->_sql->setTabla($this->_tabla);
        return $this->_bd->ejecutar($this->_sql);  
    }
     
    public function getById($id){
        $this->_sql->setTabla($this->_tabla);
        $this->_sql->addWhere("`id`=$id");
        return $this->_bd->ejecutar($this->_sql);
    }
     
    public function getBy($columna,$valor){
        $this->_sql->setTabla($this->_tabla);
        $this->_sql->addWhere("`$columna`='$valor'");
        return $this->_bd->ejecutar($this->_sql);
    }
     
    public function deleteById($id){
        $this->_sql->setTabla($this->_tabla);
        $this->_sql->addWhere("`id`=$id");
        $this->_sql->setComando("DELETE");
        # echo $this->_sql;exit;
        return $this->_bd->ejecutar($this->_sql);
    }
     
    public function deleteBy($columna,$valor){
        $this->_sql->setTabla($this->_tabla);
        $this->_sql->addWhere("`$columna`='$valor'");
        $this->_sql->setComando("DELETE");
        return $this->_bd->ejecutar($this->_sql);
    }
    public function update($wh, $datos){
        $this->_sql->setTabla($this->_tabla);
        $this->_sql->addWhere($wh);
        $this->_sql->setDatos($datos);
        $this->_sql->setComando("UPDATE");
        # echo $this->_sql;exit;
        return $this->_bd->ejecutar($this->_sql);
    }
    public function insert($datos){
        $this->_sql->setTabla($this->_tabla);
        $this->_sql->setDatos($datos);
        $this->_sql->setComando("INSERT");
        # echo $this->_sql;exit();
        return $this->_bd->ejecutar($this->_sql);
    } 
 
    /*
     * Aquí podemos montarnos un montón de métodos que nos ayuden
     * a hacer operaciones con la base de datos de la entidad
     */
     
}
?>
