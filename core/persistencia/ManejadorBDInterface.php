<?php
interface ManejadorBDInterface
{
    public function conectar();

    public function desconectar();

    public function traerDatos(SQL $sql);
}