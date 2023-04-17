<?php
// echo PieEstados($connection);
function Estado_Procesos($connMysql)
{
    $FiltroActivo = FiltroActivo();

    $SQL  = "SELECT *   FROM IMSeguimientoOperativo WHERE $FiltroActivo   ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $TotaPorArribar = 0;
    if ($stmt->rowCount() > 0) {
        $Colores                = array('#8dbf42', '#1b55e2', '#2196f3', '#e7515a', '#e2a03f');
        $TotaPorArribar         = 0;
        $EnProcesoDeAduana      = 0;
        $ProcesoDespacho        = 0;
        $EnProcesoDeFacturacion = 0;
        $OrosProceos            = 0;
        $SinArribar             = 0;
        $Atiempo                = 0;
        $FueraDeTiempo          = 0;
        $FueraTiempoFact          = 0;
        $TotaZonaFranca         = 0;
        $SinEstado              = 0;
        $TotaPorArribarZF         = 0;
        $EnProcesoDeAduanaZF      = 0;
        $ProcesoDespachoZF        = 0;
        $EnProcesoDeFacturacionZF = 0;
        $OrosProceosZF            = 0;
        foreach ($result as $row) {
            if ($row['GrupoOperacion'] == 0) {
                switch (ReturnNameGrupo($row['EstadoCalculado'])) {
                    case 'Por Arribar':
                        $TotaPorArribar += 1;
                        break;
                    case 'En Proceso de Aduana':
                        $EnProcesoDeAduana += 1;
                        break;
                    case 'Proceso de Despacho y Pasar a Facturar':
                        $ProcesoDespacho += 1;
                        break;
                    case 'En proceso de Facturación':
                        $EnProcesoDeFacturacion += 1;
                        break;
                    case 'Otros Procesos':
                        $OrosProceos += 1;
                        break;
                    case 'Revisar Info Para Determinar Estado':
                        $SinEstado += 1;
                        break;
                }
                switch ($row['RangoEstado']) {
                    case 'MenorAMenos5':
                    case 'Menos1aMenos5':
                        $SinArribar += 1;
                        break;
                    case 'De0a4':
                        $Atiempo += 1;
                        break;
                    case 'De5a10':
                    case 'De11a15':
                    case 'De16a20':
                    case 'Mayora20':
                        switch (ReturnNameGrupo($row['EstadoCalculado'])) {
                            case 'Por Arribar':
                            case 'En Proceso de Aduana':
                            case 'Proceso de Despacho y Pasar a Facturar':
                            case 'Otros Procesos':
                            case 'Revisar Info Para Determinar Estado':
                                $FueraDeTiempo += 1;
                                break;
                            case 'En proceso de Facturación':
                                $FueraTiempoFact += 1;
                                break;
                        }
                }
            } else if ($row['GrupoOperacion'] == 1) {
                $TotaZonaFranca += 1;
                switch (ReturnNameGrupo($row['EstadoCalculado'])) {
                    case 'Por Arribar':
                        $TotaPorArribarZF += 1;
                        break;
                    case 'En Proceso de Aduana':
                        $EnProcesoDeAduanaZF += 1;
                        break;
                    case 'Proceso de Despacho y Pasar a Facturar':
                        $ProcesoDespachoZF += 1;
                        break;
                    case 'En proceso de Facturación':
                        $EnProcesoDeFacturacionZF += 1;
                        break;
                    case 'Otros Procesos':
                    case 'Revisar Info Para Determinar Estado':
                        $OrosProceosZF += 1;
                        break;
                }
            }
        }
        $Valores = array(
            $TotaPorArribar . ' Por Arribar '                            => $TotaPorArribar,
            $EnProcesoDeAduana . ' En Proceso de Aduana'                 => $EnProcesoDeAduana,
            $ProcesoDespacho . ' Proceso de Despacho y Pasar a Facturar' => $ProcesoDespacho,
            $EnProcesoDeFacturacion . ' En proceso de Facturación'       => $EnProcesoDeFacturacion,
            $TotaZonaFranca . ' Zona Franca'                             => $TotaZonaFranca,
            $OrosProceos . ' Otros Procesos'                             => $OrosProceos,
        );
        $TotalProcesos = $TotaPorArribar + $EnProcesoDeAduana + $ProcesoDespacho + $EnProcesoDeFacturacion + $OrosProceos + $TotaZonaFranca + $SinEstado ;
    }
    $data                             = array();
    $data['TotaPorArribar']           = $TotaPorArribar;
    $data['EnProcesoDeAduana']        = $EnProcesoDeAduana;
    $data['ProcesoDespacho']          = $ProcesoDespacho;
    $data['EnProcesoDeFacturacion']   = $EnProcesoDeFacturacion;
    $data['TotaZonaFranca']           = $TotaZonaFranca;
    $data['OrosProceos']              = $OrosProceos + $SinEstado;
    $data['labels']                   = array_keys($Valores);
    $data['datosLabel']               = array_values($Valores);
    $data['ColoresDataSet1']          = $Colores;
    $data['TotalProcesos']            = $TotalProcesos;
    $data['SQL']                      = $SQL;
    $data['SinArribar']               = $SinArribar;
    $data['Atiempo']                  = $Atiempo;
    $data['FueraDeTiempo']            = $FueraDeTiempo;
    $data['FueraTiempoFact']            = $FueraTiempoFact;
    $data['TotaZonaFranca']           = $TotaZonaFranca;
    $data['SinEstado']                = $SinEstado;
    $data['RolID']                    = $_SESSION['RolID'];
    $data['TotaPorArribarZF']         = $TotaPorArribarZF;
    $data['EnProcesoDeAduanaZF']      = $EnProcesoDeAduanaZF;
    $data['ProcesoDespachoZF']        = $ProcesoDespachoZF;
    $data['EnProcesoDeFacturacionZF'] = $EnProcesoDeFacturacionZF;
    $data['OrosProceosZF']            = $OrosProceosZF;



    $data['TablaTotalProcesos']       = GeneraTablaEstados("$FiltroActivo  AND GrupoOperacion = 0", $connMysql);

    $data['TablaFueraTiempo'] = GeneraTablaEstados("$FiltroActivo  AND RangoEstado in ('De5a10','De11a15','De16a20','Mayora20')  AND  GrupoOperacion = 0 AND EstadoAgrupado NOT LIKE 'En proceso de Facturación'", $connMysql);

    $data['TablaFueraTiempoFact'] = GeneraTablaEstados("$FiltroActivo  AND RangoEstado in ('De5a10','De11a15','De16a20','Mayora20')  AND  GrupoOperacion = 0 AND  EstadoAgrupado = 'En proceso de Facturación'", $connMysql);

    $data['TablaATiempo'] = GeneraTablaEstados("$FiltroActivo AND RangoEstado in ('De0a4') AND GrupoOperacion = 0 ", $connMysql);

    $data['TablaASinArribar'] = GeneraTablaEstados("$FiltroActivo AND RangoEstado in ('MenorAMenos5','Menos1aMenos5') AND GrupoOperacion = 0", $connMysql);

    $data['TablaZonaFranca'] = GeneraTablaEstados("$FiltroActivo  AND GrupoOperacion = 1", $connMysql);

    $data['TablaZFFueraTiempo'] = GeneraTablaEstados("$FiltroActivo  AND RangoEstado in ('De5a10','De11a15','De16a20','Mayora20')  AND  GrupoOperacion = 1", $connMysql);

    $data['TablaZFATiempo'] = GeneraTablaEstados("$FiltroActivo AND RangoEstado in ('De0a4') AND GrupoOperacion = 1 ", $connMysql);

    $data['TablaZFSinArribar'] = GeneraTablaEstados("$FiltroActivo AND RangoEstado in ('MenorAMenos5','Menos1aMenos5') AND GrupoOperacion = 1", $connMysql);

    $data['TablaDetalle'] = GeneraTablaEstados($FiltroActivo, $connMysql);

    $data['TablaSinEstado'] = GeneraTablaEstados("$FiltroActivo  AND GrupoOperacion = 0 AND EstadoCalculado ='RevisarInfoParaDeterminarEstado'", $connMysql);

    $data['TablaSinArribar'] = GeneraTablaEstados("$FiltroActivo  AND GrupoOperacion = 0 AND EstadoCalculado IN ('PendienteArribo','PendArriboEndigita','PendArriboAcept','PendArriboSinDocTransp','DtaSinArribar')", $connMysql);

    $data['TablaEnprocesoAduana'] = GeneraTablaEstados("$FiltroActivo  AND GrupoOperacion = 0 AND EstadoCalculado IN ('DtaEtaVencidoSinDSP','PendienteActulizarManifiesto','AnticipadaConETAVencido','ArriboHoySinPasarADigitar','ArriboHoyEnDigitacion','EnElaboracionDIM','DIMVisadaSinAceptar','ConManifSinIngresoDeposito','EnEsperaIntruccionCliente','EnDepositoSinPasarDigitar','EnAceptacionSinLevante')", $connMysql);

    $data['TablaEnDespachoPaFact'] = GeneraTablaEstados("$FiltroActivo  AND GrupoOperacion = 0 AND EstadoCalculado IN ('DtaConDSPSinFAC','ConLevanteSinDSP','ConDSPSinEnvioFact')", $connMysql);

    $data['TablaEnProcFact'] = GeneraTablaEstados("$FiltroActivo  AND GrupoOperacion = 0 AND EstadoCalculado IN ('DtaSinGeneraFAC','EnviadaFactSinFacturar','DevueltaPorContabilidad','DevolucionFacturacion')", $connMysql);

    $data['TablaOtrosProcesos'] = GeneraTablaEstados("$FiltroActivo  AND GrupoOperacion = 0 AND EstadoCalculado IN ('GastoPostSinFacturar','EntregaUrgenteTotal','FinalizacionEntregaUrgente','Eta1900','RevisarInfoParaDeterminarEstado')", $connMysql);

    return json_encode($data);
}
function GeneraTablaEstados($FiltroActivo, $connMysql)
{

    $SQL  = "SELECT  DISTINCT EstadoCalculado,OrdenEstado FROM IMSeguimientoOperativo WHERE $FiltroActivo ORDER BY OrdenEstado ASC  ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $html   = '';
    if ($stmt->rowCount() > 0) {

        $html .= '   <div class="col-xl-12 layout-spacing">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-condensed mb-4">
            <thead>
                <tr>
                    <th class="text-center">ESTADO  DIAS</th>
                    <th class="text-center"> < - 5 </th>
                    <th class="text-center">> -1 A - 5 </th>
                    <th class="text-center">DE 0 A 4 </th>
                    <th class="text-center">DE 5 A 10</th>
                    <th class="text-center">DE 11 A 15 </th>
                    <th class="text-center">DE 16 A 20</th>
                    <th class="text-center">> 20</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($result as $row) {
            $ClassTitila = '';
            if (strlen($row['EstadoCalculado']) > 0) {
                $DataCount = ReturnValuesRango($FiltroActivo, $row['EstadoCalculado'], $connMysql);
                if ($DataCount['MenorAMenos5'] > 0) {
                    $backgroundMenorAMenos5 = '#2EC218';
                } else {
                    $backgroundMenorAMenos5 = '';
                }
                if ($DataCount['Menos1aMenos5'] > 0) {
                    $backgroundMenos1aMenos5 = '#54C249';
                } else {
                    $backgroundMenos1aMenos5 = '';
                }
                if ($DataCount['De0a4'] > 0) {
                    $backgroundDe0a4 = '#BCDB1E';
                } else {
                    $backgroundDe0a4 = '';
                }
                if ($DataCount['De5a10'] > 0) {
                    $backgroundDe5a10 = '#EB413E';
                } else {
                    $backgroundDe5a10 = '';
                }
                if ($DataCount['De11a15'] > 0) {
                    $backgroundDe11a15 = '#EB2828';
                } else {
                    $backgroundDe11a15 = '';
                }
                if ($DataCount['De16a20'] > 0) {
                    $backgroundDe16a20 = '#EB1D1D';
                } else {
                    $backgroundDe16a20 = '';
                }
                if ($DataCount['Mayora20'] > 0) {
                    $backgroundMayora20 = '#EB0101';
                } else {
                    $backgroundMayora20 = '';
                }
                if ($DataCount['De5a10'] > 0 || $DataCount['De11a15'] > 0 || $DataCount['De16a20'] > 0 || $DataCount['Mayora20'] > 0) {
                    $icon = '<span class="ti-alert text-danger"></span>';
                } else if ($DataCount['De0a4'] > 0) {
                    $icon = '<span class="ti-time text-warning"></span>';
                } else {
                    $icon = '<span class="ti-check-box text-success"></span>';
                }
                $html .= '<tr>
        <td class="text-center"><a href="javascript:void(0);" data-campo="TotalFila" data-estado="' . $row['EstadoCalculado'] . '" data-titulo="' . DetectarNombreEstado($row['EstadoCalculado']) . '"  id="' . $FiltroActivo . '" class="BtnSearchDO text-TitleTable" data-campo="EstadoCalculado">' . DetectarNombreEstado($row['EstadoCalculado']) . '  ' . $icon . '</a></td>
        <td bgcolor="' . $backgroundMenorAMenos5 . '"  class="text-center text-ValuesTable"><a href="javascript:void(0);"   data-estado="' . $row['EstadoCalculado'] . '" data-titulo="' . DetectarNombreEstado($row['EstadoCalculado']) . '"   data-campo="RangoEstado"  id="MenorAMenos5" class="BtnSearchDO  text-ValuesTable">' . $DataCount['MenorAMenos5'] . '</a></td>
        <td bgcolor="' . $backgroundMenos1aMenos5 . '"  class="text-center text-ValuesTable"><a href="javascript:void(0);"  data-estado="' . $row['EstadoCalculado'] . '" data-titulo="' . DetectarNombreEstado($row['EstadoCalculado']) . '"   data-campo="RangoEstado"  id="Menos1aMenos5" class="BtnSearchDO text-ValuesTable">' . $DataCount['Menos1aMenos5'] . '</a></td>
        <td bgcolor="' . $backgroundDe0a4 . '"  class="text-center text-ValuesTable"><a href="javascript:void(0);"  data-estado="' . $row['EstadoCalculado'] . '" data-titulo="' . DetectarNombreEstado($row['EstadoCalculado']) . '"   data-campo="RangoEstado"  id="De0a4" class="BtnSearchDO  text-ValuesTable">' . $DataCount['De0a4'] . '</a></td>
        <td  bgcolor="' . $backgroundDe5a10 . '"   class="text-center text-ValuesTable"><a href="javascript:void(0);"  data-estado="' . $row['EstadoCalculado'] . '" data-titulo="' . DetectarNombreEstado($row['EstadoCalculado']) . '"  data-campo="RangoEstado"  id="De5a10" class="BtnSearchDO text-ValuesTable">' . $DataCount['De5a10'] . '</a></td>
        <td  bgcolor="' . $backgroundDe11a15 . '"   class="text-center text-ValuesTable"><a href="javascript:void(0);"   data-estado="' . $row['EstadoCalculado'] . '" data-titulo="' . DetectarNombreEstado($row['EstadoCalculado']) . '" data-campo="RangoEstado"  id="De11a15" class="BtnSearchDO text-ValuesTable">' . $DataCount['De11a15'] . '</a></td>
        <td  bgcolor="' . $backgroundDe16a20 . '"  class="text-center text-ValuesTable"><a href="javascript:void(0);"   data-estado="' . $row['EstadoCalculado'] . '" data-titulo="' . DetectarNombreEstado($row['EstadoCalculado']) . '" data-campo="RangoEstado"  id="De16a20" class="BtnSearchDO text-ValuesTable">' . $DataCount['De16a20'] . '</a></td>
        <td  bgcolor="' . $backgroundMayora20 . '"   class="text-center text-ValuesTable"><a href="javascript:void(0);"  data-estado="' . $row['EstadoCalculado'] . '" data-titulo="' . DetectarNombreEstado($row['EstadoCalculado']) . '"  data-campo="RangoEstado"  id="Mayora20" class="BtnSearchDO text-ValuesTable">' . $DataCount['Mayora20'] . '</a></td>
        <td   class="text-center text-ValuesTable">' . $DataCount['Total'] . '</td>
    </tr>';
            }
        }
        $html .= '</tbody>
</table>


</div></div>';
    } else {
        $html .= '<div align="center" class="col-xl-12 layout-spacing"><div class="alert alert-outline-danger mb-4" role="alert"> <i class="flaticon-cancel-12 close text-ValuesTable" data-dismiss="alert"></i> <strong>Sin resultados!</strong>No existen procesos en este filtro </div> </div>';
    }
    return $html;
}
function ReturnValuesRango($FiltroActivo, $Valor, $connMysql)
{

    $SQL  = "  SELECT RangoEstado FROM IMSeguimientoOperativo WHERE $FiltroActivo AND  EstadoCalculado = '$Valor'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $TotalRefeTax = 0;
    if ($stmt->rowCount() > 0) {
        $MenorAMenos5  = 0;
        $Menos1aMenos5 = 0;
        $De0a4         = 0;
        $De5a10        = 0;
        $De11a15       = 0;
        $De16a20       = 0;
        $Mayora20      = 0;
        $data          = array();
        foreach ($result as $row) {
            switch ($row['RangoEstado']) {
                case 'MenorAMenos5':
                    $MenorAMenos5 += 1;
                    break;
                case 'Menos1aMenos5':
                    $Menos1aMenos5 += 1;
                    break;
                case 'De0a4':
                    $De0a4 += 1;
                    break;
                case 'De5a10':
                    $De5a10 += 1;
                    break;
                case 'De11a15':
                    $De11a15 += 1;
                    break;
                case 'De16a20':
                    $De16a20 += 1;
                    break;
                case 'Mayora20':
                    $Mayora20 += 1;
                    break;
            }
        }
    } else {
        $MenorAMenos5  = 0;
        $Menos1aMenos5 = 0;
        $De0a4         = 0;
        $De5a10        = 0;
        $De11a15       = 0;
        $De16a20       = 0;
        $Mayora20      = 0;
        $Total         = 0;
    }
    $data['MenorAMenos5']  = $MenorAMenos5;
    $data['Menos1aMenos5'] = $Menos1aMenos5;
    $data['De0a4']         = $De0a4;
    $data['De5a10']        = $De5a10;
    $data['De11a15']       = $De11a15;
    $data['De16a20']       = $De16a20;
    $data['Mayora20']      = $Mayora20;
    $data['Total']         = $MenorAMenos5 + $Menos1aMenos5 + $De0a4 + $De5a10 + $De11a15 + $De16a20 + $Mayora20;
    return $data;
}

function DetectarRangoDias($Dias)
{
    echo $Dias . '<br>';
    if ($Dias < -5) {
        return 'MenorAMenos5';
    } else if ($Dias <= -1 && $Dias >= -5) {
        return 'Menos1aMenos5';
    } else if ($Dias >= 0 && $Dias <= 4) {
        return 'De0a4';
    } else if ($Dias >= 5 && $Dias <= 10) {
        return 'De5a10';
    } else if ($Dias >= 11 && $Dias <= 15) {
        return 'De11a15';
    } else if ($Dias >= 16 && $Dias <= 20) {
        return 'De16a20';
    } else if ($Dias > 20) {
        return 'Mayora20';
    } else {
        'Error';
    }
}
