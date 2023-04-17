<?php
session_start();
require_once '../../dist/php/seguridad.php';

if (!isset($_SESSION['UsuarioLogueado'])) {
    header("location: ../login/salir.php");
} else {

    // $Path        = $_SERVER["REQUEST_URI"];
    // $rowsPaths   = explode('/', $Path);
    // $permisoPath = $rowsPaths[3];

    // switch ($_SESSION['perfil']) {
    //     case '1':
    //         $Permisos = array('crear_tareas', 'usuarios', 'cargar_base', 'pagos', 'asesor', 'gestiones', 'informe_gastos', 'ayuda');
    //         $redirect = 'gestiones';
    //         break;

    //     case '2':
    //         $Permisos = array('asesor', 'gestiones', 'ayuda');
    //         $redirect = 'gestiones';
    //         break;
    //     case '3':
    //         $Permisos = array('crear_tareas', 'usuarios', 'cargar_base', 'asesor', 'gestiones', 'ayuda');
    //         $redirect = 'gestiones';
    //         break;
    //     case '4':
    //         $Permisos = array('asesor', 'pagos');
    //         $redirect = 'gestiones';
    //         break;
    //     case '5':
    //         $Permisos = array('informe_gastos');
    //         $redirect = 'informe_gastos';
    //         break;

    // }

    // if (ValidarPermiso($permisoPath, $Permisos) == 0) {
    //     header("location: ../$redirect");
    // }

}

function ValidarPermiso($permisoPath, $Permisos)
{
    if (in_array($permisoPath, $Permisos)) {
        return 1;
    } else {
        return 0;
    }
}
