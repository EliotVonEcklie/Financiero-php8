<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'Permisos_movimientos.php');
require_once (INTERFACE_PATH.'PermisosMovimientosInterface.php');
require_once (ROOT_PATH.'conexion.php');

class PermisoMovimientoControllers implements PermisosMovimientosInterface
{
    protected $cedulaUsuario = 0;
    public $permisos = '';
    public $mensaje = '';
    public function __construct($user)
    {
        $this->cedulaUsuario = $user;
    }
    public function getPermisos()
    {
        $this->permisos = Permisos_movimientos::where("usuario",$this->cedulaUsuario)->first(['estado']);
    }
    public function setMensaje()
    {
        $this->mensaje = "No tiene permisos para trabajar en este documento.";
    }
}
