<?php
/**
 * Vista.php
 * Clase que recupera la vista a mostrar
 */
abstract class Vista {
    static function show($vista, $datos='', $comoContenido=FALSE) {
        $archivoVista= "./views/". $vista;
        if (file_exists($archivoVista) == FALSE) {
                trigger_error ('Plantilla ' . $archivoVista . ' no Existe.', E_USER_NOTICE);
                return FALSE;
        }
        if (is_array($datos)) 
            foreach ($datos as $key => $value) 
                $$key = $value;

        if ($comoContenido) { //Si devolvemos el contenido a una variable
            ob_start();  // activamos el BUFFER de salida
            echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", 
                    str_replace('<?=', '<?php echo ', file_get_contents($archivoVista)
                    )));
            $buffer = ob_get_contents();
            @ob_end_clean();
            return $buffer;
        } else           //Si devolvemos la vista
            require_once $archivoVista;  
    }
}
