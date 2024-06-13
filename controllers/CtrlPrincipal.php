<?php
require_once './core/Controlador.php';

class CtrlPrincipal extends Controlador{
    public function index(){

        // echo "Saludos desde " .__CLASS__;
        $home = $this->show('plantilla/home01.php',null,true);
        $datos = array(
            'page'=>'Panel Principal',
            'contenido'=>$home
        );

        $this->show('template.php',$datos); 
       
    }
    public function getConstancia(){
        $tipo = isset($_GET['t'])?$_GET['t']:'1'; // Po defecto Generamos Constancias Económicas
        switch ($tipo) {
            case '1':
                # code...
                $home = $this->show('constanciaNoAdeudo.php',null,true);
                $page='Constancia No adeudo';
                break;
            
            default:
                # code...
                $home = $this->show('constanciaEconomica.php',null,true);
                $page='Constancia Económica';
                break;
        }
        
        $datos = array(
            'page'=>$page,
            'contenido'=>$home
        );

        $this->show('template.php',$datos); 
    }

}