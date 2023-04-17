<?php

function KpisGenerales($connMysql)
{
    $FiltroActivo = FiltroActivo('RemoveTablero');
    $ParamFecha =  ReturnRangoKpi();
    if ($_POST['TipoBtnFiltroKpi'] == 'Clientes') {
        $SQL = "SELECT COUNT(*) AS RecuentoFilas , ClienteID, Cliente FROM tabc_hist_levantes WHERE  $FiltroActivo $ParamFecha  GROUP BY ClienteID HAVING COUNT(*) > 0 ORDER BY RecuentoFilas DESC  ";
        $CampoFilter = 'ClienteID';
        $NombreUser = 'Cliente';
        $TituloCard = 'Cliente';
    } else {
        $SQL          = "SELECT COUNT(*) AS RecuentoFilas , EjecutivoID,Ejecutivo FROM tabc_hist_levantes WHERE   $FiltroActivo $ParamFecha  GROUP BY EjecutivoID HAVING COUNT(*) > 0 ORDER BY RecuentoFilas DESC ";
        $CampoFilter = 'EjecutivoID';
        $NombreUser = 'Ejecutivo';
        $TituloCard = 'Coordinador';
    }

    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result               = $stmt->fetchAll();
    $html                 = '';
    $TotalGeneralLEvantes = 0;
    $TotalValorKpiNac     = 0;
    $TotalValorKpiFact    = 0;
    $TotalTipoTranAereo = 0;
    $TotalTipoTransMar = 0;
    $TotalTipoTransTerr = 0;
    $idoperacion = 0;
    $htmlHeaderTable      = '<div id="toggleAccordion">';
    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            $idoperacion++;
            $TotalLevantes = $row['RecuentoFilas'];
            $ValueFilter = $row[$CampoFilter];
            $ParamSearch = "$CampoFilter='$ValueFilter'";
            $HtmlCompare = KpisGeneralesCompara($ParamSearch, $connMysql);
            $DataRowKPI  = RetornarKPI($ParamSearch, $TotalLevantes, $connMysql);
            $IdKpiNac = $DataRowKPI['IdKpiNac'];
            $IdKpiFact = $DataRowKPI['IdKpiFact'];
            $MetaNac = DataKpis($connMysql, $IdKpiNac)['PercKpi'];
            $MetaFact = DataKpis($connMysql, $IdKpiFact)['PercKpi'];
            $DataEstadistica = DataEstadistica($ParamSearch, $ParamFecha, $connMysql);
            $DataNombres = ReturnNombresSearch($CampoFilter, $row[$CampoFilter], $connMysql);
            if ($DataRowKPI['TotalProcesos'] > 0) {
                if ($DataRowKPI['KpiNac'] >= 85) {
                    $ColorKpiNac = 'green';
                } else {
                    $ColorKpiNac = 'danger titila';
                }
                if ($DataRowKPI['KpiFact'] >= 85) {
                    $ColorKpiFac = 'green';
                } else {
                    $ColorKpiFac = 'danger titila';
                }
                $ValorKpiNac   = $DataRowKPI['ValorKpiNac'];
                $ValorKpiFact  = $DataRowKPI['ValorKpiFact'];
                $TotalGeneralLEvantes += $TotalLevantes;
                $TotalValorKpiNac += $ValorKpiNac;
                $TotalValorKpiFact += $ValorKpiFact;
                $TotalTipoTranAereo += $DataEstadistica['TipoTranAereo'];
                $TotalTipoTransMar += $DataEstadistica['TipoTransMar'];
                $TotalTipoTransTerr +=  $DataEstadistica['TipoTransTerr'];
                $PorcentajeKpiNac = $DataRowKPI['KpiNac'];
                $PorcentajeKpiFact = $DataRowKPI['KpiFact'];
                $GraficPercentNacIn = $PorcentajeKpiNac;
                $GraficPercentFactIn = $PorcentajeKpiFact;
                if ($GraficPercentNacIn >= 85) {
                    $ColorKpiNac = 'bg-success';
                } else  if ($GraficPercentNacIn >= 55 && $GraficPercentNacIn < 85) {
                    $ColorKpiNac = 'bg-warning';
                } else  if ($GraficPercentNacIn == 0) {
                    $GraficPercentNacIn = 0;
                    $ColorKpiNac = 'bg-danger titila';
                } else {
                    $ColorKpiNac = 'bg-danger titila';
                }

                if ($GraficPercentFactIn >= 85) {
                    $ColorKpiFac = 'bg-success';
                } else  if ($GraficPercentFactIn >= 55 && $GraficPercentFactIn < 85) {
                    $ColorKpiFac = 'bg-warning';
                } else if ($GraficPercentFactIn == 0) {
                    $GraficPercentFactIn = 0;
                    $ColorKpiFac = 'bg-danger titila';
                } else {
                    $ColorKpiFac = 'bg-danger titila';
                }

                if ($HtmlCompare == false) {
                    $colData = "col-xl-8";
                } else {
                    $colData = "col-xl-4";
                }

                $html .= '<div class="card" id="DivOperacion' . $idoperacion . '">
                <div class="card-header" id="headingOne1">
                    <section class="mb-0 mt-0">
                        <div role="menu" class="collapsed BtnDesplegarKPIUsers" data-id="' . $row[$CampoFilter] . '"
                            data-toggle="collapse" data-target="#KpiAccordion' . $row[$CampoFilter] . '" aria-expanded="false"
                            aria-controls="KpiAccordion' . $row[$CampoFilter] . '">
                            <div class="row">
                                <div class="col-xl-3 text-Kpis"> <span class="BtnOpenModalKPI" data-clon="DivOperacion' . $idoperacion . '" data-id="' . $row[$CampoFilter] . '">
                                        <p><small>' . $TituloCard . '</small></p> ' . $row[$NombreUser] . '
                                    </span>
                                    <p><small>Jefe de cuenta:<b>' . $DataNombres['JefeCuenta'] . '</b> </small></p>
                                    <p  class="titleLevantes">Kpis ' . TituloFechaKpi('Normal') . '</p>
                                </div>
                                <div class="' . $colData . '">
                                    <div class="col-xl-12">
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <div class="mr-2">
                                                    <p class="titleLevantes">Levantes</p>
                                                    <div class="c100 p100 med primary" data-toggle="tooltip"
                                                        data-original-title="Cantidad de procesos">
                                                        <span>' . $TotalLevantes . '</span>
                                                        <div class="slice">
                                                            <div class="bar"></div>
                                                            <div class="fill"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="col-xl-10">
                                     
                                          <h6 class="text-right">Meta: ' . $MetaNac . '% <i class="fa fa-flag-checkered fa-4" aria-hidden="true"></i></h6>
                                                <div title="' . $DataRowKPI['KpiNac']  . '% Kpi Nacionalización"
                                                    class="progress br-30 progress-lg">
                                                    <div class="progress-bar ' . $ColorKpiNac . '" role="progressbar"
                                                        style="width: ' . $GraficPercentNacIn . '%" aria-valuenow="100"
                                                        aria-valuemin="0" aria-valuemax="100">
                                                        <div class="text-dark progress-title m-3"><span>' . $DataRowKPI['KpiNac'] . '%
                                                                Kpi
                                                                Nacionalización</span></div>
                                                    </div>
                                                    
                                                </div>
                                               
                                                <h6 class="text-right">Meta: ' . $MetaFact . '% <i class="fa fa-flag-checkered fa-4" aria-hidden="true"></i></h6>
                                                <div title="' . $DataRowKPI['KpiFact'] . '% Kpi Facturación "
                                                    class="progress br-30 progress-lg">
                                                    <div class="progress-bar ' . $ColorKpiFac . '" role="progressbar"
                                                        style="width: ' . $GraficPercentFactIn . '%" aria-valuenow="100"
                                                        aria-valuemin="0" aria-valuemax="100">
                                                        <div class="text-dark progress-title m-3"><span>' . $DataRowKPI['KpiFact'] .
                    '%
                                                                Kpi
                                                                Facturación
                                                                </span< /div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="row">
                                                        <div class="col-xl-3 ">
                                                            <h5>' . $DataEstadistica['TipoTranAereo'] . ' <i class="fa fa-plane fa-3" aria-hidden="true"></i>
                                                                </h5>
                                                        </div>
                                                        <div class="col-xl-3">
                                                            <h5>' . $DataEstadistica['TipoTransMar'] . ' <i class="fa fa-ship fa-3" aria-hidden="true"></i>
                                                                </h5>
                                                        </div>
                                                        <div class="col-xl-3">
                                                            <h5>' . $DataEstadistica['TipoTransTerr'] . ' <i class="fa fa-truck fa-3" aria-hidden="true"></i>
                                                                </h5>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            ' . $HtmlCompare . '
            
            
            
                            </div>
                    </section>
                </div>
                <div id="KpiAccordion' . $row[$CampoFilter] . '" class="RemoveCollapseKpi collapse" aria-labelledby="headingOne1"
                    data-parent="#toggleAccordion" style="border-style: solid;border-color:#00317B">
                    <div class="card-body card-bodyKpi' . $row[$CampoFilter] . '">
                    </div>
                </div>
            </div>';
            }
        }
    } else {
    }

    $HtmlTotales = '';
    if ($TotalGeneralLEvantes > 0) {
        $KpiNacGeneral  = round(($TotalValorKpiNac / $TotalGeneralLEvantes) * 100);
        $KpiFactGeneral = round(($TotalValorKpiFact / $TotalGeneralLEvantes) * 100);
        $GraficPercentNac = $KpiNacGeneral;
        $GraficPercentFact = $KpiFactGeneral;
        if ($KpiNacGeneral >= 85) {
            $ColorKpiNac = 'bg-success';
        } else  if ($KpiNacGeneral >= 55 && $KpiNacGeneral < 85) {
            $ColorKpiNac = 'bg-warning';
        } else  if ($KpiNacGeneral == 0) {
            $GraficPercentNac = 0;
            $ColorKpiNac = 'bg-danger titila';
        } else {
            $ColorKpiNac = 'bg-danger titila';
        }
        if ($KpiFactGeneral >= 85) {
            $ColorKpiFac = 'bg-success';
        } else  if ($KpiFactGeneral >= 55 && $KpiFactGeneral < 85) {
            $ColorKpiFac = 'bg-warning';
        } else if ($KpiFactGeneral == 0) {
            $GraficPercentFact = 0;
            $ColorKpiFac = 'bg-danger titila';
        } else {
            $ColorKpiFac = 'bg-danger titila';
        }

        $HtmlCompareTotales = KpisGeneralesComparaTotales($connMysql);
        if ($HtmlCompareTotales == false) {
            $colDatatotal = "col-xl-8";
        } else {
            $colDatatotal = "col-xl-4";
        }

        $HtmlTotales .= '<div class="card" style="background-color:#C2D5FF">
        <div class="card-header" id="headingOne1">
            <section class="mb-0 mt-0">
                <div class="collapsed">
                    <div class="row">
                        <div class="mb-5 mt-5 col-xl-3 text-Kpis">
                            <div align="center" class="text-Kpis">TOTAL GENERAL</div>
                            <p class="text-center titleLevantes">Kpis ' . TituloFechaKpi('Normal') . '</p>
                        </div>
                        <div class="' . $colDatatotal . '">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="mr-2 mb-2">
                                            <p>Levantes</p>
                                            <div class="c100 p100 med primary" data-toggle="tooltip"
                                                data-original-title="Cantidad de procesos">
                                                <span>' . $TotalGeneralLEvantes . '</span>
                                                <div class="slice">
                                                    <div class="bar"></div>
                                                    <div class="fill"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <div class="col-xl-10">
                                    
                                  
                                        <div title="' . $KpiNacGeneral . '% Kpi Nacionalización"
                                            class="progress br-30 progress-lg">
                                            <div class="progress-bar ' . $ColorKpiNac . '" role="progressbar"
                                                style="width: ' . $GraficPercentNac . '%" aria-valuenow="100"
                                                aria-valuemin="0" aria-valuemax="100">
                                                <div class="text-dark progress-title m-3"><span>' . $KpiNacGeneral . '% Kpi
                                                        Nacionalización</span></div>
                                            </div>
                                        </div>
                                       

                                        <div title="' . $KpiFactGeneral . '% Kpi Facturación "
                                            class="progress br-30 progress-lg">
                                            <div class="progress-bar ' . $ColorKpiFac . '" role="progressbar"
                                                style="width: ' . $GraficPercentFact . '%" aria-valuenow="100"
                                                aria-valuemin="0" aria-valuemax="100">
                                                <div class="text-dark progress-title m-3"><span>' . $KpiFactGeneral . '% Kpi
                                                        Facturación
                                                        </span< /div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-xl-3 ">
                                                    <h5>' . $TotalTipoTranAereo . ' <i class="fa fa-plane fa-3"
                                                            aria-hidden="true"></i>
                                                    </h5>
                                                </div>
                                                <div class="col-xl-3">
                                                    <h5>' . $TotalTipoTransMar . ' <i class="fa fa-ship fa-3"
                                                            aria-hidden="true"></i>
                                                    </h5>
                                                </div>
                                                <div class="col-xl-3">
                                                    <h5>' . $TotalTipoTransTerr . ' <i class="fa fa-truck fa-3"
                                                            aria-hidden="true"></i>
                                                    </h5>
                                                </div>
    
                                            </div>
                                        </div>
    
                                    </div>
                                </div>
                            </div>
                        </div>
                        ' . $HtmlCompareTotales . '
            </section>
        </div>
    </div>';
    } else {
        return '<div class="alert alert-outline-danger mb-4" role="alert">
        <strong>No existen levantes!</strong> no existen levantes con el filtro seleccionado, intente más tarde o cambie el filtro de busquedas.
    </div> ';
    }
    $htmlFooter = '      </div>';
    return $htmlHeaderTable . $HtmlTotales . $html . $htmlFooter;
}







function KpisUsuarios($connMysql)
{
    $FiltroActivo = FiltroActivo('RemoveTablero');
    $CampoID    = $_POST['CampoID'];


    $ParamFecha =  ReturnRangoKpi();
    if ($_POST['TipoBtnFiltroKpi'] == 'Clientes') {
        $SQL          = "SELECT COUNT(*) AS RecuentoFilas , EjecutivoID FROM tabc_hist_levantes WHERE  $FiltroActivo  AND  ClienteID='$CampoID'  $ParamFecha  GROUP BY EjecutivoID HAVING COUNT(*) > 0 ORDER BY RecuentoFilas DESC ";
        $CampoFilter = 'EjecutivoID';
        $NombreUser = 'Ejecutivo';
        $TituloCard = 'Coordinador';
        $ParametroAdd = "AND  ClienteID='$CampoID'";
    } else {
        $SQL          = "SELECT COUNT(*) AS RecuentoFilas , ClienteID FROM tabc_hist_levantes WHERE $FiltroActivo  AND EjecutivoID='$CampoID'  $ParamFecha  GROUP BY ClienteID HAVING COUNT(*) > 0 ORDER BY RecuentoFilas DESC ";
        $CampoFilter = 'ClienteID';
        $NombreUser = 'Cliente';
        $TituloCard = 'Cliente';
        $ParametroAdd = " AND  EjecutivoID='$CampoID'";
    }


    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $html   = '';
    if ($stmt->rowCount() > 0) {
        $htmlHeaderTable      = '';
        $TotalGeneralLEvantes = 0;
        $TotalValorKpiNac     = 0;
        $TotalValorKpiFact    = 0;
        foreach ($result as $row) {

            $TotalLevantes = $row['RecuentoFilas'];
            $ValueFilter =  $row[$CampoFilter];
            $ParamSearch = "$CampoFilter ='$ValueFilter'  $ParametroAdd ";
            $DataRowKPI  = RetornarKPI($ParamSearch, $TotalLevantes, $connMysql);
            $DataEstadistica = DataEstadistica($ParamSearch, $ParamFecha, $connMysql);

            if ($DataRowKPI['TotalProcesos'] > 0) {
                $PorcentajeKpiNac = $DataRowKPI['KpiNac'];
                $PorcentajeKpiFact = $DataRowKPI['KpiFact'];
                $GraficPercentNacIn = $PorcentajeKpiNac;
                $GraficPercentFactIn = $PorcentajeKpiFact;

                if ($GraficPercentNacIn >= 85) {
                    $ColorKpiNac = 'bg-success';
                } else  if ($GraficPercentNacIn >= 55 && $GraficPercentNacIn < 85) {
                    $ColorKpiNac = 'bg-warning';
                } else  if ($GraficPercentNacIn == 0) {
                    $GraficPercentNacIn = 0;
                    $ColorKpiNac = 'bg-danger titila';
                } else {
                    $ColorKpiNac = 'bg-danger titila';
                }


                if ($GraficPercentFactIn >= 85) {
                    $ColorKpiFac = 'bg-success';
                } else  if ($GraficPercentFactIn >= 55 && $GraficPercentFactIn < 85) {
                    $ColorKpiFac = 'bg-warning';
                } else if ($GraficPercentFactIn == 0) {
                    $GraficPercentFactIn = 0;
                    $ColorKpiFac = 'bg-danger titila';
                } else {
                    $ColorKpiFac = 'bg-danger titila';
                }
                $TotalProcesos = $DataRowKPI['TotalProcesos'];
                $ValorKpiNac   = $DataRowKPI['ValorKpiNac'];
                $ValorKpiFact  = $DataRowKPI['ValorKpiFact'];
                $TotalGeneralLEvantes += $TotalLevantes;
                $TotalValorKpiNac += $ValorKpiNac;
                $TotalValorKpiFact += $ValorKpiFact;
                $DataNombre   = ReturnNombresSearch($CampoFilter, $row[$CampoFilter], $connMysql);

                $NombreBuscar = $DataNombre[$NombreUser];
                $html .= '<div class="row">
                <div class="col-xl-3 text-Kpis">
                    <p><small>' . $TituloCard . ':</small></p> ' . $NombreBuscar . '
                </div>
               
                
                <div class="col-xl-4">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-2">
                                <div class="mr-2">
                                    <p class="titleLevantes">Levantes</p>
                                    <div class="c100 p100 small primary" data-toggle="tooltip"
                                        data-original-title="Cantidad de procesos">
                                        <span>' . $TotalLevantes . '</span>
                                        <div class="slice">
                                            <div class="bar"></div>
                                            <div class="fill"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-10">
                                <p class="text-center titleLevantes">Kpis</p>
                                <div title="' . $DataRowKPI['KpiNac']  . '% Kpi Nacionalización"
                                    class="progress br-30 progress-md">
                                    <div class="progress-bar ' . $ColorKpiNac . '" role="progressbar"
                                        style="width: ' . $GraficPercentNacIn . '%" aria-valuenow="100"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <div class="text-dark progress-title m-3"><span>' . $DataRowKPI['KpiNac'] .
                    '%
                                                Kpi
                                                Nacionalización</span></div>
                                    </div>
                                </div>
                                <div title="' . $DataRowKPI['KpiFact'] . '% Kpi Facturación "
                                    class="progress br-30 progress-md">
                                    <div class="progress-bar ' . $ColorKpiFac . '" role="progressbar"
                                        style="width: ' . $GraficPercentFactIn . '%" aria-valuenow="100"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <div class="text-dark progress-title m-3"><span>' . $DataRowKPI['KpiFact'] .
                    '%
                                                Kpi
                                                Facturación
                                                </span< /div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-3 ">
                                            <h6>' . $DataEstadistica['TipoTranAereo'] . ' <i
                                                    class="fa fa-plane fa-3" aria-hidden="true"></i>
                                                </h6>
                                        </div>
                                        <div class="col-xl-3">
                                            <h6>' . $DataEstadistica['TipoTransMar'] . ' <i class="fa fa-ship fa-3"
                                                    aria-hidden="true"></i>
                                                </h6>
                                        </div>
                                        <div class="col-xl-3">
                                            <h6>' . $DataEstadistica['TipoTransTerr'] . ' <i
                                                    class="fa fa-truck fa-3" aria-hidden="true"></i>
                                                </h6>
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            }
        }
    } else {
    }
    return $html;
}


function RetornarKPI($ParamSearch, $TotalLevantes,  $connMysql)
{
    $ParamFecha =  ReturnRangoKpi();
    $SQL          = "SELECT  * FROM tabc_so_resultadoskpis WHERE  $ParamSearch  $ParamFecha ";
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result               = $stmt->fetchAll();
    $data                 = array();
    $TotalProcesos        = 0;
    $ValorKpiNac          = 0;
    $ValorKpiFact = 0;
    $ValorKpiFact = 0;
    $TipoTranAereo = 0;
    $TipoTransMar = 0;
    $TipoTransTerr = 0;
    $data['IdKpiNac'] = 0;
    $data['IdKpiFact'] = 0;
    foreach ($result as $row) {

        if ($row['TipoKPI'] == 'Nacionalizacion') {
            $data['IdKpiNac'] = $row['IdKpi'];
            if ($row['Cumple'] == 1) {
                $ValorKpiNac += 1;
            }
        }
        if ($row['TipoKPI'] == 'Facturación') {
            $data['IdKpiFact'] = $row['IdKpi'];
            if ($row['Cumple'] == 1) {
                $ValorKpiFact += 1;
            }
        }

        switch ($row['TipoTrans']) {
            case 'Aéreo':
                $TipoTranAereo += 1;
                break;
            case 'Marítimo':
                $TipoTransMar += 1;
                break;
            case 'Terrestre':
                $TipoTransTerr += 1;
                break;
        }
    }

    $KpiNac               = round(($ValorKpiNac / $TotalLevantes) * 100);
    $data['KpiNac']       = $KpiNac;
    $KpiFact              = round(($ValorKpiFact / $TotalLevantes) * 100);
    $data['KpiFact']      = $KpiFact;
    $data['ValorKpiNac']  = $ValorKpiNac;
    $data['ValorKpiFact'] = $ValorKpiFact;
    $data['TipoTranAereo'] = $TipoTranAereo;
    $data['TipoTransMar']  = $TipoTransMar;
    $data['TipoTransTerr'] = $TipoTransTerr;

    $data['TotalProcesos'] = $TotalLevantes;
    return $data;
}


function BuscarKpiResult($ParamSearch, $TotalLevantes,  $connMysql)
{
    $ParamFecha =  ReturnRangoKpi();
    $SQL          = "SELECT  * FROM tabc_so_resultadoskpis WHERE  $ParamSearch  $ParamFecha ";
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result               = $stmt->fetchAll();
    $data                 = array();
    $ValorKpiNac          = 0;
    $ValorKpiFact = 0;
    $ValorKpiFact = 0;


    foreach ($result as $row) {
        if ($row['TipoKPI'] == 'Nacionalizacion') {

            if ($row['Cumple'] == 1) {
                $ValorKpiNac += 1;
            }
        }
        if ($row['TipoKPI'] == 'Facturación') {
            if ($row['Cumple'] == 1) {
                $ValorKpiFact += 1;
            }
        }
    }



    $data['ValorKpiNac']  = $ValorKpiNac;
    $data['ValorKpiFact'] = $ValorKpiFact;

    return $data;
}


function DataEstadistica($ParamSearch, $ParamFecha, $connMysql)
{

    $SQL          = "SELECT  * FROM tabc_hist_levantes WHERE  $ParamSearch  $ParamFecha ";
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result               = $stmt->fetchAll();
    $data                 = array();
    $TipoTranAereo = 0;
    $TipoTransMar = 0;
    $TipoTransTerr = 0;

    foreach ($result as $row) {

        switch ($row['ModoTransporte']) {
            case 'Aéreo':
                $TipoTranAereo += 1;
                break;
            case 'Marítimo':
                $TipoTransMar += 1;
                break;
            case 'Terrestre':
                $TipoTransTerr += 1;
                break;
        }
    }


    $data['TipoTranAereo']      = $TipoTranAereo;
    $data['TipoTransMar']  = $TipoTransMar;
    $data['TipoTransTerr'] = $TipoTransTerr;

    return $data;
}


function ListaDetalleKPI($connMysql)
{

    $FiltroActivo = FiltroActivo('RemoveTablero');


    $data      = array();
    $ClienteID = $_POST['ClienteID'];
    $ParamFecha =  ReturnRangoKpi();
    $SQL       = "SELECT  * FROM tabc_hist_levantes WHERE (ClienteID='$ClienteID' or EjecutivoID='$ClienteID')  $ParamFecha ";
    $stmt      = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if ($stmt->rowCount() > 0) {
        $html = '<div  class="Data" style="overflow-x: auto">
    <table id="ListaDOTable" class="table table-bordered">
        <thead>
            <tr class="HeadTable">

                <th>Nac ID</th>
                <th>Num DO</th>
                <th>Kpi Naciona</th>
                <th>Kpi Facturac</th>
                <th>Fecha Levante</th>
           
                 <th>Ejecutivo</th>
            </tr>
        </thead>
        <tbody>
            ';
        foreach ($result as $row) {
            $ParamSearch = 'IdLevante=' . $row['ID'] . '';
            $DataRowKPI  = BuscarKpiResult($ParamSearch, $stmt->rowCount(), $connMysql);
            // print_r($DataRowKPI);
            if ($DataRowKPI['ValorKpiNac'] == 1) {
                $LabelNac = '<strong><span class="text-success">Cumple <i class="ti-thumb-up"></i><span></strong>';
            } else {
                $LabelNac = '<strong><span class="text-danger">No cumple <i class="ti-thumb-down"></i><span></strong>';
            }
            if ($DataRowKPI['ValorKpiFact'] == 1) {
                $LabelFact = '<strong><span class="text-success">Cumple <i class="ti-thumb-up"></i><span></strong>';
            } else {
                $LabelFact = '<strong><span class="text-danger">No cumple <i class="ti-thumb-down"></i><span></strong>';
            }

            $DataNombre   = ReturnNombresSearch('EjecutivoID', $row['EjecutivoID'], $connMysql);
            $NombreBuscar = $DataNombre['NombreUser'];
            $html .= '<tr class="mt-2 mb-2 items BtnSelectDOKPI ' . $row['OrdenNacID'] . '" data-id="' . $row['OrdenNacID'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                <td class="item ' . $row['OrdenNacID'] . '">' . $row['OrdenNacID'] . '</td>
                <td class="item ' . $row['OrdenNacID'] . '">' . $row['DocImpoNoDO'] . '</td>
                <td class="item ' . $row['OrdenNacID'] . '">' . $LabelNac . '</td>
                <td class="item ' . $row['OrdenNacID'] . '">' . $LabelFact . '</td>
                <td class="item ' . $row['OrdenNacID'] . '">' . ConvertFechaHour($row['DeclImpoFechaLevante']) . '</td>
         
                <td class="item ' . $row['OrdenNacID'] . '">' . ArreglaNombresForPie($NombreBuscar) . '</td>
            </tr>';
        }
        $html .= '
        </tbody>
    </table></div>';
    } else {
        $html = '<div class="alert alert-outline-danger mb-4" role="alert">
        <strong>No existen levantes!</strong> no existen levantes con el filtro seleccionado, intente más tarde o cambie el filtro de busquedas.
    </div> ';
    }

    $data['table'] = $html;
    return json_encode($data);
}



function KpisGeneralesCompara($ParamSearch, $connMysql)
{


    $ParamFecha =  ReturnRangoKpiComparativo();
    if ($ParamFecha == false) {
        return false;
    }
    if ($_POST['TipoBtnFiltroKpi'] == 'Clientes') {
        $SQL = "SELECT COUNT(*) AS RecuentoFilas , ClienteID, Cliente FROM tabc_hist_levantes WHERE $ParamSearch  $ParamFecha  GROUP BY ClienteID HAVING COUNT(*) > 0 ORDER BY RecuentoFilas DESC  ";
        $CampoFilter = 'ClienteID';
        $NombreUser = 'Cliente';
        $TituloCard = 'Cliente';
    } else {
        $SQL          = "SELECT COUNT(*) AS RecuentoFilas , EjecutivoID,Ejecutivo FROM tabc_hist_levantes WHERE $ParamSearch   $ParamFecha  GROUP BY EjecutivoID HAVING COUNT(*) > 0 ORDER BY RecuentoFilas DESC ";
        $CampoFilter = 'EjecutivoID';
        $NombreUser = 'Ejecutivo';
        $TituloCard = 'Coordinador';
    }

    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result               = $stmt->fetchAll();
    $html                 = '';
    $TotalGeneralLEvantes = 0;
    $TotalValorKpiNac     = 0;
    $TotalValorKpiFact    = 0;
    $TotalTipoTranAereo = 0;
    $TotalTipoTransMar = 0;
    $TotalTipoTransTerr = 0;

    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            $TotalLevantes = $row['RecuentoFilas'];
            $ValueFilter = $row[$CampoFilter];
            $ParamSearch = "$CampoFilter='$ValueFilter'";
            $DataRowKPI  = RetornarKPI($ParamSearch, $TotalLevantes, $connMysql);
            $ValorKpiNac   = $DataRowKPI['ValorKpiNac'];
            $ValorKpiFact  = $DataRowKPI['ValorKpiFact'];
            $PorcentajeKpiNac = $DataRowKPI['KpiNac'];
            $PorcentajeKpiFact = $DataRowKPI['KpiFact'];
            $DataEstadistica = DataEstadistica($ParamSearch, $ParamFecha, $connMysql);
            $DataNombres = ReturnNombresSearch($CampoFilter, $row[$CampoFilter], $connMysql);
            if ($DataRowKPI['TotalProcesos'] > 0) {
                if ($DataRowKPI['KpiNac'] >= 85) {
                    $ColorKpiNac = 'green';
                } else {
                    $ColorKpiNac = 'danger titila';
                }
                if ($DataRowKPI['KpiFact'] >= 85) {
                    $ColorKpiFac = 'green';
                } else {
                    $ColorKpiFac = 'danger titila';
                }
                $TotalProcesos = $DataRowKPI['TotalProcesos'];
                $ValorKpiNac   = $DataRowKPI['ValorKpiNac'];
                $ValorKpiFact  = $DataRowKPI['ValorKpiFact'];
                $TotalGeneralLEvantes += $TotalLevantes;
                $TotalValorKpiNac += $ValorKpiNac;
                $TotalValorKpiFact += $ValorKpiFact;

                $TotalTipoTranAereo += $DataEstadistica['TipoTranAereo'];
                $TotalTipoTransMar += $DataEstadistica['TipoTransMar'];
                $TotalTipoTransTerr +=  $DataEstadistica['TipoTransTerr'];

                $IdKpiNac = $DataRowKPI['IdKpiNac'];
                $IdKpiFact = $DataRowKPI['IdKpiFact'];

                $MetaNac = DataKpis($connMysql, $IdKpiNac)['PercKpi'];
                $MetaFact = DataKpis($connMysql, $IdKpiFact)['PercKpi'];

                $PorcentajeKpiNac = $DataRowKPI['KpiNac'];
                $PorcentajeKpiFact = $DataRowKPI['KpiFact'];
                $GraficPercentNacIn = $PorcentajeKpiNac;
                $GraficPercentFactIn = $PorcentajeKpiFact;
                $KpiNacGeneral  = round(($TotalValorKpiNac / $TotalGeneralLEvantes) * 100);
                $KpiFactGeneral = round(($TotalValorKpiFact / $TotalGeneralLEvantes) * 100);

                if ($GraficPercentNacIn >= 85) {
                    $ColorKpiNac = 'bg-success';
                } else  if ($GraficPercentNacIn >= 55 && $GraficPercentNacIn < 85) {
                    $ColorKpiNac = 'bg-warning';
                } else  if ($GraficPercentNacIn == 0) {
                    $GraficPercentNacIn = 0;
                    $ColorKpiNac = 'bg-danger titila';
                } else {
                    $ColorKpiNac = 'bg-danger titila';
                }


                if ($GraficPercentFactIn >= 85) {
                    $ColorKpiFac = 'bg-success';
                } else  if ($GraficPercentFactIn >= 55 && $GraficPercentFactIn < 85) {
                    $ColorKpiFac = 'bg-warning';
                } else if ($GraficPercentFactIn == 0) {
                    $GraficPercentFactIn = 0;
                    $ColorKpiFac = 'bg-danger titila';
                } else {
                    $ColorKpiFac = 'bg-danger titila';
                }

                //     $html .= '<div class="col-xl-4 ml-5">
                //     <div class="col-xl-12">
                //         <div class="row">
                //             <div class="col-xl-2">
                //                 <div class="mr-2">
                //                     <p class="titleLevantes">Levantes</p>
                //                     <div class="c100 p100 med primary" data-toggle="tooltip"
                //                         data-original-title="Cantidad de procesos">
                //                         <span>' . $TotalLevantes . '</span>
                //                         <div class="slice">
                //                             <div class="bar"></div>
                //                             <div class="fill"></div>
                //                         </div>
                //                     </div>
                //                 </div>
                //             </div>
                //             <div class="col-xl-10">
                //                 <p class="text-center titleLevantes">Kpis ' . TituloFechaKpi('Compara') . '</p>
                //                 <div title="' . $DataRowKPI['KpiNac']  . '% Kpi Nacionalización"
                //                     class="progress br-30 progress-lg">
                //                     <div class="progress-bar ' . $ColorKpiNac . '" role="progressbar"
                //                         style="width: ' . $GraficPercentNacIn . '%" aria-valuenow="100"
                //                         aria-valuemin="0" aria-valuemax="100">
                //                         <div class="text-dark progress-title m-3"><span>' . $DataRowKPI['KpiNac'] .
                //         '%
                //                                 Kpi
                //                                 Nacionalización</span></div>
                //                     </div>
                //                 </div>
                //                 <div title="' . $DataRowKPI['KpiFact'] . '% Kpi Facturación "
                //                     class="progress br-30 progress-lg">
                //                     <div class="progress-bar ' . $ColorKpiFac . '" role="progressbar"
                //                         style="width: ' . $GraficPercentFactIn . '%" aria-valuenow="100"
                //                         aria-valuemin="0" aria-valuemax="100">
                //                         <div class="text-dark progress-title m-3"><span>' . $DataRowKPI['KpiFact'] .
                //         '%
                //                                 Kpi
                //                                 Facturación
                //                                 </span< /div>
                //                         </div>
                //                     </div>
                //                 </div>
                //                 <div class="col-xl-12">
                //                     <div class="row">
                //                         <div class="col-xl-3 ">
                //                             <h5>' . $DataEstadistica['TipoTranAereo'] . ' <i
                //                                     class="fa fa-plane fa-3" aria-hidden="true"></i>
                //                             </h5>
                //                         </div>
                //                         <div class="col-xl-3">
                //                             <h5>' . $DataEstadistica['TipoTransMar'] . ' <i class="fa fa-ship fa-3"
                //                                     aria-hidden="true"></i>
                //                             </h5>
                //                         </div>
                //                         <div class="col-xl-3">
                //                             <h5>' . $DataEstadistica['TipoTransTerr'] . ' <i
                //                                     class="fa fa-truck fa-3" aria-hidden="true"></i>
                //                             </h5>
                //                         </div>

                //                     </div>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // </div>';

                $html .= '  <div class="col-xl-4 ml-5">
<div class="col-xl-12">
    <div class="row">
        <div class="col-xl-2">
            <div class="mr-2 mb-2">
                <p>Levantes</p>
                <div class="c100 p100 med primary" data-toggle="tooltip"
                    data-original-title="Cantidad de procesos">
                    <span>' . $TotalGeneralLEvantes . '</span>
                    <div class="slice">
                        <div class="bar"></div>
                        <div class="fill"></div>
                    </div>
                </div>
            </div>
        </div>
<div class="col-xl-10">
        
        <h6 class="text-right" >Meta: <b>' . $MetaNac . '%</b><i class="fa fa-flag-checkered fa-4" aria-hidden="true"></i></h6>
            <div title="' . $KpiNacGeneral . '% Kpi Nacionalización"
                class="progress br-30 progress-lg">
                <div class="progress-bar ' . $ColorKpiNac . '" role="progressbar"
                    style="width: ' . $GraficPercentNacIn . '%" aria-valuenow="100"
                    aria-valuemin="0" aria-valuemax="100">
                    <div class="text-dark progress-title m-3"><span>' . $KpiNacGeneral . '% Kpi
                            Nacionalización</span></div>
                </div>
            </div>
           
            <h6 class="text-right">Meta: <b>' . $MetaFact . '%</b><i class="fa fa-flag-checkered fa-4" aria-hidden="true"></i></h6>
       
        
            <div title="' . $KpiFactGeneral . '% Kpi Facturación "
                class="progress br-30 progress-lg">
                <div class="progress-bar ' . $ColorKpiFac . '" role="progressbar"
                    style="width: ' . $GraficPercentFactIn . '%" aria-valuenow="100"
                    aria-valuemin="0" aria-valuemax="100">
                    <div class="text-dark progress-title m-3"><span>' . $KpiFactGeneral . '% Kpi
                            Facturación
                            </span< /div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-3 ">
                        <h5>' . $TotalTipoTranAereo . ' <i class="fa fa-plane fa-3"
                                aria-hidden="true"></i>
                        </h5>
                    </div>
                    <div class="col-xl-3">
                        <h5>' . $TotalTipoTransMar . ' <i class="fa fa-ship fa-3"
                                aria-hidden="true"></i>
                        </h5>
                    </div>
                    <div class="col-xl-3">
                        <h5>' . $TotalTipoTransTerr . ' <i class="fa fa-truck fa-3"
                                aria-hidden="true"></i>
                        </h5>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
</div>';
            }
        }
    }
    return  $html;
}


function KpisGeneralesComparaTotales($connMysql)
{

    $FiltroActivo = FiltroActivo('RemoveTablero');
    $ParamFecha =  ReturnRangoKpiComparativo();
    if ($ParamFecha == false) {
        return false;
    }
    if ($_POST['TipoBtnFiltroKpi'] == 'Clientes') {
        $SQL = "SELECT COUNT(*) AS RecuentoFilas , ClienteID, Cliente FROM tabc_hist_levantes WHERE $FiltroActivo  $ParamFecha  GROUP BY ClienteID HAVING COUNT(*) > 0 ORDER BY RecuentoFilas DESC  ";
        $CampoFilter = 'ClienteID';
        $NombreUser = 'Cliente';
        $TituloCard = 'Cliente';
    } else {
        $SQL          = "SELECT COUNT(*) AS RecuentoFilas , EjecutivoID,Ejecutivo FROM tabc_hist_levantes WHERE $FiltroActivo   $ParamFecha  GROUP BY EjecutivoID HAVING COUNT(*) > 0 ORDER BY RecuentoFilas DESC ";
        $CampoFilter = 'EjecutivoID';
        $NombreUser = 'Ejecutivo';
        $TituloCard = 'Coordinador';
    }

    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result               = $stmt->fetchAll();
    $html                 = '';
    $TotalGeneralLEvantes = 0;
    $TotalValorKpiNac     = 0;
    $TotalValorKpiFact    = 0;
    $TotalTipoTranAereo = 0;
    $TotalTipoTransMar = 0;
    $TotalTipoTransTerr = 0;

    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            $TotalLevantes = $row['RecuentoFilas'];
            $ValueFilter = $row[$CampoFilter];
            $ParamSearch = "$CampoFilter='$ValueFilter'";
            $DataRowKPI  = RetornarKPI($ParamSearch, $TotalLevantes, $connMysql);
            $DataEstadistica = DataEstadistica($ParamSearch, $ParamFecha, $connMysql);
            $DataNombres = ReturnNombresSearch($CampoFilter, $row[$CampoFilter], $connMysql);
            if ($DataRowKPI['TotalProcesos'] > 0) {
                if ($DataRowKPI['KpiNac'] >= 85) {
                    $ColorKpiNac = 'green';
                } else {
                    $ColorKpiNac = 'danger titila';
                }
                if ($DataRowKPI['KpiFact'] >= 85) {
                    $ColorKpiFac = 'green';
                } else {
                    $ColorKpiFac = 'danger titila';
                }
                $TotalProcesos = $DataRowKPI['TotalProcesos'];
                $ValorKpiNac   = $DataRowKPI['ValorKpiNac'];
                $ValorKpiFact  = $DataRowKPI['ValorKpiFact'];
                $TotalGeneralLEvantes += $TotalLevantes;
                $TotalValorKpiNac += $ValorKpiNac;
                $TotalValorKpiFact += $ValorKpiFact;

                $TotalTipoTranAereo += $DataEstadistica['TipoTranAereo'];
                $TotalTipoTransMar += $DataEstadistica['TipoTransMar'];
                $TotalTipoTransTerr +=  $DataEstadistica['TipoTransTerr'];
            }
        }
    }
    $HtmlTotales = '';
    if ($TotalGeneralLEvantes > 0) {
        $KpiNacGeneral  = round(($TotalValorKpiNac / $TotalGeneralLEvantes) * 100);
        $KpiFactGeneral = round(($TotalValorKpiFact / $TotalGeneralLEvantes) * 100);
        $GraficPercentNac = $KpiNacGeneral;
        $GraficPercentFact = $KpiFactGeneral;
        if ($KpiNacGeneral >= 85) {
            $ColorKpiNac = 'bg-success';
        } else  if ($KpiNacGeneral >= 55 && $KpiNacGeneral < 85) {
            $ColorKpiNac = 'bg-warning';
        } else  if ($KpiNacGeneral == 0) {
            $GraficPercentNac = 0;
            $ColorKpiNac = 'bg-danger titila';
        } else {
            $ColorKpiNac = 'bg-danger titila';
        }
        if ($KpiFactGeneral >= 85) {
            $ColorKpiFac = 'bg-success';
        } else  if ($KpiFactGeneral >= 55 && $KpiFactGeneral < 85) {
            $ColorKpiFac = 'bg-warning';
        } else if ($KpiFactGeneral == 0) {
            $GraficPercentFact = 0;
            $ColorKpiFac = 'bg-danger titila';
        } else {
            $ColorKpiFac = 'bg-danger titila';
        }

        $HtmlTotales .= ' <div class="col-xl-4 ml-5">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-2">
                    <div class="mr-2 mb-2">
                        <p>Levantes</p>
                        <div class="c100 p100 med primary" data-toggle="tooltip"
                            data-original-title="Cantidad de procesos">
                            <span>' . $TotalGeneralLEvantes . '</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-10">
                    <p class="text-center titleLevantes">Kpis ' . TituloFechaKpi('Compara') . '</p>
                    <div title="' . $KpiNacGeneral . '% Kpi Nacionalización"
                        class="progress br-30 progress-lg">
                        <div class="progress-bar ' . $ColorKpiNac . '" role="progressbar"
                            style="width: ' . $GraficPercentNac . '%" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="text-dark progress-title m-3"><span>' . $KpiNacGeneral . '% Kpi
                                    Nacionalización</span></div>
                        </div>
                    </div>
                    <div title="' . $KpiFactGeneral . '% Kpi Facturación "
                        class="progress br-30 progress-lg">
                        <div class="progress-bar ' . $ColorKpiFac . '" role="progressbar"
                            style="width: ' . $GraficPercentFact . '%" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="text-dark progress-title m-3"><span>' . $KpiFactGeneral . '% Kpi
                                    Facturación
                                    </span< /div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-3 ">
                                <h5>' . $TotalTipoTranAereo . ' <i class="fa fa-plane fa-3"
                                        aria-hidden="true"></i>
                                </h5>
                            </div>
                            <div class="col-xl-3">
                                <h5>' . $TotalTipoTransMar . ' <i class="fa fa-ship fa-3"
                                        aria-hidden="true"></i>
                                </h5>
                            </div>
                            <div class="col-xl-3">
                                <h5>' . $TotalTipoTransTerr . ' <i class="fa fa-truck fa-3"
                                        aria-hidden="true"></i>
                                </h5>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>';
    } else {
        return false;
    }
    return  $HtmlTotales;
}



function ReturnRangoKpi()
{
    $RangoParaKPI = $_POST['RangoParaKPI'];
    if (strlen($RangoParaKPI) > 0) {
        $fechasRow =  explode('to', $RangoParaKPI);
        $FechaInicial = $fechasRow[0] . ' 00:00:00';
        $FechaFinal = $fechasRow[1] . ' 23:59:59';
    } else {
        $FechaInicial = date("Y-m-01 00:00:00");
        $FechaFinal = date("Y-m-d 23:59:59");
    }
    //
    return "AND DeclImpoFechaLevante BETWEEN  '$FechaInicial' AND '$FechaFinal' ";
}


function ReturnRangoKpiComparativo()
{
    $RangoParaKPI = $_POST['RangoParaKPIComparar'];
    if (strlen($RangoParaKPI) > 0) {
        $fechasRow =  explode('to', $RangoParaKPI);
        $FechaInicial = $fechasRow[0] . ' 00:00:00';
        $FechaFinal = $fechasRow[1] . ' 23:59:59';
    } else {
        return false;
    }
    //
    return "AND DeclImpoFechaLevante BETWEEN  '$FechaInicial' AND '$FechaFinal' ";
}



function TituloFechaKpi($Tipo)
{
    if ($Tipo == 'Normal') {
        $RangoParaKPI = $_POST['RangoParaKPI'];
    } else {
        $RangoParaKPI = $_POST['RangoParaKPIComparar'];
    }

    if (strlen($RangoParaKPI) > 0) {
        $fechasRow =  explode('to', $RangoParaKPI);
        $FechaInicial = $fechasRow[0];
        $FechaFinal = $fechasRow[1];
    } else {
        $FechaInicial = date("Y-m-01");
        $FechaFinal = date("Y-m-d");
    }
    //
    return "Desde '$FechaInicial' Hasta '$FechaFinal' ";
}


function GetListaKpis($connMysql)
{

    $id_busqueda = $_POST['ClienteID'];

    $DataOperacion = ReturnNombresSearch('EjecutivoID',   $id_busqueda, $connMysql);
    $ClienteID = $DataOperacion['ClienteID'];
    if (strlen($ClienteID) == 0) {
        $DataOperacion = ReturnNombresSearch('ClienteID',   $id_busqueda, $connMysql);
        $ClienteID = $DataOperacion['ClienteID'];
    }
    $SQL       = "SELECT  * FROM tabc_so_conf_kpi WHERE ClienteID='$ClienteID'  ";
    $stmt      = $connMysql->prepare($SQL);
    $stmt->execute();
    $html = '<option value="">Seleccionar KPI</option>';
    $html .= '<option value="TODOS">Todos los KPI</option>';
    $result = $stmt->fetchAll();
    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            $html .= '<option value="' . $row['ID'] . '">' . $row['NombreKPI'] . ' - ' . $row['TipoTransporte'] . '</option>';
        }
    }
    return $html;
}



function GetGraficaDetalles($connMysql)
{
    echo GetValuesKpi($connMysql);
}

function GetValuesKpi($connMysql)
{
    $id_busqueda = $_POST['ClienteID'];
    $DataOperacion = ReturnNombresSearch('EjecutivoID',   $id_busqueda, $connMysql);
    $ClienteID = $DataOperacion['ClienteID'];
    if (strlen($ClienteID) == 0) {
        $DataOperacion = ReturnNombresSearch('ClienteID',   $id_busqueda, $connMysql);
        $ClienteID = $DataOperacion['ClienteID'];
    }
    $SQL       = "SELECT  * FROM tabc_so_conf_kpi WHERE ClienteID='$ClienteID'  ";
    $stmt      = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            $anidadoNombres[]     = mb_ucwords($row['NombreKPI'] . ' - ' . $row['TipoTransporte']);
            $anidadoValoresCumple[]              = ValidaValoresKpi($row['ID'],  $connMysql)['Cumple'];
            $anidadoValoresNoCumple[]              = ValidaValoresKpi($row['ID'],  $connMysql)['NoCumple'];
        }



        $data['ValoresCumple']              = $anidadoValoresCumple;
        $data['ValoresNoCumple']              = $anidadoValoresNoCumple;
        $data['nombres']              = $anidadoNombres;
    }
    return json_encode($data);
}





function ValidaValoresKpi($IdKpi,  $connMysql)
{

    $ParamFecha =  ReturnRangoKpi();
    $id_busqueda = $_POST['ClienteID'];
    $DataOperacion = ReturnNombresSearch('EjecutivoID',   $id_busqueda, $connMysql);

    if (strlen($DataOperacion['ClienteID']) == 0) {
        $DataOperacion = ReturnNombresSearch('ClienteID',   $id_busqueda, $connMysql);
        $ClienteID = $DataOperacion['ClienteID'];
        $ParamSearch = "ClienteID ='$ClienteID'";
    } else {
        $ParamSearch = "EjecutivoID ='$id_busqueda'";
    }


    $SQL          = "SELECT  * FROM tabc_so_resultadoskpis WHERE IdKpi ='$IdKpi' AND  $ParamSearch  $ParamFecha ";
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $result               = $stmt->fetchAll();
    $data                 = array();
    $TotalProcesos        = 0;
    $ValorKpiNac          = 0;
    $Cumple = 0;
    $NoCumple = 0;
    foreach ($result as $row) {
        if ($row['Cumple'] == 1) {
            $Cumple += 1;
        } else {
            $NoCumple += 1;
        }
    }

    $data['Cumple']  = $Cumple;
    $data['NoCumple'] = $NoCumple;

    return $data;
}
