<?php
abstract class Helper {
    static public function getFecha($mesesVence=3){
        $meses= [
            'enero','febrero','marzo','abril','mayo','junio','julio','agosto','setiembre','octubre','noviembre','diciembre'
        ];

        $zona = new DateTimeZone("America/Lima");
        $fecha = date_create("now",$zona);
        $hoy = $fecha;
        $dia = $hoy->format('d');
        $mes = $meses[$hoy->format('n')-1];
        $anio = $hoy->format('Y');

        $vence = $fecha->add(DateInterval::createFromDateString("$mesesVence months"));

        $miFecha = [
            'hoy'=>"Moguegua, $dia de $mes del $anio",
            'vence'=>$vence->format('d/m/Y'),
            'hoyDia'=>$hoy->format('d/m/Y')
        ];

        return $miFecha;
        
    }
}