<?php
function SelectorClientes($connMysql)
{

    $FiltroActivo = FiltroActivo();
    $SQL          = " SELECT DISTINCT ClienteID FROM IMSeguimientoOperativo WHERE $FiltroActivo ORDER BY Cliente ASC ";
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $TotalRefeTax = 0;
    if ($stmt->rowCount() > 0) {
        $html = '<option selected value="">Seleccione Cliente</option>';
        foreach ($result as $row) {
            $DataNombres = ReturnNombresSearch('ClienteID', $row['ClienteID'], $connMysql);
            $html .= '<option value="' . $row['ClienteID'] . '">' . $DataNombres['Cliente'] . '</option>';
        }
    } else {
        $html = '<option value="seleccione">No se encontraron Clientes.</option>';
    }
    return $html;
}

function SelectorFechasKpis($connMysql)
{

    $SQL  = " SELECT * FROM tabc_so_fechaskpis  ORDER BY id ASC ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $TotalRefeTax = 0;
    if ($stmt->rowCount() > 0) {
        $html = '<option selected value="">Seleccione fecha</option>';
        foreach ($result as $row) {

            $html .= '<option value="' . $row['CampoFecha'] . '">' . $row['TituloCampo'] . '</option>';
        }
    } else {
        $html = '<option selected value="">No se encontraron fechas.</option>';
    }
    return $html;
}

function SelectorInstruccion($connMysql)
{
    $ClienteID =  $_POST['ClienteID'];
    $SQL  = " SELECT DISTINCT Instruccion FROM imseguimientooperativo WHERE ClienteID ='$ClienteID '  ORDER BY Instruccion ASC ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $TotalRefeTax = 0;
    if ($stmt->rowCount() > 0) {
        $html = '<option selected value="">Seleccione instrucción</option>';
        $html .= '<option selected value="Todos">TODOS</option>';
        foreach ($result as $row) {

            $html .= '<option value="' . $row['Instruccion'] . '">' . strtoupper($row['Instruccion']) . '</option>';
        }
    } else {
        $html = '<option selected value="">No se encontraron instrucciones.</option>';
    }
    return $html;
}

function PruebaLogicaKpi($connMysql)
{
    $ResultadosCalculo = ResultadosKPI($connMysql);
    $data['html'] = $ResultadosCalculo;
    return json_encode($data);
    $html               = '<div class="col-md-12" align="center">';
    $NombreKPI          = $_POST['NombreKPI'];
    $SelectorClientes   = $_POST['SelectorClientes'];
    $FechaInicialKpi    = $_POST['FechaInicialKpi'];
    $FechaFinalKpi      = $_POST['FechaFinalKpi'];
    $TipoTransporte     = $_POST['TipoTransporte'];
    $TipoOperacion      = $_POST['TipoOperacion'];
    $DiasCalculo        = $_POST['DiasCalculo'];
    $TiempoMeta         = $_POST['TiempoMeta'];
    $PercKpi            = $_POST['PercKpi'];
    $RangoFechaInicialKpi = $_POST['RangoFechaInicialKpi'];
    $RangoFechaFinalKpi   = $_POST['RangoFechaFinalKpi'];

    $CalculaTiempo = CalculaTiempo($RangoFechaInicialKpi, $RangoFechaFinalKpi, $DiasCalculo);
    $HorasHabiles  = $CalculaTiempo['HorasHabiles'];
    $DiasTrans     = $CalculaTiempo['DiasTrans'];
    if ($DiasCalculo == 'HorasCorridas' || $DiasCalculo == 'HorasHabiles') {
        $TextTime  = 'Horas';
        $ValorTime = $HorasHabiles;
    } else {
        $TextTime  = 'Dias';
        $ValorTime = $DiasTrans;
    }

    $KpiCumple = ($ValorTime <= $TiempoMeta) ? '<span class="text-success"> Cumple KPI <i class="ti-thumb-up"></i></span>' : '<span class="text-danger">  NO Cumple KPI  <i class="ti-thumb-down"></span>';
    if ($HorasHabiles > -1 && $DiasTrans > -1) {
        $html .= '<h4 align="center"> La prueba lógica de este Kpi seria la siguiente:</h4>';
        $html .= '<h6><li>Campos de fecha a calcular <span class="text-danger">' . $FechaInicialKpi . ' y ' . $FechaFinalKpi . ' </span> </li></h6>';
        $html .= '<h6><li>Total de <span class="text-danger">' . $DiasCalculo . ' </span> entre las fechas de prueba: <span class="text-primary"><b>' . $ValorTime . ' ' . $TextTime . ' </b></span>   </li></h6>';
        $html .= '<h6><li>el tiempo minimo del KPI es de <span class="text-danger">' . $TiempoMeta . ' ' . $TextTime . '  </span>    </li></h6>';

        $html .= '<h3>' . $KpiCumple . '</h3>';
    } else {
        $html .= '<h4 align="center" class="text-warning"> La prueba lógica falló por que existen dias o horas negativos en el calculo:</h4>';
    }
    $html .= '</div>';
}

function CalculaTiempo($FechaInicialKpiPru, $FechaFinalKpiPru, $DiasCalculo)
{
    $DiasTrans    = 0;
    $HorasHabiles = 0;
    if ($DiasCalculo == 'HorasHabiles' || $DiasCalculo == 'HorasCorridas') {
    } else {
        $FechaInicialKpiPru = ConvertFecha($FechaInicialKpiPru);
        $FechaFinalKpiPru   = ConvertFecha($FechaFinalKpiPru);
    }
    switch ($DiasCalculo) {
        case 'Diascorridos':
            $DiasTrans = CalcularDiasHabiles($FechaInicialKpiPru, $FechaFinalKpiPru, false, true);
            break;
        case 'DiasHabiles':
            $DiasTrans = CalcularDiasHabiles($FechaInicialKpiPru, $FechaFinalKpiPru, false, false);
            break;
        case 'DiasHabilesConSaba':
            $DiasTrans = CalcularDiasHabiles($FechaInicialKpiPru, $FechaFinalKpiPru, true, false);
            break;
        case 'DiasHabilesConSaba':
            $DiasTrans = CalcularDiasHabiles($FechaInicialKpiPru, $FechaFinalKpiPru, true, false);
            break;
        case 'HorasCorridas':
            $HorasHabiles = ValidaHoras($FechaInicialKpiPru, $FechaFinalKpiPru, false);
            break;
        case 'HorasHabiles':
            $HorasHabiles = ValidaHoras($FechaInicialKpiPru, $FechaFinalKpiPru);
            break;
    }
    $data['DiasTrans']    = $DiasTrans + 1;
    $data['HorasHabiles'] = $HorasHabiles;
    return $data;
}

function ValidaHoras($fecha_sol, $fecha_menor, $HorasHabiles = true)
{
    $festivos = new Festivos();

    $MinutosRestar = 1;

    // ESTABLISH THE MINUTES PER DAY FROM START AND END TIMES
    $start_time = '07:30:00';
    $end_time   = '17:59:59';
    $workminutes = array();
    $start_ts        = strtotime($start_time);
    $end_ts          = strtotime($end_time);
    $minutes_per_day = (int) (($end_ts - $start_ts) / 60) + 1;
    $start           = strtotime($fecha_sol);
    $end             = strtotime($fecha_menor);
    $FechaIni        = strtotime($fecha_sol);
    $FechaFin        = strtotime($fecha_menor);
    $workdays        = array();
    if ($end > $start) {
        $start = $start - ONEMINUTE;
        while ($start < $end) {

            $start    = $start + ONEMINUTE;
            $iso_date = date('Y-m-d', $start);
            if ($HorasHabiles) {
                $weekday = date('D', $start);
                if (substr($weekday, 0, 1) == 'S') {
                    continue;
                }
                $daytime = date('H:i:s', $start);
                if (($daytime < date('H:i:s', $start_ts))) {
                    continue;
                }
                $daytime = date('H:i:s', $start);
                if (($daytime > date('H:i:s', $end_ts))) {
                    continue;
                }

                $DiaValidar = strtotime($iso_date);

                if ($festivos->esFestivo(date('d', $DiaValidar), date('m', $DiaValidar))) {
                    $MinutosRestar += 1;
                }
            }
            $workminutes[] = $iso_date;
        }

        if ($HorasHabiles) {
            $fecha_sol   = ConvertFecha($fecha_sol);
            $fecha_menor = ConvertFecha($fecha_menor);
            $DiasTrans   = CalcularDiasHabiles($fecha_sol, $fecha_menor, false, false) + 1;
            if (date('H', $FechaIni) < 12 && date('H', $FechaFin) < 12) {
                if (date('H-d', $FechaIni) == date('H-d', $FechaFin)) {
                    $MinutosRestarAlm = 0;
                } else {
                    $MinutosRestarAlm = 60 * $DiasTrans;
                }
            } else {
                $MinutosRestarAlm = 60 * $DiasTrans;
            }

            $number_of_workminutes = (count($workminutes)) - $MinutosRestar - $MinutosRestarAlm;
        } else {
            $number_of_workminutes = (count($workminutes)) - $MinutosRestar;
        }

        $horas_habiles = $number_of_workminutes / 60;
        $horas_habiles = (round($horas_habiles, 2) < 0) ? 0 : $horas_habiles;
        return $horas_habiles;
    } else {
        return 0;
    }
}

function GuardarFormKPI($connMysql)
{
    $FunctionsMySQL = new FunctionsMySQL();
    $DataArray      = array(
        'NombreKPI'            => $_POST['NombreKPI'],
        'ClienteID'            => $_POST['SelectorClientes'],
        'FechaInicialKpi' => $_POST['FechaInicialKpi'],
        'FechaFinalKpi'   => $_POST['FechaFinalKpi'],
        'TipoTransporte'       => $_POST['TipoTransporte'],
        'TipoOperacion'        => $_POST['TipoOperacion'],
        'DiasCalculo'          => $_POST['DiasCalculo'],
        'TiempoMeta'           => $_POST['TiempoMeta'],
        'PercKpi'              => $_POST['PercKpi'],
        'TipoKPI'              => $_POST['TipoKPI'],
        'creadoPor'            => $_SESSION['UserID'],
        'TipoInstruccion'      => $_POST['TipoInstruccion'],
        'RangoFechaInicialKpi' => $_POST['RangoFechaInicialKpi'],
        'RangoFechaFinalKpi'   => $_POST['RangoFechaFinalKpi'],
    );

    if ($_POST['TypePost'] == 'AgregarKpi') {
        $idRecord = $FunctionsMySQL->Insert($DataArray, 'tabc_so_conf_kpi', $connMysql);
    } else {
        $DataArray['ID'] = decrypt($_POST['idKPI'], "ALGUNDIAENCONTRARELACLAVEDEDECIFRADOPARAESTACADENA2021BRYANVILLA");
        $idRecord        = $FunctionsMySQL->Update($DataArray, 'tabc_so_conf_kpi', $connMysql);
        DeleteUpdateKpis($connMysql, $idRecord);
    }

    if ($idRecord > 0) {
        $data['status'] = 'Correcto';
        $data['idKPI']  = encrypt($idRecord, "ALGUNDIAENCONTRARELACLAVEDEDECIFRADOPARAESTACADENA2021BRYANVILLA");
    } else {
        $data['status'] = 'error';
        $data['idKPI']  = 'NA';
    }

    return json_encode($data);
}

function DeleteUpdateKpis($connMysql, $IdKpi)
{
    $FunctionsMySQL = new FunctionsMySQL();

    $SQL  = "SELECT *  FROM tabc_so_resultadoskpis  WHERE  IdKpi='$IdKpi' ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result        = $stmt->fetchAll();
    foreach ($result as $row) {

        $DataArrayLevante = array(
            'ID' => $row['IdLevante'],
            'KpiCalculado' => 0,
        );
        $FunctionsMySQL->Update($DataArrayLevante, 'tabc_hist_levantes', $connMysql);
    }

    $SQL2  = "DELETE FROM tabc_so_resultadoskpis WHERE  IdKpi='$IdKpi' ";
    $stmt2 = $connMysql->prepare($SQL2);
    $stmt2->execute();
}

function TableKpis($connMysql)
{
    $SQL  = "SELECT *  FROM tabc_so_conf_kpi ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $result        = $stmt->fetchAll();
    $data          = array();
    foreach ($result as $row) {
        $DataNombres = ReturnNombresSearch('ClienteID', $row['ClienteID'], $connMysql);
        $anidado     = array();
        $ID          = encrypt($row['ID'], "ALGUNDIAENCONTRARELACLAVEDEDECIFRADOPARAESTACADENA2021BRYANVILLA");
        //  $Saldo     = $row['MayorA121'] + $row['De120A90'] + $row['De89A60'] + $row['De59A30'] + $row['MenorA29'];
        $anidado[] = $row['NombreKPI'];
        $anidado[] = '<small>' . $DataNombres['Cliente'] . '</small>';
        $anidado[] = $row['FechaInicialKpi'] . ' y ' . $row['FechaFinalKpi'];
        $anidado[] = $row['TipoKPI'];
        $anidado[] = $row['TipoOperacion'];
        $anidado[] = $row['TipoTransporte'];
        $anidado[] = $row['DiasCalculo'];
        $anidado[] = $row['TiempoMeta'];
        $anidado[] = $row['PercKpi'];
        $anidado[] = '<td class="text-center">
                        <a href="javascript:void(0);" class="BtnKpi" data-id="' . $ID . '"  title="Editar"><h5><span class="text-primary ti-pencil-alt"></span></h5></a>


                </td>';

        $data[] = $anidado;
    }

    $json_data = array(
        "draw"            => intval(1),

        "recordsTotal"    => intval($CantidadTotal),

        "recordsFiltered" => intval($CantidadTotal),

        "data"            => $data,
        "sql"             => $SQL,
    );

    return json_encode($json_data);
}

function GetDataKpi($connMysql)
{
    $idKPI = decrypt($_POST['idKPI'], "ALGUNDIAENCONTRARELACLAVEDEDECIFRADOPARAESTACADENA2021BRYANVILLA");
    $SQL   = "SELECT *  FROM tabc_so_conf_kpi where ID = '$idKPI'  ";
    $stmt  = $connMysql->prepare($SQL);
    $stmt->execute();
    $row           = $stmt->fetch(PDO::FETCH_ASSOC);
    $CantidadTotal = $stmt->rowCount();
    $data['total']  = $CantidadTotal;
    $data['NombreKPI']        = $row['NombreKPI'];
    $data['SelectorClientes'] = $row['ClienteID'];
    $data['FechaInicialKpi']  = $row['FechaInicialKpi'];
    $data['FechaFinalKpi']    = $row['FechaFinalKpi'];
    $data['TipoKPI']          = $row['TipoKPI'];
    $data['TipoOperacion']    = $row['TipoOperacion'];
    $data['TipoTransporte']   = $row['TipoTransporte'];
    $data['DiasCalculo']      = $row['DiasCalculo'];
    $data['TiempoMeta']       = $row['TiempoMeta'];
    $data['PercKpi']          = $row['PercKpi'];

    return json_encode($data);
}


// ResultadosKPI
function ResultadosKPI($connMysql)
{
    $ClienteID   = $_POST['SelectorClientes'];
    $FechaInicialKpi    = $_POST['FechaInicialKpi'];
    $FechaFinalKpi      = $_POST['FechaFinalKpi'];
    $TipoTransporte     = $_POST['TipoTransporte'];
    $TipoOperacion      = $_POST['TipoOperacion'];
    $DiasCalculo        = $_POST['DiasCalculo'];
    $TiempoMeta         = $_POST['TiempoMeta'];
    $PercKpi            = $_POST['PercKpi'];
    $TipoInstruccion      = $_POST['TipoInstruccion'];
    $RangoFechaInicialKpi = $_POST['RangoFechaInicialKpi'];
    $RangoFechaFinalKpi   = $_POST['RangoFechaFinalKpi'];
    $LimiteDatos  = $_POST['LimiteDatos'];
    $DataCampos = array(
        'FechaInicialKpi' => $FechaInicialKpi,
        'FechaFinalKpi' => $FechaFinalKpi,
        'TipoTransporte' => $TipoTransporte,
        'TipoOperacion' => $TipoOperacion,
        'DiasCalculo' => $DiasCalculo,
        'TiempoMeta' => $TiempoMeta,
        'TipoInstruccion' => $TipoInstruccion,
        'PercKpi' => $PercKpi,
    );
    $html = '<div class="table-responsive">
    <h5  align="center"><b>Datos utilizados en la prueba</b></h5>
    <table class="table table-bordered table-hover table-striped mb-4">
        <thead>
            <tr>
                <th>DO</th>
                <th>' . ValidarNombreFechaCampo($connMysql, $FechaInicialKpi)  . '</th>
                <th>' . ValidarNombreFechaCampo($connMysql, $FechaFinalKpi)  . '</th>
                <th class="text-center">Dias calculados</th>
                <th class="text-center">Cumple KPI</th>
                
            </tr>
        </thead>
        <tbody>';
    $SQL          = " SELECT * FROM tabc_hist_levantes WHERE  ClienteID='$ClienteID' AND DeclImpoFechaLevante BETWEEN '$RangoFechaInicialKpi 00:00:00' AND '$RangoFechaFinalKpi 23:59:59' limit   $LimiteDatos ";
    // echo $SQL;
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $SumaKpi = 0;
    $TotalOperaciones = 0;
    if ($stmt->rowCount() > 0) {
        // echo '<pre>';
        // print_r($DataCampos);
        // echo '<pre>';
        // print_r($result);
        foreach ($result as $row) {
            // echo '<pre>';
            // var_dump(ValidacionCampos($DataCampos, $row));
            if (ValidacionCampos($DataCampos, $row)) {
                $TotalOperaciones++;
                $ResultadosCalculo = ResultadoCalculoKPI($row[$FechaInicialKpi], $row[$FechaFinalKpi]);
                $CumpleKPI = ($ResultadosCalculo['cumple'] == 1) ? '<span class="text-success">Cumple KPI</span>' : '<span class="text-danger">No Cumple</span>';
                $SumaKpi = $SumaKpi + $ResultadosCalculo['cumple'];
                $html .= '<tr>
                <td>' . $row['DocImpoNoDO'] . '</td>
                <td  align="center">' . $row[$FechaInicialKpi] . '</td>
                <td  align="center">' . $row[$FechaFinalKpi] . '</td>
                <td align="center">' . $ResultadosCalculo['calculo'] . ' ' . $ResultadosCalculo['TextTime'] . '</td>
                <td class="text-center">' . $CumpleKPI . '</td>
            </tr>';
            }
        }
        $html .= '</tbody></table></div>';
        if ($SumaKpi == 0) {
            $SumaKpi = 0;
        }
        if ($TotalOperaciones == 0) {
            $TotalOperaciones = 1;
            return $html = '';
        }

        $KPICalculado = round(($SumaKpi / $TotalOperaciones) * 100);
        if ($KPICalculado >= $PercKpi) {
            $ColorKpi = 'green';
        } else {
            $ColorKpi = 'danger titila';
        }
        $htmlKpi = '<div class="table-responsive"><div class="card" style="background-color:#C2D5FF" >
        <div class="card-header" id="headingOne1">
            <section class="mb-0 mt-0">
                <div class="collapsed" >
                    <div class="row">
                        <div class="mb-5 mt-5 col-xl-6 text-Kpis"><td><div align="center" class="text-Kpis">Resultados de la prueba, con datos de la operación </div></div>
                        <div class="mr-2" >
                            <p>Levantes</p>
                            <div class="c100 p100 med primary"   data-toggle="tooltip" data-original-title="Cantidad de procesos">
                                <span>' . $TotalOperaciones . '</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mr-2">
                            <p>' . $_POST['TipoKPI'] . '</p>
                            <div class=" c100 p' . $KPICalculado . ' med ' . $ColorKpi . '" >
                                <span>' . $KPICalculado . '%</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </section>
        </div>
    </div></div>';
        $html =  $htmlKpi . $html;
    } else {
        $html = '';
    }
    return   $html;
}


function ValidacionCampos($DataCampos, $DataValues)
{

    $ValidacionIns = false;
    $ValidacionTransporte = false;
    $ValidacionFechaInicialKpi = false;
    $ValidacionFechaFinalKpi = false;
    if ($DataCampos['TipoInstruccion'] == 'Todos') {
        $ValidacionIns = true;
    }
    if ($DataCampos['TipoInstruccion'] == $DataValues['Instruccion']) {
        $ValidacionIns = true;
    }

    if ($DataCampos['TipoTransporte'] == 'Todos') {
        $ValidacionTransporte = true;
    }
    if ($DataCampos['TipoTransporte'] == $DataValues['ModoTransporte']) {
        $ValidacionTransporte = true;
    }

    if (strlen($DataValues[$DataCampos['FechaInicialKpi']]) > 0) {
        $ValidacionFechaInicialKpi = true;
    }
    if (strlen($DataValues[$DataCampos['FechaFinalKpi']]) > 0) {
        $ValidacionFechaFinalKpi = true;
    }
    if ($ValidacionIns == true &&  $ValidacionTransporte == true &&  $ValidacionFechaInicialKpi == true &&  $ValidacionFechaFinalKpi == true) {

        return true;
    } else {
        return false;
    }
}

function ResultadoCalculoKPI($FechaInicialKpiPru, $FechaFinalKpiPru, $DataTipos = '')
{
    // EL POST TIENE LOS NOMBRES DE LOS CAMPOS
    // $FechaInicialKpiPru = $_POST['FechaInicialKpi'];
    // $FechaFinalKpiPru   = $_POST['FechaFinalKpi'];

    if (isset($_POST['DiasCalculo'])) {
        $TipoCalculo        = $_POST['DiasCalculo'];
    } else {
        $TipoCalculo        = $DataTipos['DiasCalculo'];
    }
    if (isset($_POST['TiempoMeta'])) {
        $MetaCalculo        = $_POST['TiempoMeta'];
    } else {
        $MetaCalculo        = $DataTipos['TiempoMeta'];
    }
    $Cumple             = -1;
    $CalculaTiempo = CalculaTiempo($FechaInicialKpiPru, $FechaFinalKpiPru, $TipoCalculo);
    $HorasHabiles  = $CalculaTiempo['HorasHabiles'];
    $DiasTrans     = $CalculaTiempo['DiasTrans'];
    if ($TipoCalculo == 'HorasCorridas' || $TipoCalculo == 'HorasHabiles') {
        $TextTime  = 'Horas';
        $ValorTime = $HorasHabiles;
    } else {
        $TextTime  = 'Dias';
        $ValorTime = $DiasTrans;
    }

    if ($MetaCalculo < $ValorTime) {
        $Cumple = 0;
    } else {
        $Cumple = 1;
    }
    $Resultados      = array(
        'calculo'       => $ValorTime,
        'cumple'        => $Cumple,
        'TextTime' =>  $TextTime
    );
    return $Resultados;
}


function ValidarNombreFechaCampo($connMysql, $FechaCampo)
{

    $SQL  = " SELECT * FROM tabc_so_fechaskpis WHERE CampoFecha='$FechaCampo' ORDER BY id ASC ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();

    return  $result[0]['TituloCampo'];
}


function CronValidarKPI($connMysql, $IdProceso = 1)
{


    $FunctionsMySQL = new FunctionsMySQL();

    $ArrayJson = array(
        'ID' => $IdProceso,
        'estado'     => true,
        'time'     => time(),
    );
    $fechaFinal = date("Y-m-d");
    $fechaInicial = date("Y-m-d", strtotime($fechaFinal . " - 90 day"));
    $FunctionsMySQL->Update($ArrayJson, 'abc_cron_control.tbl_cron', $connMysql);
    $SQL          = " SELECT * FROM tabc_hist_levantes WHERE DeclImpoFechaLevante between '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59'";
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $total = $stmt->rowCount();
    $progreso = 0;
    if ($total > 0) {
        foreach ($result as $row) {
            $progreso++;
            $DataCampos = TraerKpiConfig($connMysql, $row);
            echo $progreso . ' de ' . $total . ' fecha levante ' . $row['DeclImpoFechaLevante'] . ' Calculado' . PHP_EOL;
        }
    }

    $ArrayJson = array(
        'ID' => $IdProceso,
        'estado'     => false,
        'time'     => time(),
    );
    $FunctionsMySQL->Update($ArrayJson, 'abc_cron_control.tbl_cron', $connMysql);
}


function ValidarKPI($connMysql, $IdKpi, $IdLevante)
{
    $SQL          = " SELECT * FROM tabc_so_resultadoskpis WHERE  IdKpi='$IdKpi' AND IdLevante = '$IdLevante'";
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $row        = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['ID'];
    } else {
        return false;
    }
}


function TraerKpiConfig($connMysql, $row)
{
    $ClienteID = $row['ClienteID'];
    $FunctionsMySQL = new FunctionsMySQL();
    $SQL          = " SELECT * FROM tabc_so_conf_kpi WHERE  ClienteID='$ClienteID'";
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
if ($stmt->rowCount() == 0){
    $SQL          = " SELECT * FROM tabc_so_conf_kpi WHERE  ClienteID='37324'";
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
}
    if ($stmt->rowCount() > 0) {

        foreach ($result as $DataCampos) {
            $FechaInicialKpi = $DataCampos['FechaInicialKpi'];
            $FechaFinalKpi = $DataCampos['FechaFinalKpi'];
            $DataTipos = array(
                'DiasCalculo' => $DataCampos['DiasCalculo'],
                'TiempoMeta' => $DataCampos['TiempoMeta'],
            );
            if (ValidacionCampos($DataCampos, $row)) {
                $ResultadosCalculo = ResultadoCalculoKPI($row[$FechaInicialKpi], $row[$FechaFinalKpi], $DataTipos);

                $ValidacionKpi = ValidarKPI($connMysql, $DataCampos['ID'], $row['ID']);

                $DataArray      = array(
                    'ClienteId'            => $row['ClienteID'],
                    'DocImpoID'            => $row['DocImpoID'],
                    'IdKpi'                => $DataCampos['ID'],
                    'DeclImpoFechaLevante' => $row['DeclImpoFechaLevante'],
                    'TipoTrans'            => RectificarModo($row['ModoTransporte']),
                    'DiasCalculo'          => $ResultadosCalculo['calculo'], // Tiempo meta. DiasCalculo en tabla es el tipo de calculo
                    'Cumple'               => $ResultadosCalculo['cumple'],
                    'IdLevante'            => $row['ID'],
                    'TipoKPI' => $DataCampos['TipoKPI'],
                    'EjecutivoID'  => $row['EjecutivoID'],
                    'FechaInicialKpi' => $row[$FechaInicialKpi],
                    'FechaFinalKpi' => $row[$FechaFinalKpi],
                );

                if ($ValidacionKpi === false) {

                    $FunctionsMySQL->Insert($DataArray, 'tabc_so_resultadoskpis', $connMysql);
                    // $DataArrayLevante = array(
                    //     'ID' => $row['ID'],
                    //     'KpiCalculado' => 1,
                    // );

                    // $FunctionsMySQL->Update($DataArrayLevante, 'tabc_hist_levantes', $connMysql);
                } else {
                    $DataArray['ID'] = $ValidacionKpi;
                    $FunctionsMySQL->Update($DataArray, 'tabc_so_resultadoskpis', $connMysql);
                }
            }
        }
    }
}
