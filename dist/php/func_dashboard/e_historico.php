<?php

function HistoricoChart($connMysql)
{
    $FechaHoy        = date('Y-m-d');
    $Fecha8DiasAtras = strtotime('-5 day', strtotime($FechaHoy));
    $Fecha8DiasAtras = date('Y-m-d', $Fecha8DiasAtras);
    $data            = array();
    $FiltroActivo    = FiltroActivo('NoActive');
    $SQL             = "SELECT FechaRegistro,GrupoOperacion,GrupoEstado FROM abc_so.tabc_so_historicosegope WHERE $FiltroActivo AND FechaRegistro BETWEEN '$Fecha8DiasAtras'AND '$FechaHoy' ";
    $stmt            = $connMysql->prepare($SQL);
    $stmt->execute();
    $Cantidad   = $stmt->rowCount();
    $DataFechas = array();

    $dias   = array("dom", "lun", "mar", "mié", "jue", "vier", "sáb");
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        $FechaFull    = date('Y-m-d', strtotime($row['FechaRegistro']));
        $FechaDiaText = date('w', strtotime($row['FechaRegistro']));
        $FechaDia     = date('d', strtotime($row['FechaRegistro']));
        $FechaText    = $dias[$FechaDiaText] . '-' . $FechaDia;
        if ($FechaFull == $FechaHoy) {
            $FechaFull = 'Hoy';
        }
        array_push($DataFechas, $FechaFull);
    }
    $FechasUnicas       = array_unique($DataFechas);
    $ValoresOperaciones = array();

    $DiasOperaciones = count($FechasUnicas);
    if ($DiasOperaciones > 0) {
        $PromedioDiario = $Cantidad / $DiasOperaciones;
    } else {
        $PromedioDiario = $Cantidad / 1;
    }
  
    $Fechas                = array();
    $Colores               = array();
    $ColoresPorArribar     = array();
    $ColoresEnADauana      = array();
    $ColoresEnDespacho     = array();
    $ColoresEnFactura      = array();
    $ColoresZonaFranca     = array();
    $ColoresOtrosProcesos  = array();
    $PorArribar            = array();
    $EnADauana             = array();
    $EnDespacho            = array();
    $EnFactura             = array();
    $ZonaFranca            = array();
    $OtrosProcesos         = array();
    $ColoresLevantes1      = array();
    $ColoresLevantes2      = array();
    $TotalLevantes         = array();
    $ColoresTotalProcesos1 = array();
    $ColoresTotalProcesos2 = array();
    $TotalProcesos         = array();
    $Promedio         = array();
    foreach ($FechasUnicas as $rowFecha) {

        array_push($Fechas, $rowFecha);
        array_push($ColoresPorArribar, '#2EC218');
        array_push($ColoresEnADauana, '#1B55E2');
        array_push($ColoresEnDespacho, '#2196F3');
        array_push($ColoresEnFactura, '#E7515A');
        array_push($ColoresZonaFranca, '#E2A03F');
        array_push($ColoresOtrosProcesos, '#E95F2B');
        array_push($ColoresLevantes1, '#C2D5FF');
        array_push($ColoresLevantes2, '#C2D5FF');

        array_push($ColoresTotalProcesos1, '#FFF');
        array_push($ColoresTotalProcesos2, '#C2D5FF');
        $DataFechas = ValidarCantidades($connMysql, $rowFecha, $PromedioDiario);

        array_push($PorArribar, $DataFechas['PorArribar']);
        array_push($EnADauana, $DataFechas['EnADauana']);
        array_push($EnDespacho, $DataFechas['EnDespacho']);
        array_push($EnFactura, $DataFechas['EnFactura']);
        array_push($ZonaFranca, $DataFechas['ZonaFranca']);
        array_push($OtrosProcesos, $DataFechas['OtrosProcesos']);
        array_push($TotalProcesos, $DataFechas['TotalProcesos']);
        $Levantes = ValidarLevantes($connMysql, $rowFecha);
        array_push($TotalLevantes, $Levantes);
     
        
     
    }
    $PromedioDiario = round($PromedioDiario, 0, PHP_ROUND_HALF_UP); 
    $FirsDay           = MesSpanish(FirsDay());
    $Hoy               = MesSpanish($FechaHoy);
    $diasAgo           = MesSpanish($Fecha8DiasAtras);
    $hmtlFechas        = '';
    $hmtlTotalProcesos = '';
    foreach ($Fechas as $fechaROW) {
        $hmtlFechas .= '<th  class="text-center">' . $fechaROW . '</th>';
    }
    foreach ($TotalProcesos as $TotalProcesosROW) {
        $hmtlTotalProcesos .= '<td  class="text-center"><h5 class="text-primary">' . $TotalProcesosROW . '</h5></td>';
    }

    $data['labels']            = $Fechas;
    $data['hmtlFechas']        = $hmtlFechas;
    $data['hmtlTotalProcesos'] = $hmtlTotalProcesos;
    $data['TotalProcesos'] = $TotalProcesos;
    $data['TotalLevantes']    = $TotalLevantes;
    $data['ColoresLevantes1'] = $ColoresLevantes1;
    $data['ColoresLevantes2'] = $ColoresLevantes2;
    $data['Promedio'] = $PromedioDiario;
    $data['PorArribar']           = $PorArribar;
    $data['ColoresPorArribar']    = $ColoresPorArribar;
    $data['EnADauana']            = $EnADauana;
    $data['ColoresEnADauana']     = $ColoresEnADauana;
    $data['EnDespacho']           = $EnDespacho;
    $data['ColoresEnDespacho']    = $ColoresEnDespacho;
    $data['EnFactura']            = $EnFactura;
    $data['ColoresEnFactura']     = $ColoresEnFactura;
    $data['ZonaFranca']           = $ZonaFranca;
    $data['ColoresZonaFranca']    = $ColoresZonaFranca;
    $data['OtrosProcesos']        = $OtrosProcesos;
    $data['ColoresOtrosProcesos'] = $ColoresOtrosProcesos;


    $data['MesActual'] = $diasAgo . ' A ' . $Hoy;
    $data['RangoKPI']  = $FirsDay . ' A ' . $Hoy;
    return json_encode($data);
}

function ValidarCantidades($connMysql, $Fecha, $PromedioDiario)
{

    $data         = array();
    $FiltroActivo = FiltroActivo('NoActive');

    if ($Fecha == 'Hoy') {
        $Fecha = date('Y-m-d');
    }
    $SQL  = "SELECT FechaRegistro,GrupoOperacion,GrupoEstado FROM abc_so.tabc_so_historicosegope WHERE $FiltroActivo AND FechaRegistro = '$Fecha'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Cantidad      = $stmt->rowCount();
    $result        = $stmt->fetchAll();
    $PorArribar    = 0;
    $EnADauana     = 0;
    $EnDespacho    = 0;
    $EnFactura     = 0;
    $OtrosProcesos = 0;
    $ZonaFranca    = 0;
    foreach ($result as $row) {

        if ($row['GrupoOperacion'] == 0) {
            switch ($row['GrupoEstado']) {
                case 'Por Arribar':
                    $PorArribar += 1;
                    break;
                case 'En Proceso de Aduana':
                    $EnADauana += 1;
                    break;

                case 'Proceso de Despacho y Pasar a Facturar':
                    $EnDespacho += 1;
                    break;
                case 'En proceso de Facturación':
                    $EnFactura += 1;
                    break;
                default:
                    $OtrosProcesos += 1;
                    break;
            }
        } else {
            $ZonaFranca += 1;
        }
    }
    $data['Promedio']    = $PromedioDiario;
    $data['PorArribar']    = $PorArribar;
    $data['EnADauana']     = $EnADauana;
    $data['EnDespacho']    = $EnDespacho;
    $data['EnFactura']     = $EnFactura;
    $data['OtrosProcesos'] = $OtrosProcesos;
    $data['ZonaFranca']    = $ZonaFranca;
    $data['TotalProcesos'] = $PorArribar + $EnADauana + $EnDespacho + $EnFactura + $OtrosProcesos + $ZonaFranca;
    return $data;
}

function ValidarLevantes($connMysql, $Fecha)
{

    $data         = array();
    $FiltroActivo = FiltroActivo('RemoveTablero');
    $Fecha1       = $Fecha . ' 00:00:00';
    $Fecha2       = $Fecha . ' 23:59:59';
    if ($Fecha == 'Hoy') {
        $Fecha1 = date('Y-m-d 00:00:00');
        $Fecha2 = date('Y-m-d 23:59:59');
    }
    $SQL  = "SELECT DeclImpoFechaLevante FROM tabc_hist_levantes WHERE $FiltroActivo AND DeclImpoFechaLevante BETWEEN '$Fecha1' AND '$Fecha2'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Cantidad = $stmt->rowCount();
    return $Cantidad;
}
