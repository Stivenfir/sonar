<?php

session_start();
require_once 'seguridad.php';
require __DIR__ . '/classes/Excelinsert/vendor/autoload.php';
require_once "config/definidas.php";
require_once "config/conndb.php";
require_once "classes/class_MySQL.php";
require_once "classes/class_MsSQL.php";
require_once "classes/festivos.php";
require_once "func_filtro/func_filtro.php";
require_once "func_filtro/func_filtro_pies.php";
require_once "func_dashboard/b_estado_procesos.php";
require_once "func_dashboard/d_kpis.php";
require_once "func_dashboard/d_kpis_conf.php";
require_once "func_dashboard/e_historico.php";
require_once "func_dashboard/f_mails.php";
require_once "func_dashboard/g_export_data.php";
require_once "func_login/func_login.php";
require_once "func_cron/func_cron.php";
require_once "func_dashboard/c_detalle_operaciones.php";
$connMysql = connMysql();
// ExportarFile($connMysql);
//
// CopyHistorico();
if (isset($argv[0]) && isset($argv[1])) {
    $Argumento = $argv[1];
    switch ($Argumento) {
        case 'CopyDataDeTracking':
            $DataCron = ValidaCronTab($connMysql, $Argumento);
            $TareaValida = $DataCron['estado'];
            $IdProceso = $DataCron['ID'];
            $arrayHours = ['21:20', '00:30', '03:30', '06:30', '09:30', '12:30', '15:30', '18:30'];
            echo $horaActual = date('H:i');
            if ($TareaValida == 0 && in_array($horaActual, $arrayHours)) {
                $param = 'ID > 0';
                if (CopyDataDeTracking($IdProceso) == 1) {
                    CalcularData($param);
                    InsertarHistorico();
                    CalcularDatosAdicionales();
                    SincronizarTerminalesDepositos();
                    SincronizarCorreosPersonal();
                }
            } else {
                echo 'Hora no Valida O tarea en ejecución' . PHP_EOL;
            }
            break;
        case 'CronValidarKPI':
            $DataCron = ValidaCronTab($connMysql, $Argumento);
            $TareaValida = $DataCron['estado'];
            $IdProceso = $DataCron['ID'];
            if ($TareaValida == 0) {
                CronValidarKPI($connMysql, $IdProceso);
            }
            break;
        case 'CopyDataDeTrackingSinHora':
            $DataCron = ValidaCronTab($connMysql, 'CopyDataDeTracking');
            echo 'CopyDataDeTracking Ejecutandose';
            $TareaValida = $DataCron['estado'];
            $IdProceso = $DataCron['ID'];
            CopyDataDeTracking($IdProceso);
            break;
        case 'CopyHistorico':
            CopyHistorico();
            break;
        case 'CalcularDatosAdicionales':
            CalcularDatosAdicionales();
            break;
        case 'InsertarHistorico':
            InsertarHistorico();
            break;
        case 'CalcularDatos':
            $param = 'ID > 0';
            CalcularData($param);
            InsertarHistorico();
            CalcularDatosAdicionales();
            SincronizarTerminalesDepositos();
            SincronizarCorreosPersonal();

            break;
    }
    return;
}
if (!isset($_SESSION['UsuarioLogueado'])) {
    $PostMethod = $_POST['PostMethod'];
    switch ($PostMethod) {
        ######### login  #############
        case 'LoginFunc':

            echo LoginFunc();
            break;

        ######### login #############
        default:
            echo '<font color="RED">la session se cerró por favor actualice esta ventana ctrl+r o f5</font>';
            break;
    }
} else {
    if (isset($_POST['PostMethod'])) {
        $PostMethod = $_POST['PostMethod'];
        $connMysql = connMysql();
        // $connMysqlPilot  = connMSSQL(2);
        // $connMysqlProduc = connMSSQL(3);
        switch ($PostMethod) {
            ######### login  #############
            case 'LoginFunc':

                echo LoginFunc();
                break;
            case 'ShowMessagesAdmin':

                $DataCron = ValidaCronTab($connMysql, 'CopyDataDeTracking');
                $TareaValida = $DataCron['estado'];
                if ($TareaValida != 0) {
                    echo '<h3 class="text-success">El sistema esta actualizando información de Tracking</h3> <p class="text-primary">puede que no vea toda su información</p>';
                } else {
                    echo ShowMessagesAdmin($connMysql);
                }
                break;

            ######### FILTROS #############
            case 'ValidarUserLog':
                echo ValidarUserLog();
                break;
            case 'SelectDirectores':

                echo SelectDirectores($connMysql);
                break;
            case 'SelectJefeCuenta':

                echo SelectJefeCuenta($connMysql);
                break;
            case 'SelectCoordinador':

                echo SelectCoordinador($connMysql);
                break;
            case 'SelectCliente':

                echo SelectCliente($connMysql);
                break;
            case 'GenerarSessionFiltro':
                echo GenerarSessionFiltro($connMysql);
                break;

            case 'MenuFiltroActivo':
                echo MenuFiltroActivo($connMysql);
                break;
            case 'BucadorDeTexto':
                echo BucadorDeTexto($connMysql);
                break;
            case 'SeleccionarItemSearch':
                echo SeleccionarItemSearch($connMysql);
                break;
            case 'BorrarFiltro':
                echo BorrarFiltro();
                break;
            case 'RemoveListBtn':
                echo RemoveListBtn();
                break;

            ######## SELECCION Y ACTUALIZACIÓN DE DO ###########

            case 'DetalleDO':
                echo DetalleDO($connMysql);
                RegistrarActividad('Consulta DO');
                break;

            case 'SelectDO':
                echo SelectDO($connMysql);
                break;
            case 'SelectoresDepTerminal':
                echo SelectoresDepTerminal($connMysql);
                break;
            case 'ActualizarDOS':
                echo ActualizarDOS($connMysql);
                RegistrarActividad('Actualiza DO');
                break;
            case 'ExportarFile':
                echo ExportarFile($connMysql);
                RegistrarActividad('Exportar archivos');
                break;

            ######## SELECCION Y ACTUALIZACIÓN DE DO ###########

            case 'KpisGenerales':
                echo KpisGenerales($connMysql);
                break;
            case 'FechaTablero':
                echo FechaTablero($connMysql);
                break;

            ######### GRAFICAS #########
            case 'Estado_Procesos':

                echo Estado_Procesos($connMysql);
                RegistrarActividad('Vista Principal');

                break;
            case 'HistoricoChart':

                echo HistoricoChart($connMysql);
                break;
            case 'CargaLaboraUsuarios':

                echo CargaLaboraUsuarios($connMysql);
                break;
            case 'CargaClientes':

                echo CargaClientes($connMysql);
                break;

            ######### GRAFICAS #########
            ########## KPIS #########

            case 'KpisGenerales':
                echo KpisGenerales($connMysql);
                break;
            case 'KpisUsuarios':
                echo KpisUsuarios($connMysql);
                break;
            case 'ListaDetalleKPI':
                echo ListaDetalleKPI($connMysql);
                break;
            case 'SelectorClientes':
                echo SelectorClientes($connMysql);
                break;
            case 'SelectorFechasKpis':
                echo SelectorFechasKpis($connMysql);
                break;
            case 'PruebaLogicaKpi':
                echo PruebaLogicaKpi($connMysql);
                break;
            case 'GuardarFormKPI':
                echo GuardarFormKPI($connMysql);
                break;
            case 'TableKpis':
                echo TableKpis($connMysql);
                break;
            case 'GetDataKpi':
                echo GetDataKpi($connMysql);
                break;
            case 'SelectorInstruccion':
                echo SelectorInstruccion($connMysql);
                break;
            case 'DescargarExcelKPI':
                echo DescargarExcelKPI($connMysql);
                break;

            case 'GetListaKpis':
                echo GetListaKpis($connMysql);
                break;
            case 'GetGraficaDetalles':
                echo GetGraficaDetalles($connMysql);
                break;

            ######### Envio Notif#######
            case 'GetLastMessage':

                echo GetLastMessage($connMysql);
                break;

            case 'SelectDoMail':

                echo SelectDoMail($connMysql);
                break;
            case 'SelectAllDo':

                echo SelectAllDo($connMysql);
                break;

            case 'SendNotifysDO':

                echo SendNotifysDO($connMysql);
                RegistrarActividad('Enviar Notificaciones');
                break;

            case 'DowloadAnalitics':
                echo DowloadAnalitics($connMysql);
                RegistrarActividad('Exportar archivos');
                break;

            case 'SelectEstados':
                echo SelectEstados($connMysql);
                break;
            case 'GeneraCierreDiario':
                echo GeneraCierreDiario($connMysql);
                RegistrarActividad('Generar cierre diario');
                break;

            default:
                return 500;
                break;
        }
    } else {
        return 500;
    }
}

function ValidaCronTab($connMysql, $Argumento)
{
    $SQL = "SELECT * FROM abc_cron_control.tbl_cron  WHERE argumento ='$Argumento';";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Cantidad = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $timeActual = time();
    $timeTarea = $row['time'];
    $timeTranscurrido = $timeActual - $timeTarea;
    if ($timeTranscurrido > 1800) {
        $row['estado'] = 0;
    }
    return $row;
}
