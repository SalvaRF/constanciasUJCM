<?php
date_default_timezone_set('America/Lima');
require_once './assets/helper/Helper.php';
require_once './core/Controlador.php';

class CtrlConstancia extends Controlador{
    public function index(){
        $home = $this->show('constanciaNoAdeudo.php',null,true);
        $datos = array(
            'page'=>'Constancia No adeudo',
            'contenido'=>$home
        );

        $this->show('template.php',$datos); 
    }
    public function q(){    // Consulta por DNI

        $dni = $_POST['txt'];
        // echo "Consultado para $dni";
        require_once './models/Estudiante.php';
        $obj = new Estudiante($dni);
        $deudas = $obj->getDeudasQ()['data'];

        if ($deudas == null){
            $datos = [
                'mensaje'=>"No se detectó el estudiente con DNI: <b>$dni</b>"
            ];
            $home = $this->show('sinConstancia.php',$datos,true);
        }else {
            $datos = [
                'deudas'=>$deudas
            ];
            $home = $this->show('plantilla/home01.php',$datos,true);
        }
        $datos = [
            'page'=>'búsqueda',
            'contenido'=>$home,
            // 'mensaje'=>"Se ha detectado DEUDAS para el DNI: $dni!!!"

        ];
        $this->show('template.php',$datos); 
        exit();
        


    }
    public function nuevo(){
        // echo "Solicitando datos";
        $tipo = isset($_GET['t'])?$_GET['t']:'1';
        $data = [
            'tipo'=>$tipo
        ];
        $this->show('constancia/form.php',$data);
    }
    private function getDataEntidad(){
        require_once './models/Entidad.php';
        $entidad = (new Entidad)->get();
         if ($entidad==null)
            return false;

        return $entidad[0];
    }
    private function getDeudas($obj,$cod,$dni){
        $deudas = $obj->getDeudas()['data'];

        if ($deudas != null) {
            // echo "El estudiante TIENE DEUDAS!!!";
            $monto=0;
            foreach ($deudas as $d) {
                $monto += $d['total'];
            }
            $datos = [
                'deuda'=>number_format($monto,2),
                'cod'=>substr($cod, -2),
                'mensaje'=>"Se ha detectado DEUDAS por <b>S/ ". number_format($monto,2)."</b> para el DNI: <b> $dni</b>!!!<br>
                    correspondientes a deudas, moras, intereses..."
            ];
            $home = $this->show('sinConstancia.php',$datos,true);
            $datos = [
                'page'=>'Sin Constancia',
                'contenido'=>$home,
                // 'mensaje'=>"Se ha detectado DEUDAS para el DNI: $dni!!!"

            ];
            $this->show('template.php',$datos); 
            exit();
        }
        return $deudas;
    }
    private function getPagos($obj,$recibo){
        $pagos = $obj->getPagoXNumero($recibo)['data'];

        if ($pagos==null) {
            // echo "El estudiante TIENE DEUDAS!!!";
           
            $datos = [
                'deuda'=>number_format(0,2),
                'cod'=>'**',
                'mensaje'=>"No se detectó el pago: $recibo, <br> revisa tu Número de Voucher!!!"
            ];
            $home = $this->show('sinConstancia.php',$datos,true);
            $datos = [
                'page'=>'Sin Constancia',
                'contenido'=>$home,
                // 'mensaje'=>"Se ha detectado DEUDAS para el DNI: $dni!!!"

            ];
            $this->show('template.php',$datos); 
            exit();
        }
        return $pagos;
    }
    private function getEstudiante($dni){
        require_once './models/Estudiante.php';
        $obj = new Estudiante($dni);
        $estudiante = $obj->getXDNI()['data'];

        if ($estudiante==null) {
            // echo "El estudiante TIENE DEUDAS!!!";
            
            $datos = [
                
                'mensaje'=>"No se detectó el estudiente con DNI: <b>$dni</b> "
            ];
            $home = $this->show('sinConstancia.php',$datos,true);
            $datos = [
                'page'=>'Sin Constancia',
                'contenido'=>$home,
                // 'mensaje'=>"Se ha detectado DEUDAS para el DNI: $dni!!!"

            ];
            $this->show('template.php',$datos); 
            exit();
        }

        return $estudiante[0];
    }
    public function getConstancia(){

        // var_dump($entidad);exit;
        
        $tipo = isset($_POST['t'])?$_POST['t']:'1'; // Por defecto Generamos Constancias Económicas
        $dni = isset($_POST['dni'])?$_POST['dni']:null; // DNI
        $recibo = isset($_POST['recibo'])?($_POST['recibo']):'';
        

        require_once './models/Constancia.php';
        $obj = new Constancia();
        $constancia = $obj->getConstanciaXDniRecibo($dni,$recibo);

        if ($constancia != null){   // Se encontró una Constancia para ese recibo
            $nombreFileWeb = $constancia[0]['url'];
            $tipo = $constancia[0]['id_tipo'];
            // Mostramos y terminamos
            $this->mostrarConstancia($nombreFileWeb,$tipo);

            exit();

        }
        /* 
        if ($dni==null)
            return false; */
        // RECUPERAMOS EL SIGUIENTE NUMERO DE CONSTANCIA
        $numero = $obj->siguienteNro()['numero'];
    
        $entidad = $this->getDataEntidad();

        require_once './models/Estudiante.php';
        $obj = new Estudiante($dni);

        $estudiante= $this->getEstudiante($dni);

        $pago = $this->getPagos($obj, $recibo); // $obj->getPagoXNumero($recibo)['data'];

        // var_dump($pago);exit;
        
        $deudas = $this->getDeudas($obj,$estudiante['codigo'],$dni);
        // $deudas = $this->getDeudas($estudiante['codigo'],$dni);
        // $fecha = $this->getFecha();
       // $numero= 'C-0001';
       // $fecha = $this->getFecha();
       $fecha = Helper::getFecha();

        
        
        // $url= "https://www.ujcm.edu.pe/cert/pfs/".$numero.".pdf";

        $url= "./pdfs/$numero.pdf";

        // Guardamos los datos de la constancia en la BD
        $this->guardarConstancia($numero,date('Y-m-d'),$estudiante['semestre']
                ,$url,$recibo,$estudiante['id'],$tipo
            );
        // GENERAMOS EL PDF
        switch ($tipo) {
            case 2:
                # code...
                $data = [
            
                        'anio'=>$entidad['anio'],
                        'nombre'=>$estudiante['apepaterno'] . ' '.$estudiante['apematerno'].', '.$estudiante['nombres'],
                        'carrera'=>$estudiante['carrera'],
                        'facultad'=>$estudiante['facultad'],
                        'semestre'=>$estudiante['semestre'],
                        'codigo'=>$estudiante['codigo'],
                        'dni'=>$estudiante['dni'],
                        'sede'=>$estudiante['sede'],
                        'recibo'=>$recibo,
                        'numero'=>$numero,
                        'fecha'=> $fecha['hoy'],
                        'fechaHoy'=> $fecha['hoyDia'],
                        'validez'=>$fecha['vence']
                ];

                $this->generarPDFNoAdeudo($entidad, $data,$tipo);
                break;
            
            default:
                # code...
                $data = [
            
                        'anio'=>$entidad['anio'],
                        'nombre'=>$estudiante['nombres'] . ' ' .$estudiante['apepaterno'] . ' '.$estudiante['apematerno'],
                        'carrera'=>$estudiante['carrera'],
                        'facultad'=>$estudiante['facultad'],
                        'semestre'=>$estudiante['semestre'],
                        'codigo'=>$estudiante['codigo'],
                        'dni'=>$estudiante['dni'],
                        'sede'=>$estudiante['sede'],
                        'recibo'=>$recibo,
                        'numero'=>$numero,
                        'fecha'=> $fecha['hoy'],
                        'validez'=>$fecha['vence']
                ];

                $this->generarPDFEconomica($entidad, $data,$tipo);
                break;
        }

        
    }
    private function generarPDFEconomica($entidad, $data,$tipo){
        // $this->show('plantilla/c_economica.php',$data);
        require_once './models/MyPDFEconomica.php';
        $pdf = new MyPDFEconomica($entidad['nombre'],$entidad['telefono'],$entidad['direccion']);
        
        
        /* $pdf->Image('./tools/images/ujcm.png', 25, 10, 15, 15, 'PNG');
        $pdf->Image('./tools/images/eco_finanza_UJCM.jpg', 180, 10, 15, 15, 'JPG'); */
        $pdf->setY(30);

        $html= $this->show('plantilla/c_economica.php',$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');

        $posY = $pdf->getY()+5;
        $pdf->setY($posY);
        $numero = $data['numero'];
        $txt= "./pdfs/$numero.pdf";
        
        $pdf->addCode2D($txt);
        $pdf->addQR($txt,80,$posY);

        $nombre= $data['numero'];

        $nombreFile = __DIR__ . "/../pdfs/$nombre.pdf";

        $nombreFileWeb = "./pdfs/$nombre.pdf";
        
        // $txt = "https://www.ujcm.edu.pe/cert/pfs/".$data['numero'].".pdf";
        $txt = $nombreFileWeb;
        // var_dump($nombreFile); exit;

        $pdf->Output($nombreFile, 'F');
        
        $this->mostrarConstancia($nombreFileWeb,$tipo);
    }
    private function generarPDFNoAdeudo($entidad, $data,$tipo){
        // $this->show('plantilla/c_economica.php',$data);
        require_once './models/MyPDFNoAdeudo.php';
        $pdf = new MyPDFNoAdeudo($entidad['nombre'],$entidad['telefono'],$entidad['direccion']);
        
        
        /* $pdf->Image('./tools/images/ujcm.png', 25, 10, 15, 15, 'PNG');
        $pdf->Image('./tools/images/eco_finanza_UJCM.jpg', 180, 10, 15, 15, 'JPG'); */
        $pdf->setY(30);
        $pdf->SetFont('helvetica', '', 8);

        $html= $this->show('plantilla/c_noAdeudo.php',$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');

        $posY = $pdf->getY()+5;
        $pdf->setY($posY);
        $numero = $data['numero'];
        $txt= "./pdfs/$numero.pdf";
        
        $pdf->addCode2D($txt);
        $pdf->addQR($txt,80,$posY);

        $nombre= $data['numero'];

        $nombreFile = __DIR__ . "/../pdfs/$nombre.pdf";

        $nombreFileWeb = "./pdfs/$nombre.pdf";
        
        $pdf->firma();

        $pdf->Output($nombreFile, 'F');
        
        $this->mostrarConstancia($nombreFileWeb,$tipo);
    }
    private function mostrarConstancia($nombreFileWeb,$tipo){
        $datos = [
            'fileName'=>$nombreFileWeb
        ];
        // exit;
        switch ($tipo) {
            case '1':
                # code...
                $home = $this->show('constanciaEconomica.php',$datos,true);
                $page='Constancia Económica';
                break;
            
            default:
                # code...
                $home = $this->show('constanciaNoAdeudo.php',$datos,true);
                $page='Constancia No adeudo';
                break;
        }
        // var_dump($page); exit;
        $datos = array(
            'page'=>$page,
            'contenido'=>$home,
            
        );

        $this->show('template.php',$datos); 
    }
    /* private function getFecha(){
        $meses= [
            'enero','febrero','marzo','abril','mayo','junio','julio','agosto','setiembre','octubre','noviembre','diciembre'
        ];

        $zona = new DateTimeZone("America/Lima");
        $fecha = date_create("now",$zona);
        $hoy = $fecha;
        $dia = $hoy->format('d');
        $mes = $meses[$hoy->format('n')-1];
        $anio = $hoy->format('Y');

        $vence = $fecha->add(DateInterval::createFromDateString('3 months'));

        $miFecha = [
            'hoy'=>"Moguegua, $dia de $mes del $anio",
            'vence'=>$vence->format('d/m/Y')
        ];

        return $miFecha;
        
    } */
    private function guardarConstancia($numero,$fecha,$semestre,$url,$recibo,$idEstudiante,$idTipo){
        /** Guardando la constancia generada */
        require_once './models/Constancia.php';
        $obj = new Constancia();
        $respuesta = $obj->guardar($numero,$fecha,$semestre,$url,$recibo,$idEstudiante,$idTipo);

    }
}