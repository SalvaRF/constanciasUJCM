<?php
abstract class Index
{
    public static function ejecutar(){
        $miControlador = isset ($_GET['ctrl'])?$_GET['ctrl']:'CtrlPrincipal';
        $accion = isset($_REQUEST['accion'])?$_REQUEST['accion']:'index';

        $fileControlador = './controllers/'.$miControlador.'.php';

        if (file_exists($fileControlador) == false) {     // Si no existe el CONTROLADOR
                trigger_error ('El Controlador ' . $fileControlador . ' no Existe.', E_USER_NOTICE);
                return false;
        }

        require_once $fileControlador;

        eval ( '$controlador= new '.$miControlador.'();' );

        if(! method_exists($controlador,$accion)){
            trigger_error ('En el Controlador: '.$miControlador. ' no existe la acción: ' . $accion , E_USER_NOTICE);
            return false;
        }    
        // Asociamos la acción al Controlador
        $metodo = array($controlador, $accion);

        if(! is_callable($metodo,false)) {    //Verificamos que se pueda llamar al método
            trigger_error ('No puedo ejecutar la acción: ' . $accion . ' revisa.', E_USER_NOTICE);
            return false;
        }
        eval ( '$controlador->' . $accion . '();' );
        
    }
}

Index::ejecutar();