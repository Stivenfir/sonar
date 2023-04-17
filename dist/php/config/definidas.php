<?php
define('EstadoProyecto', 2); //1= Desarrollo 2=Piloto 3 =Produccioón
define('ONEMINUTE', 60);
function CalcularDias($fechaInicial, $fechaFinal)
{
    $date1 = new DateTime($fechaInicial);
    $date2 = new DateTime($fechaFinal);
    $diff  = $date1->diff($date2);
    return ($diff->invert == 1) ? '-' . $diff->days : $diff->days;
}
function ConvertFecha($Fecha)
{
    $FechaResult = date('Y-m-d', strtotime($Fecha));
    if (strlen($Fecha) > 0) {
        if ($FechaResult == '1969-12-31') {
            return '';
        } else {
            return $FechaResult;
        }
    } else {
        return '';
    }
}

function DetectarNombreEstado($estadoSearch)
{

    $DataArray = array(
        'PendienteArribo' => 'Pendiente Arribo',
        'PendArriboEndigita'                 => 'Pendiente Arribo - En digitación',
        'PendArriboAcept'                    => 'Pendiente Arribo - Aceptada',
        'PendArriboSinDocTransp'             => 'Pendiente Arribo - Sin documento de Transpote',
        'DtaSinArribar'                      => 'DTA Sin Arribar',
        'DtaEtaVencidoSinDSP'                => 'DTA con ETA vencido sin despacho',
        'PendienteActulizarManifiesto'       => 'Pendiente Actualizar Manifiesto',
        'AnticipadaConETAVencido'            => 'Anticipada con ETA Vencido',
        'ArriboHoySinPasarADigitar'          => 'Arribo Hoy Sin Pasar a Digitar',
        'ArriboHoyEnDigitacion'              => 'Arribo Hoy en Digitacion',
        'EnElaboracionDIM'                   => 'En Elaboracion DIM',
        'DIMVisadaSinAceptar'                => 'DIM Visada sin Aceptar',
        'ConManifSinIngresoDeposito'         => 'Con Manifiesto Sin Ingreso Deposito',
        'EnDepositoSinPasarDigitar'          => 'En Deposito Sin Pasar a Digitar',
        'EnAceptacionSinLevante'             => 'En Aceptacion y Pagos Sin Levante',
        'DtaConDSPSinFAC'                    => 'DTA Despachado sin pasar a Facturar',
        'ConLevanteSinDSP'                   => 'Con Levante Sin Despacho',
        'ConDSPSinEnvioFact'                 => 'Con Despacho sin Envio Facturacion',
        'DtaSinGeneraFAC'                    => 'DTA Sin generar factura',
        'EnviadaFactSinFacturar'             => 'Enviada Facturacion Sin Facturar',
        'DevueltaPorContabilidad'            => 'Devuelta por Contabilidad',
        'DevolucionFacturacion'              => 'Devolución a Facturación',
        'GastoPostSinFacturar'               => 'Gasto Posterior sin Enviar Facturacion',
        'EntregaUrgenteTotal'                => 'Entrega Urgente Total',
        'FinalizacionEntregaUrgente'         => 'Finalización Urgente Total',
        'Eta1900'                            => 'Eta1900',
        'RevisarInfoParaDeterminarEstado'    => 'Revisar Info Para Determinar Estado',
        'EnEsperaIntruccionCliente'          => 'En Espera Instrucción Cliente',
        ''                                   => '',
    );
    return $DataArray[$estadoSearch];
}
function ReturnNameGrupo($estadoSearch)
{
    $FulllData = array(
        'PendienteArribo'                 => 'Por Arribar',
        'PendArriboEndigita'              => 'Por Arribar',
        'PendArriboAcept'                 => 'Por Arribar',
        'PendArriboSinDocTransp'          => 'Por Arribar',
        'DtaSinArribar'                   => 'Por Arribar',
        'DtaEtaVencidoSinDSP'             => 'En Proceso de Aduana',
        'PendienteActulizarManifiesto'    => 'En Proceso de Aduana',
        'AnticipadaConETAVencido'         => 'En Proceso de Aduana',
        'ArriboHoySinPasarADigitar'       => 'En Proceso de Aduana',
        'ArriboHoyEnDigitacion'           => 'En Proceso de Aduana',
        'EnElaboracionDIM'                => 'En Proceso de Aduana',
        'DIMVisadaSinAceptar'             => 'En Proceso de Aduana',
        'ConManifSinIngresoDeposito'      => 'En Proceso de Aduana',
        'EnEsperaIntruccionCliente'       => 'En Proceso de Aduana',
        'EnDepositoSinPasarDigitar'       => 'En Proceso de Aduana',
        'EnAceptacionSinLevante'          => 'En Proceso de Aduana',
        'DtaConDSPSinFAC'                 => 'Proceso de Despacho y Pasar a Facturar',
        'ConLevanteSinDSP'                => 'Proceso de Despacho y Pasar a Facturar',
        'ConDSPSinEnvioFact'              => 'Proceso de Despacho y Pasar a Facturar',
        'DtaSinGeneraFAC'                 => 'En proceso de Facturación',
        'EnviadaFactSinFacturar'          => 'En proceso de Facturación',
        'DevueltaPorContabilidad'         => 'En proceso de Facturación',
        'DevolucionFacturacion'           => 'En proceso de Facturación',
        'GastoPostSinFacturar'            => 'Otros Procesos',
        'EntregaUrgenteTotal'             => 'Otros Procesos',
        'FinalizacionEntregaUrgente'      => 'Otros Procesos',
        'Eta1900'                         => 'Otros Procesos',
        'RevisarInfoParaDeterminarEstado' => 'Revisar Info Para Determinar Estado',
        ''                                => '',
    );
    return $FulllData[$estadoSearch];
}

function ReparaCadenas($Cadena)
{
    if (strlen($Cadena) > 0) {
        $Cadena = str_replace(array('  ', ' ', 'PENDIENTE', 'PENDIENTE '), array('', '', '', ''), $Cadena);
    } else {
        $Cadena = $Cadena;
    }
    return $Cadena;
}
function CalcularDiasHabiles($fechaInicial, $fechaFinal, $Sabados = false, $Corridos = false)
{
    $festivos      = new Festivos();
    $date1         = new DateTime($fechaInicial);
    $date2         = new DateTime($fechaFinal);
    $diff          = $date1->diff($date2);
    $TotalDias     = ($diff->invert == 1) ? '-' . $diff->days : $diff->days;
    $RestarDias    = 1;
    $fechaaamostar = $fechaInicial;
    while (strtotime($fechaFinal) >= strtotime($fechaInicial)) {
        if (strtotime($fechaFinal) != strtotime($fechaaamostar)) {
            $fechaaamostar = date("Y-m-d", strtotime($fechaaamostar . " + 1 day"));
            $DiaValidar    = strtotime($fechaaamostar);
            if ($festivos->esFestivo(date('d', $DiaValidar), date('m', $DiaValidar))) {
                $RestarDias += 1;
            } else {
                switch (date('l', $DiaValidar)) {
                    case "Saturday":
                        if ($Sabados == false) {
                            $RestarDias += 1;
                        }
                        break;
                    case "Sunday":
                        $RestarDias += 1;
                        break;
                }
            }
        } else {
            break;
        }
    }
    $TotalDias = ($TotalDias == -1) ? 0 : $TotalDias;
    if ($Corridos == false) {
        return $TotalDias - $RestarDias;
    } else {
        return $TotalDias;
    }
    
}
function ConvertFechaHour($Fecha)
{
    $FechaResult = date('Y-m-d', strtotime($Fecha));
    if ($FechaResult == '1969-12-31') {

        return '';
    } else {
        if ($Fecha == '') {
            return '';
        } else {
            return date('Y-m-d H:i', strtotime($Fecha));
        }
    }
}
function FechaTablero($connMysql)
{
    $ActivoEnTablero = LastActivoEnTablero($connMysql);
    $SQL  = "SELECT FechaActualizacion FROM IMSeguimientoOperativo   LIMIT 1 ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data       = array();
    $FechasHtml = '';
    $row        = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        return ConvertFechaHour($row['FechaActualizacion']);
    } else {
        return 'TABLERO SIN DATOS';
    }
}

function LastActivoEnTablero($connMysql)
{

    $SQL  = "SELECT * FROM IMSeguimientoOperativo  order by ID DESC ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data       = array();
    $FechasHtml = '';
    $row        = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row['ActivoEnTablero'];
}


function MesSpanish($fecha)
{
    $fecha     = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia       = date('l', strtotime($fecha));
    $mes       = date('F', strtotime($fecha));
    $anio      = date('Y', strtotime($fecha));
    $meses_ES  = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN  = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return utf8_decode($nombreMes) . '-' . $numeroDia;
}

function FirsDay()
{
    $month = date('m');
    $year  = date('Y');
    return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}

function ArreglaNombresForPie($Nombre)
{

    $NombreRows = explode(' ', str_replace('  ', ' ', $Nombre));

    if (count($NombreRows) > 3) {
        return $NombreRows[2] . ' ' . $NombreRows[0];
    } else if (count($NombreRows) == 3) {
        return $NombreRows[2] . ' ' . $NombreRows[0];
    } else if (count($NombreRows) == 2) {
        return $NombreRows[2] . ' ' . $NombreRows[0];
    } else if (count($NombreRows) == 1) {
        return $Nombre;
    }
}



function encrypt($string, $key)
{
    $result = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $char    = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char    = chr(ord($char) + ord($keychar));
        $result .= $char;
    }
    return base64_encode($result);
}

function decrypt($string, $key)
{
    $result = '';
    $string = base64_decode($string);
    for ($i = 0; $i < strlen($string); $i++) {
        $char    = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char    = chr(ord($char) - ord($keychar));
        $result .= $char;
    }
    return $result;
}


function TraductorTerminalDeposito($connMysql, $id_trk, $tipo = 'TP')
{

    $SQL  = "SELECT * FROM tabc_so_depositosterminales WHERE id_trk='$id_trk' AND Tipo='$tipo' LIMIT 1";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        return $row['Nombre'];
    } else {
        return 'NO IDENTIFICADO';
    }
}


function DataKpis($connMysql, $idKpi)
{
    // echo 1;
    $SQL  = "SELECT * FROM tabc_so_conf_kpi WHERE id='$idKpi' ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        return $row;
    } else {
        return false;
    }
}
