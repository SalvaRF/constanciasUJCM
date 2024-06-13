<?php
require_once "ManejadorBDInterface.php";

class MySQL implements ManejadorBDInterface
{
   # private $_driver;
    private $_host, $_user, $_pass, $_database, $_charset;
    private $_conexion;

    public function __construct() {
        $this->_host="localhost";
        $this->_user="root";
        $this->_pass="";
        $this->_database="bdconstancias";
        $this->_charset="utf8";
    }
     
    public function conectar(){
        
        $this->_conexion =new mysqli(
            $this->_host, 
            $this->_user, 
            $this->_pass, 
            $this->_database);

        $this->_conexion->query("SET NAMES '".$this->_charset."'");
        
       
    }
    public function desconectar(){
        mysqli_close($this->_conexion);
    }

    public function traerDatos(SQL $sql){

        mysqli_report (MYSQLI_REPORT_OFF);
        
        if (!is_object($this->_conexion))
            return array('data'=>null,'msg'=>$this->_getMsg('Error MySQL', 'Conexión con la BD',1,'traerDatos(44)'));
        $retorno = null; 
        $msg=$this->_getMsg();
        
        $data=null; $sentencia=null;

        $sentencia= strtoupper($sql->getComando()); #Primera PALABRA del comando

        if (!($resultado = $this->_conexion->query($sql))){
            $retorno= array(
                'data'=>null, 
                'msg'=> $this->_getMsg('Error MySQL', 
                                'MySQL Dice: '.$this->_conexion->error),1,'TraerDatos (50)');
        }else{
            if (is_object($resultado)){ #Si devuelve un SELECT
                if($resultado->num_rows==0){
                    /*$retorno=array($data=null, 
                        $this->_getMsg($sentencia, 'No se Encontraron Datos',0,'TraerDatos (55)'));
                        */
                    $data = null;
                    $msg = $this->_getMsg($sentencia, 'No se Encontraron Datos',0,'TraerDatos (55)');
                } else
                    while ($row = mysqli_fetch_assoc($resultado)) 
                        $data[] = $row;
            } else # En caso de otra operación (INSERT/UPDATE/DELETE)
                $msg = $this->_getMsg($sentencia, 'Sentencia realizada correctamente',0,'traerDatos (60)');
            $retorno= array('data'=>$data, 
                            'msg'=> $msg );
        }
        return $retorno;
    }

    private function _getMsg($titulo='',$cuerpo=null,$estado=0,$metodo='Desconocido')     {
        return array(
                'titulo'=>strtoupper($titulo) , 
                'cuerpo'=>$cuerpo,
                'estado'=>$estado,
                'metodo'=>$metodo
            );
    }
     
}
?>
