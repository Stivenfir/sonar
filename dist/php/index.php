<?php
require_once "config/definidas.php";
require_once "config/conndb.php";
require_once "classes/class_MySQL.php";
define('entorno', 3);
$data = array();
CalcularDatosAdicionales();
return;
if (isset($_GET['APIV1']) && isset($_GET['Token'])) {
    if ($_GET['APIV1'] == 'CalcularDatos' && $_GET['Token'] == 'pruebas') {

        if (isset($_GET['ID'])) {
            $param      = 'ID =' . $_GET['ID'] . '';
            $Resultados = CalcularData($param);
        } else {
            $param = 'ID > 0';
            if (CopyData() == 1) {
                $Resultados = CalcularData($param);
                InsertarHistorico();
                CalcularDatosAdicionales();
                SincronizarTerminalesDepositos();
                SincronizarCorreosPersonal();
            }
            SincronizarCorreosPersonal();
        }

        $data['Result'] = $Resultados;
    } else {
        $data['Result'] = 'Error en la peticion o token incorrecto';
    }
} else {

    $data['Result'] = 'Error en la peticion';
}
echo json_encode($data);

function CopyData()
{
    $FunctionsMySQL = new FunctionsMySQL();
    $connMysql      = connMysql();
    $connMSSQL      = connMSSQL(entorno);
    VaciarTabla('imseguimientooperativo', $connMysql);
    $options  = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $params   = array();
    $DataCopy = array();
    $SQL      = "SELECT  * FROM [BotAbc].[dbo].[IMSeguimientoOperativo] ";
    $stmt     = sqlsrv_query($connMSSQL, $SQL, $params, $options);
    $Cantidad = sqlsrv_num_rows($stmt);
    while ($ArraySQL = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        $FunctionsMySQL->Insert($ArraySQL, 'imseguimientooperativo', $connMysql);
    }
    return 1;
}





function CalcularData($param)
{
    $FunctionsMySQL = new FunctionsMySQL();
    $connMysql      = connMysql();
    $SQL            = "SELECT * FROM imseguimientooperativo where  $param ";
    $stmt           = $connMysql->prepare($SQL);
    $stmt->execute();
    $result            = $stmt->fetchAll();
    $DatosActualizados = 0;

    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {

            if (strlen($row['DocImpoFechaETA']) > 0) {
                if (ConvertFechaApi($row['DocImpoFechaETA']) == '1969-12-31') {
                    $DocImpoFechaETA = '';
                } else {
                    $DocImpoFechaETA = $row['DocImpoFechaETA'];
                }
            } else {
                $DocImpoFechaETA = '';
            }

            $GrupoOperacion = AnalizaGrupo($connMysql, $row['Deposito']);

            if (strlen($row['OrdenNacID']) > 0) {
                $LlaveUnicaDO = $row['OrdenNacID'];
            } else {
                $LlaveUnicaDO = $row['DocImpoID'];
            }

            $dataArray = array(
                'ID'                                  => $row['ID'],
                'DocImpoFechaETA'                     => $DocImpoFechaETA,
                'FechaNacionalizacion'                => ReparaCadenas($row['FechaNacionalizacion']),
                'DeclImpoFechaAcept'                  => ReparaCadenas($row['DeclImpoFechaAcept']),
                'FechaManifiesto'                     => ReparaCadenas($row['FechaManifiesto']),
                'DocImpoNoDocTransp'                  => ReparaCadenas($row['DocImpoNoDocTransp']),
                'TipoNacionalizacion'                 => $row['TipoNacionalizacion'],
                'FechaDespacho'                       => ReparaCadenas($row['FechaDespacho']),
                'FechaEntrDoFact'                     => ReparaCadenas($row['FechaEntrDoFact']),
                'FechaConsultaInventario'             => ReparaCadenas($row['FechaConsultaInventario']),
                'DeclImpoFechaLevante'                => ReparaCadenas($row['DeclImpoFechaLevante']),
                'FechaEntregaApoyoOperativo'          => ReparaCadenas($row['FechaEntregaApoyoOperativo']),
                'FechaVisado'                         => ReparaCadenas($row['FechaVisado']),
                'FechaDevolucionFacturacion'          => ReparaCadenas($row['FechaDevolucionFacturacion']),
                'FechaFacturacion'                    => ReparaCadenas($row['FechaFacturacion']),
                'FechaEntregaDoDevolucionFacturacion' => ReparaCadenas($row['FechaEntregaDoDevolucionFacturacion']),
                'DocImpoFechaCrea'                    => ReparaCadenas($row['DocImpoFechaCrea']),
                'Deposito'                            => $row['Deposito'],

            );

            $ResultAnalisis                   = AnalizaData($dataArray);
            $OrdenEstado                      = DetectarPosicion($ResultAnalisis['EstadoCalculado']);
            $ResultAnalisis['OrdenEstado']    = $OrdenEstado;
            $ResultAnalisis['GrupoOperacion'] = $GrupoOperacion;
            $ResultAnalisis['LlaveUnicaDO']   = $LlaveUnicaDO;
            // print_r($ResultAnalisis);
            $FunctionsMySQL->Update($ResultAnalisis, 'imseguimientooperativo', $connMysql);
            $DatosActualizados += 1;
        }
        $params['DatosAnalizados'] = $DatosActualizados;
        return $params;
    }
}

function AnalizaGrupo($connMysql, $Deposito)
{
    //$palabrasClave = '/(' . ListaPalabras() . '):/mi';
    $palabrasClave = '/("ZONA|FRANCA|ZF|ZONA FRANCA|ABC STORAGE|STORAGE|NLS|INTEXZONA")/mi';
    $resultados    = null;
    $encontrados   = preg_match_all($palabrasClave, strtoupper(TraductorTerminalDeposito($connMysql, $Deposito)), $resultados, PREG_OFFSET_CAPTURE);
    if ($encontrados !== false) {
        $Coincidencias = 0;
        foreach ($resultados[0] as $resultado) {

            $Coincidencias++;
        }
        if ($Coincidencias > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}


function AnalizaData($data)
{
    $DiaHoy = date('Y-m-d');
    //Validar DTA Sin generar factura
    if ($data['TipoNacionalizacion'] == 'DTA') {
        if (strlen($data['DocImpoFechaETA']) > 0) {
            $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));
            if ($DiasEta < 0) {
                if (strlen($data['FechaDespacho']) > 0 && strlen($data['FechaEntrDoFact'] > 0)) {
                    $DiasParaRango = CalcularDias(ConvertFechaApi($data['FechaEntrDoFact']), $DiaHoy);
                    //DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DeclImpoFechaLevante'] . '<br>';
                    $RangoDias = DetectarRangoDias($DiasParaRango);
                    return array('EstadoCalculado' => 'DtaSinGeneraFAC', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                }
            }
        }
    }
    //DTA DTA Sin generar factura

    //Validar DTA Despachado sin pasar a Facturar

    if ($data['TipoNacionalizacion'] == 'DTA') {
        if (strlen($data['DocImpoFechaETA']) > 0) {
            $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));
            if ($DiasEta < 0) {
                if (strlen($data['FechaDespacho']) > 0) {
                    if (strlen($data['FechaEntrDoFact']) == 0) {
                        $DiasParaRango = CalcularDias(ConvertFechaApi($data['FechaDespacho']), $DiaHoy);
                        //DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DeclImpoFechaLevante'] . '<br>';
                        $RangoDias = DetectarRangoDias($DiasParaRango);
                        return array('EstadoCalculado' => 'DtaConDSPSinFAC', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                    }
                }
            }
        }
    }
    //DTA Despachado sin pasar a Facturar

    //Validar DTA Sin Arribar

    if ($data['TipoNacionalizacion'] == 'DTA') {
        if (strlen($data['DocImpoFechaETA']) > 0) {
            $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));
            if ($DiasEta >= 0) {
                if (strlen($data['FechaDespacho']) == 0) {
                    $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaETA']), $DiaHoy);
                    // echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                    $RangoDias = DetectarRangoDias($DiasParaRango);
                    return array('EstadoCalculado' => 'DtaSinArribar', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                }
            }
        }
    }
    //Validar DTA Sin Arribar

    //Validar DTA con ETA vencido sin despacho

    if ($data['TipoNacionalizacion'] == 'DTA') {
        if (strlen($data['DocImpoFechaETA']) > 0) {
            $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));
            if ($DiasEta < 0) {
                if (strlen($data['FechaDespacho']) == 0) {
                    if (strlen($data['FechaManifiesto']) > 0) {
                        $FechaSelected = $data['FechaManifiesto'];
                    } else {
                        $FechaSelected = $data['DocImpoFechaETA'];
                    }
                    $DiasParaRango = CalcularDias(ConvertFechaApi($FechaSelected), $DiaHoy);
                    //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                    $RangoDias = DetectarRangoDias($DiasParaRango);

                    return array('EstadoCalculado' => 'DtaEtaVencidoSinDSP', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                }
            }
        }
    }
    //DTA con ETA vencido sin despacho

    //Pendiente Arribo - Sin documento de Transporte
    //echo $data['DocImpoNoDocTransp'];
    if (strlen($data['DocImpoFechaETA']) > 0) {
        $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));
        if ($DiasEta >= 0) {
            if (strlen($data['FechaNacionalizacion']) == 0 && strlen($data['FechaManifiesto']) == 0 && strlen($data['DocImpoNoDocTransp']) == 0) {

                $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaETA']), $DiaHoy);
                //echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);
                return array('EstadoCalculado' => 'PendArriboSinDocTransp', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
            }
        }
    }

    //Pendiente Arribo - Sin documento de Transporte

    //Validar PendArriboEndigita

    if (strlen($data['DocImpoFechaETA']) > 0) {
        $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));
        if ($DiasEta > 0) {
            if (strlen($data['FechaNacionalizacion']) > 0) {
                $DiasNac = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaNacionalizacion']));
                if ($DiasNac <= 0) {
                    if (strlen($data['DeclImpoFechaAcept']) == 0 && strlen($data['FechaManifiesto']) == 0) {
                        $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaETA']), $DiaHoy);
                        //echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                        $RangoDias = DetectarRangoDias($DiasParaRango);
                        return array('EstadoCalculado' => 'PendArriboEndigita', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                    }
                }
            }
        }
    }
    //Validar PendArriboEndigita

    //Validar Pendiente Arribo – Aceptada

    if (strlen($data['DocImpoFechaETA']) > 0) {
        $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));
        if ($DiasEta > 0) {
            if (strlen($data['FechaNacionalizacion']) > 0) {
                $DiasNac = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaNacionalizacion']));
                if ($DiasNac <= 0) {
                    if (strlen($data['DeclImpoFechaAcept']) > 0) {
                        $DiasDeclImpoFechaAcept = CalcularDias($DiaHoy, ConvertFechaApi($data['DeclImpoFechaAcept']));
                        if ($DiasDeclImpoFechaAcept <= 0) {
                            if (strlen($data['FechaManifiesto']) == 0) {
                                $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaETA']), $DiaHoy);
                                //echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                                $RangoDias = DetectarRangoDias($DiasParaRango);
                                return array('EstadoCalculado' => 'PendArriboAcept', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                            }
                        }
                    }
                }
            }
        }
    }
    //Validar Pendiente Arribo – Aceptada

    //Validar Entrega Urgente Total
    if ($data['TipoNacionalizacion'] == 'Entrega Urgente Total') {
        $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaETA']), $DiaHoy);
        //echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
        $RangoDias = DetectarRangoDias($DiasParaRango);
        return array('EstadoCalculado' => 'EntregaUrgenteTotal', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
    }
    //Validar Entrega Urgente Total

    //Validar Finalizacion Entrega urgente
    if ($data['TipoNacionalizacion'] == 'Finalizacion Entrega urgente') {
        $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaETA']), $DiaHoy);
        //echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
        $RangoDias = DetectarRangoDias($DiasParaRango);
        return array('EstadoCalculado' => 'FinalizacionEntregaUrgente', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
    }

    //DevueltaPorContabilidad
    if (strlen($data['FechaEntrDoFact']) > 0 && strlen($data['DeclImpoFechaAcept']) > 0 && strlen($data['FechaManifiesto']) > 0 && strlen($data['FechaDespacho']) > 0 && strlen($data['FechaConsultaInventario']) > 0 && strlen($data['DeclImpoFechaLevante']) > 0 && strlen($data['FechaDevolucionFacturacion']) > 0 && strlen($data['FechaEntregaDoDevolucionFacturacion']) == 0) {
        $DiasParaRango = CalcularDias(ConvertFechaApi($data['FechaDevolucionFacturacion']), $DiaHoy);
        //DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DeclImpoFechaLevante'] . '<br>';
        $RangoDias = DetectarRangoDias($DiasParaRango);
        return array('EstadoCalculado' => 'DevueltaPorContabilidad', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
    }

    //DevueltaPorContabilidad

    //DevolucionFacturacion
    if (strlen($data['FechaEntrDoFact']) > 0 && strlen($data['DeclImpoFechaAcept']) > 0 && strlen($data['FechaManifiesto']) > 0 && strlen($data['FechaDespacho']) > 0 && strlen($data['FechaConsultaInventario']) > 0 && strlen($data['DeclImpoFechaLevante']) > 0 && strlen($data['FechaDevolucionFacturacion']) > 0 && strlen($data['FechaEntregaDoDevolucionFacturacion']) > 0) {
        $DiasParaRango = CalcularDias(ConvertFechaApi($data['FechaEntregaDoDevolucionFacturacion']), $DiaHoy);
        //DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DeclImpoFechaLevante'] . '<br>';
        $RangoDias = DetectarRangoDias($DiasParaRango);
        return array('EstadoCalculado' => 'DevolucionFacturacion', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
    }

    //DevolucionFacturacion

    //Enviada Facturacion Sin Facturar
    if (strlen($data['FechaEntrDoFact']) > 0 && strlen($data['DeclImpoFechaAcept']) > 0 && strlen($data['FechaManifiesto']) > 0 && strlen($data['FechaConsultaInventario']) > 0 && strlen($data['DeclImpoFechaLevante']) > 0) {
        $DiasParaRango = CalcularDias(ConvertFechaApi($data['FechaEntrDoFact']), $DiaHoy);
        //DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DeclImpoFechaLevante'] . '<br>';
        $RangoDias = DetectarRangoDias($DiasParaRango);
        return array('EstadoCalculado' => 'EnviadaFactSinFacturar', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
    }

    //Enviada Facturacion Sin Facturar

    // Gasto Posterior sin Enviar Facturacion
    if ($data['TipoNacionalizacion'] == 'Facturacion de Gasto Posterior') {
        if (strlen($data['FechaNacionalizacion']) > 0) {
            $DiasParaRango = CalcularDias(ConvertFechaApi($data['FechaNacionalizacion']), $DiaHoy);
            //DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DeclImpoFechaLevante'] . '<br>';
            $RangoDias = DetectarRangoDias($DiasParaRango);
            return array('EstadoCalculado' => 'GastoPostSinFacturar', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
            //  return array('EstadoCalculado' => 'GastoPostSinFacturar', 'DiasEstado' => $DiasParaRango,'ID'=>$data['ID']);

        }
    }
    // Gasto Posterior sin Enviar Facturacion

    // Con Despacho sin Envio Facturacion
    if (strlen($data['FechaNacionalizacion']) > 0 && strlen($data['FechaManifiesto']) > 0 && strlen($data['FechaConsultaInventario']) > 0 && strlen($data['DeclImpoFechaAcept']) > 0 && strlen($data['DeclImpoFechaLevante']) > 0) {
        $DiasNac               = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaNacionalizacion']));
        $DiasManifiesto        = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaManifiesto']));
        $DiaConsultaInventario = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaConsultaInventario']));
        $DiasAceptacion        = CalcularDias($DiaHoy, ConvertFechaApi($data['DeclImpoFechaAcept']));
        $DiasLevante           = CalcularDias($DiaHoy, ConvertFechaApi($data['DeclImpoFechaLevante']));

        if ($DiasNac <= 0 && $DiasManifiesto <= 0 && $DiaConsultaInventario <= 0 && $DiasAceptacion <= 0 && $DiasLevante <= 0) {
            if (strlen($data['FechaEntrDoFact']) == 0 && strlen($data['FechaDespacho']) > 0) {
                $DiasParaRango = CalcularDias(ConvertFechaApi($data['FechaDespacho']), $DiaHoy);
                //DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DeclImpoFechaLevante'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);
                return array('EstadoCalculado' => 'ConDSPSinEnvioFact', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
            }
        }
    }
    // Con Despacho sin Envio Facturacion

    //  Con Levante Sin Despacho con subestados
    if (strlen($data['FechaNacionalizacion']) > 0 && strlen($data['FechaManifiesto']) > 0 && strlen($data['FechaConsultaInventario']) > 0 && strlen($data['DeclImpoFechaAcept']) > 0 && strlen($data['DeclImpoFechaLevante']) > 0) {
        $DiasNac               = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaNacionalizacion']));
        $DiasManifiesto        = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaManifiesto']));
        $DiaConsultaInventario = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaConsultaInventario']));
        $DiasAceptacion        = CalcularDias($DiaHoy, ConvertFechaApi($data['DeclImpoFechaAcept']));
        $DiasLevante           = CalcularDias($DiaHoy, ConvertFechaApi($data['DeclImpoFechaLevante']));

        if ($DiasNac <= 0 && $DiasManifiesto <= 0 && $DiaConsultaInventario <= 0 && $DiasAceptacion <= 0 && $DiasLevante <= 0) {
            if (strlen($data['FechaEntrDoFact']) == 0 && strlen($data['FechaDespacho']) == 0) {
                $DiasParaRango = CalcularDias(ConvertFechaApi($data['DeclImpoFechaLevante']), $DiaHoy);
                //DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DeclImpoFechaLevante'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);
                if (strlen($data['FechaFacturacion']) > 0) {
                    return array('EstadoCalculado' => 'ConLevanteSinDespachoFacturado', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                }
                if (strlen($data['FechaEntregaApoyoOperativo']) > 0) {
                    return array('EstadoCalculado' => 'ConLevanteSinDespachoSinGenerarFact', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                }
                if (strlen($data['FechaEntrDoFact']) == 0) {
                    return array('EstadoCalculado' => 'ConLevanteSinDespachoSinPasarFact', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                }
                return array('EstadoCalculado' => 'ConLevanteSinDSP', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                // return array('EstadoCalculado' => 'ConLevanteSinDSP', 'DiasEstado' => $DiasParaRango,'ID'=>$data['ID']);
                // return 'ConLevanteSinDSP';
            }
        }
    }
    //  Con Levante Sin Despacho

    //  En Aceptacion y Pagos Sin Levante
    if (strlen($data['FechaNacionalizacion']) > 0 && strlen($data['FechaManifiesto']) > 0 && strlen($data['FechaConsultaInventario']) > 0 && strlen($data['DeclImpoFechaAcept']) > 0) {
        $DiasNac               = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaNacionalizacion']));
        $DiasManifiesto        = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaManifiesto']));
        $DiaConsultaInventario = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaConsultaInventario']));
        $DiasAceptacion        = CalcularDias($DiaHoy, ConvertFechaApi($data['DeclImpoFechaAcept']));

        if ($DiasNac <= 0 && $DiasManifiesto <= 0 && $DiaConsultaInventario <= 0 && $DiasAceptacion <= 0) {
            if (strlen($data['DeclImpoFechaLevante']) == 0 && strlen($data['FechaEntrDoFact']) == 0 && strlen($data['FechaDespacho']) == 0) {

                $DiasParaRango = CalcularDias(ConvertFechaApi(ConvertFechaApi($data['DeclImpoFechaAcept'])), $DiaHoy);
                //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);

                return array('EstadoCalculado' => 'EnAceptacionSinLevante', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);

                //return 'EnAceptacionSinLevante';
            }
        }
    }
    //  En Aceptacion y Pagos Sin Levante

    // En Elaboracion DIM
    if (strlen($data['FechaNacionalizacion']) > 0 && strlen($data['FechaManifiesto']) > 0 && strlen($data['FechaVisado']) == 0) {
        $DiasNac        = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaNacionalizacion']));
        $DiasManifiesto = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaManifiesto']));

        if ($DiasNac <= 0 && $DiasManifiesto <= 0) {
            if (strlen($data['DeclImpoFechaAcept']) == 0 && strlen($data['DeclImpoFechaLevante']) == 0 && strlen($data['FechaDespacho']) == 0 && strlen($data['FechaEntrDoFact']) == 0) {

                $DiasParaRango = CalcularDias(ConvertFechaApi(ConvertFechaApi($data['FechaManifiesto'])), $DiaHoy);
                //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);

                return array('EstadoCalculado' => 'EnElaboracionDIM', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);

                //return 'EnElaboracionDIM';
            }
        }
    }

    // En Elaboracion DIM

    // DIM Visada sin aceptar
    if (strlen($data['FechaNacionalizacion']) > 0 && strlen($data['FechaManifiesto']) > 0 && strlen($data['FechaVisado']) > 0) {
        $DiasNac        = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaNacionalizacion']));
        $DiasManifiesto = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaManifiesto']));
        $DiasVisado     = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaVisado']));
        if ($DiasNac <= 0 && $DiasManifiesto <= 0 && $DiasVisado <= 0) {
            if (strlen($data['DeclImpoFechaAcept']) == 0 && strlen($data['DeclImpoFechaLevante']) == 0 && strlen($data['FechaDespacho']) == 0 && strlen($data['FechaEntrDoFact']) == 0) {

                $DiasParaRango = CalcularDias(ConvertFechaApi($data['FechaVisado']), $DiaHoy);
                //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);

                return array('EstadoCalculado' => 'DIMVisadaSinAceptar', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);

                // return 'DIMVisadaSinAceptar';
            }
        }
    }
    //  En Aceptacion y Pagos Sin Levante

    // En Deposito Sin Pasar a Digitar
    if (strlen($data['FechaManifiesto']) > 0 && strlen($data['FechaConsultaInventario']) > 0) {

        $DiasManifiesto = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaManifiesto']));
        $DiasInventario = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaConsultaInventario']));
        if ($DiasManifiesto <= 0 && $DiasInventario <= 0) {
            if (strlen($data['FechaNacionalizacion']) == 0 && strlen($data['DeclImpoFechaAcept']) == 0 && strlen($data['DeclImpoFechaLevante']) == 0 && strlen($data['FechaDespacho']) == 0 && strlen($data['FechaEntrDoFact']) == 0) {

                $DiasParaRango = CalcularDias(ConvertFechaApi($data['FechaManifiesto']), $DiaHoy);
                //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);

                return array('EstadoCalculado' => 'EnDepositoSinPasarDigitar', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);

                //return 'EnDepositoSinPasarDigitar';
            }
        }
    }
    //  En Deposito Sin Pasar a Digitar

    // Con Manifiesto Sin Ingreso Deposito
    if (strlen($data['FechaManifiesto']) > 0) {

        $DiasManifiesto = CalcularDias($DiaHoy, ConvertFechaApi($data['FechaManifiesto']));

        if ($DiasManifiesto < 0) {
            if (strlen($data['FechaConsultaInventario']) == 0 && strlen($data['FechaNacionalizacion']) == 0 && strlen($data['DeclImpoFechaAcept']) == 0 && strlen($data['DeclImpoFechaLevante']) == 0 && strlen($data['FechaDespacho']) == 0 && strlen($data['FechaEntrDoFact']) == 0) {

                if (strlen($data['FechaManifiesto']) > 0) {
                    $FechaSelected = $data['FechaManifiesto'];
                } else {
                    $FechaSelected = $data['DocImpoFechaETA'];
                }
                $DiasParaRango = CalcularDias(ConvertFechaApi($FechaSelected), $DiaHoy);
                //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);
                if (strlen($data['Deposito']) == 0) {
                    $Estado = 'ConManifSinIngresoDeposito';
                } else {
                    $Estado = 'EnEsperaIntruccionCliente';
                }
                return array('EstadoCalculado' => $Estado, 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
            }
        }
    }
    //  Con Manifiesto Sin Ingreso Deposito

    // Arribo Hoy Sin Pasar a Digitar
    if (strlen($data['DocImpoFechaETA']) > 0 && strlen($data['DocImpoNoDocTransp']) > 0) {

        if ($DiaHoy == ConvertFechaApi($data['DocImpoFechaETA'])) {
            if (strlen($data['FechaNacionalizacion']) == 0) {
                if (strlen($data['FechaManifiesto']) > 0) {
                    $FechaSelected = $data['FechaManifiesto'];
                } else {
                    $FechaSelected = $data['DocImpoFechaETA'];
                }
                $DiasParaRango = CalcularDias(ConvertFechaApi($FechaSelected), $DiaHoy);
                //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);

                return array('EstadoCalculado' => 'ArriboHoySinPasarADigitar', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
            }
        }
    }
    //  Con Manifiesto Sin Ingreso Deposito

    // Arribo Hoy en Digitación
    if (strlen($data['DocImpoFechaETA']) > 0) {

        if ($DiaHoy == ConvertFechaApi($data['DocImpoFechaETA'])) {
            if (strlen($data['FechaNacionalizacion']) > 0) {
                if (strlen($data['FechaManifiesto']) > 0) {
                    $FechaSelected = $data['FechaManifiesto'];
                } else {
                    $FechaSelected = $data['DocImpoFechaETA'];
                }
                $DiasParaRango = CalcularDias(ConvertFechaApi($FechaSelected), $DiaHoy);
                //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);

                return array('EstadoCalculado' => 'ArriboHoyEnDigitacion', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
            }
        }
    }
    //  Arribo Hoy en Digitación

    // Pendiente Arribo
    if (strlen($data['DocImpoFechaETA']) > 0) {
        $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));
        if ($DiasEta > 0) {
            if (strlen($data['FechaNacionalizacion']) == 0 && strlen($data['FechaManifiesto']) == 0) {

                $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaETA']), $DiaHoy);
                // echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);

                return array('EstadoCalculado' => 'PendienteArribo', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
            }
        }
    }
    //  Pendiente Arribo

    // ETA 1900
    if (strlen($data['DocImpoFechaETA']) == 0) {

        if (strlen($data['FechaNacionalizacion']) == 0 && strlen($data['FechaManifiesto']) == 0) {

            $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaCrea']), $DiaHoy);
            // echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
            $RangoDias = DetectarRangoDias($DiasParaRango);

            return array('EstadoCalculado' => 'Eta1900', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
        }
    }
    //  ETA 1900

    // Anticipada con ETA Vencido
    if (strlen($data['DocImpoFechaETA']) > 0) {
        $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));
        if ($DiasEta <= 0) {
            if (strlen($data['FechaManifiesto']) == 0) {
                if (strlen($data['DeclImpoFechaAcept']) > 0) {

                    $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaETA']), $DiaHoy);
                    //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                    $RangoDias = DetectarRangoDias($DiasParaRango);

                    return array('EstadoCalculado' => 'AnticipadaConETAVencido', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
                }
            }
        }
    }
    //  Anticipada con ETA Vencido

    // Pendiente Actulizar Manifiesto
    if (strlen($data['DocImpoFechaETA']) > 0) {
        $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));
        if ($DiasEta <= 0) {
            if (strlen($data['FechaManifiesto']) == 0 && strlen($data['DeclImpoFechaAcept']) == 0) {

                $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaETA']), $DiaHoy);
                //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
                $RangoDias = DetectarRangoDias($DiasParaRango);
                return array('EstadoCalculado' => 'PendienteActulizarManifiesto', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
            }
        }
    }
    //  Pendiente Actulizar Manifiesto
    //
    // RevisarInfoParaDeterminarEstado
    if (strlen($data['DocImpoFechaETA']) > 0) {
        $DiasEta = CalcularDias($DiaHoy, ConvertFechaApi($data['DocImpoFechaETA']));

        $DiasParaRango = CalcularDias(ConvertFechaApi($data['DocImpoFechaETA']), $DiaHoy);
        //  echo DetectarRangoDias($DiasParaRango) . '|' . $DiasParaRango . '|' . $data['DocImpoFechaETA'] . '<br>';
        $RangoDias = DetectarRangoDias($DiasParaRango);
        return array('EstadoCalculado' => 'RevisarInfoParaDeterminarEstado', 'DiasEstado' => $DiasParaRango, 'ID' => $data['ID'], 'RangoEstado' => $RangoDias);
    }
    //  RevisarInfoParaDeterminarEstado

}

function ConvertFechaApi($Fecha)
{
    return $FechaResult = date('Y-m-d', strtotime($Fecha));

    // if ($FechaResult == '1969-12-31') {
    //     return '';
    // } else {
    //     return $FechaResult;
    // }
}

function contar_valores($a, $buscado)
{
    if (!is_array($a)) {
        return null;
    }

    $i = 0;
    foreach ($a as $v) {
        if ($buscado === $v) {
            $i++;
        }
    }

    return $i;
}

function DetectarRangoDias($Dias)
{

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

function DetectarPosicion($estadoSearch)
{

    $DataArray = array(
        'PendienteArribo'                 => 1,
        'PendArriboEndigita'              => 2,
        'PendArriboAcept'                 => 3,
        'PendArriboSinDocTransp'          => 4,
        'DtaSinArribar'                   => 5,
        'DtaEtaVencidoSinDSP'             => 6,
        'PendienteActulizarManifiesto'    => 7,
        'AnticipadaConETAVencido'         => 8,
        'ArriboHoySinPasarADigitar'       => 9,
        'ArriboHoyEnDigitacion'           => 10,
        'EnElaboracionDIM'                => 11,
        'DIMVisadaSinAceptar'             => 12,
        'ConManifSinIngresoDeposito'      => 13,
        'EnEsperaIntruccionCliente'       => 13,
        'EnDepositoSinPasarDigitar'       => 14,
        'EnAceptacionSinLevante'          => 15,
        'DtaConDSPSinFAC'                 => 16,
        'ConLevanteSinDespachoSinPasarFact' => 17,
        'ConLevanteSinDespachoSinGenerarFact' => 18,
        'ConLevanteSinDSP'                => 19,
        'ConLevanteSinDespachoFacturado'  => 20,
        'ConDSPSinEnvioFact'              => 21,
        'DtaSinGeneraFAC'                 => 22,
        'EnviadaFactSinFacturar'          => 23,
        'DevueltaPorContabilidad'         => 24,
        'DevolucionFacturacion'           => 25,
        'GastoPostSinFacturar'            => 26,
        'EntregaUrgenteTotal'             => 27,
        'FinalizacionEntregaUrgente'      => 28,
        'Eta1900'                         => 29,
        'RevisarInfoParaDeterminarEstado' => 30,
        ''                                => 31
    );

    return $DataArray[$estadoSearch];
}


function ValidarToken()
{
    $token     = $_POST['token'];
    $connMysql = connMysql();

    $SQL  = "  SELECT top 1* FROM tabc_so_ConfigApi WHERE token = ' $token' ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function CalcularDatosAdicionales()
{

    $connMysql      = connMysql();
    $FunctionsMySQL = new FunctionsMySQL();
    $SQL            = "SELECT * FROM imseguimientooperativo ";
    $stmt           = $connMysql->prepare($SQL);
    $stmt->execute();
    $result            = $stmt->fetchAll();
    $DatosActualizados = 0;
    if ($stmt->rowCount() > 0) {

        foreach ($result as $row) {
         
                if (strlen($row['FechaManifiesto']) > 0 && strlen($row['DeclImpoFechaLevante']) > 0) {
                    $arrayData = array(
                        'LlaveUnicaDO' => $row['LlaveUnicaDO'],
                        'Ejecutivo' => $row['Ejecutivo'],
                        'EjecutivoID' => $row['EjecutivoID'],
                        'JefeCuenta' => $row['JefeCuenta'],
                        'JefeCuentaID' => $row['JefeCuentaID'],
                        'Director' => $row['Director'],
                        'DirectorID' => $row['DirectorID'],
                        'ObsrvCliente' => $row['ObsrvCliente'],
                        'ObsrvBitacora' => $row['ObsrvBitacora'],
                        'ObsSeguimiento' => $row['ObsSeguimiento'],
                        'DocImpoNoDO' => $row['DocImpoNoDO'],
                        'DocImpoFechaCrea' => $row['DocImpoFechaCrea'],
                        'TipoNacionalizacion' => $row['TipoNacionalizacion'],
                        'OrdenNacID' => $row['OrdenNacID'],
                        'FechaNacionalizacion' => $row['FechaNacionalizacion'],
                        'Cliente' => $row['Cliente'],
                        'ClienteID' => $row['ClienteID'],
                        'DocImpoNoDoCliente' => $row['DocImpoNoDoCliente'],
                        'DocImpoNoDocTransp' => $row['DocImpoNoDocTransp'],
                        'DocImpoFechaETA' => $row['DocImpoFechaETA'],
                        'AdminAduanasNombre' => $row['AdminAduanasNombre'],
                        'ModoTransporte' => $row['ModoTransporte'],
                        'ModoTransporteID' => $row['ModoTransporteID'],
                        'FechaManifiesto' => $row['FechaManifiesto'],
                        'FechaConsultaInventario' => $row['FechaConsultaInventario'],
                        'FechaIngresoDeposito' => $row['FechaIngresoDeposito'],
                        'FechaReciboDocs' => $row['FechaReciboDocs'],
                        'FechaReciboDocsPuerto' => $row['FechaReciboDocsPuerto'],
                        'FechaSolicitudAnticipo' => $row['FechaSolicitudAnticipo'],
                        'FechaReciboAnticipo' => $row['FechaReciboAnticipo'],
                        'FechaSolicReconocimiento' => $row['FechaSolicReconocimiento'],
                        'FechaReconocimiento' => $row['FechaReconocimiento'],
                        'DeclImpoFechaAcept' => $row['DeclImpoFechaAcept'],
                        'DeclImpoFechaLevante' => $row['DeclImpoFechaLevante'],
                        'FechaDespacho' => $row['FechaDespacho'],
                        'FechaEntrDoFact' => $row['FechaEntrDoFact'],
                        'FechaFacturacion' => $row['FechaFacturacion'],
                        'FacturaRpc' => $row['FacturaRpc'],
                        'impo' => $row['impo'],
                        'valor' => $row['valor'],
                        'usuariopuerto' => $row['usuariopuerto'],
                        'OrdenNacnoDeServicio' => $row['OrdenNacnoDeServicio'],
                        'OrdenNacproductoImportado' => $row['OrdenNacproductoImportado'],
                        'OrdenNacbuque' => $row['OrdenNacbuque'],
                        'OrdenNacnaviera' => $row['OrdenNacnaviera'],
                        'OrdenNachblLiberado' => $row['OrdenNachblLiberado'],
                        'OrdenNacmblLiberado' => $row['OrdenNacmblLiberado'],
                        'OrdenNacFechaEnvioAcepatciones' => $row['OrdenNacFechaEnvioAcepatciones'],
                        'OrdenNacFechaPlanillaTransporte' => $row['OrdenNacFechaPlanillaTransporte'],
                        'OrdenNactransportadorid' => $row['OrdenNactransportadorid'],
                        'OrdenNacfFechaConfirmacionDespacho' => $row['OrdenNacfFechaConfirmacionDespacho'],
                        'OrdenNacenvioHojaCostosycuentaCompleta' => $row['OrdenNacenvioHojaCostosycuentaCompleta'],
                        'OrdenNacenvioHojaCostosyCuentaIncompleta' => $row['OrdenNacenvioHojaCostosyCuentaIncompleta'],
                        'OrdenNacFechaDepositoCNTCancelado' => $row['OrdenNacFechaDepositoCNTCancelado'],
                        'OrdenNacFechaDroppOFFCancelado' => $row['OrdenNacFechaDroppOFFCancelado'],
                        'OrdenNacFechaUsoInst' => $row['OrdenNacFechaUsoInst'],
                        'OrdenNacfechaAlmacenaje' => $row['OrdenNacfechaAlmacenaje'],
                        'OrdenNacfechaPagoHasta' => $row['OrdenNacfechaPagoHasta'],
                        'OrdenNacfechaReconoInvimaIca' => $row['OrdenNacfechaReconoInvimaIca'],
                        'Instruccion' => $row['Instruccion'],
                        'ContactoCliente' => $row['ContactoCliente'],
                        'FechaReciboDocumentos' => $row['FechaReciboDocumentos'],
                        'FechaCorteBL' => $row['FechaCorteBL'],
                        'MotoNave' => $row['MotoNave'],
                        'Deposito' => $row['Deposito'],
                        'TipoImportacion' => $row['TipoImportacion'],
                        'DescripcionMercancia' => $row['DescripcionMercancia'],
                        'PesoBruto' => $row['PesoBruto'],
                        'NumeroBultos' => $row['NumeroBultos'],
                        'FormaPago' => $row['FormaPago'],
                        'NumeroManifiesto' => $row['NumeroManifiesto'],
                        'FechaVisado' => $row['FechaVisado'],
                        'EstadoCalculado' => $row['EstadoCalculado'],
                        'DiasEstado' => $row['DiasEstado'],
                        'RangoEstado' => $row['RangoEstado'],
                        'OrdenEstado' => $row['OrdenEstado'],
                        'GrupoOperacion' => $row['GrupoOperacion'],
                        'ParcialNumero' => $row['ParcialNumero'],
                        'FechaEntregaDocumentosDespacho' => $row['FechaEntregaDocumentosDespacho'],
                        'FechaFormulario' => $row['FechaFormulario'],
                        'FechaEntregaApoyoOperativo' => $row['FechaEntregaApoyoOperativo'],
                        'FechaDevolucionFacturacion' => $row['FechaDevolucionFacturacion'],
                        'FechaEntregaDoDevolucionFacturacion' => $row['FechaEntregaDoDevolucionFacturacion'],
                        'DepositoZonaFranca' => $row['DepositoZonaFranca'],
                        'TerminalPortuario' => $row['TerminalPortuario'],
                        'DocImpoID' => $row['DocImpoID'],
                        'DocImpoEtaBot' => $row['DocImpoEtaBot'],
                        'TipoEmbalaje' => $row['TipoEmbalaje'],
                        'AplicaAnticipada' => $row['AplicaAnticipada'],
                        'PuertoLlegada' => $row['PuertoLlegada'],
                        'FechaActualizacion' => $row['FechaActualizacion'],
                        'fecha_cargado'  => date('Y-m-d H:i:s'),
                        'fecha_ingresado'  => date('Y-m-d')
                    );
                    $IDLevante = ValidarLevante($row['OrdenNacID'], $connMysql);
                    if ($IDLevante > 0) {
                        $arrayData['ID'] = $IDLevante;
                        unset($arrayData['fecha_cargado']);
                        unset($arrayData['fecha_ingresado']);
                        $FunctionsMySQL->Update($arrayData, 'tabc_hist_levantes', $connMysql);
                    } else if ($IDLevante == 0) {

                        $FunctionsMySQL->Insert($arrayData, 'tabc_hist_levantes', $connMysql);
                    }
                }
            
        }
    }
}


function ValidarLevante($OrdenNacID, $connMysql)
{

    $SQL  = "SELECT ID,FechaEntrDoFact FROM tabc_hist_levantes WHERE OrdenNacID='$OrdenNacID' ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data       = array();
    $FechasHtml = '';
    $row        = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        if (strlen($row['FechaEntrDoFact']) > 0) {
            return -1;
        } else {
            return $row['ID'];
        }
    } else {
        return 0;
    }
}

function VaciarTabla($Tabla, $connMysql)
{
    // return 1;
    try {
        $sql  = "TRUNCATE TABLE $Tabla ";
        $stmt = $connMysql->prepare($sql);
        $stmt->execute();

        return 1;
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo 2;
    }
    return 0;
}

function SincronizarTerminalesDepositos()
{

    $connMysql      = connMysql();
    $connMSSQL      = connMSSQL(entorno);
    $FunctionsMySQL = new FunctionsMySQL();
    VaciarTabla('tabc_so_DepositosTerminales', $connMysql);
    $params            = array();
    $options           = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $SQL1              = "SELECT * FROM [repecev2005].[dbo].[vNombreDepositoZonaFranca]";
    $stmt1             = sqlsrv_query($connMSSQL, $SQL1, $params, $options);
    $CantidadDepositos = sqlsrv_num_rows($stmt1);
    if ($CantidadDepositos > 0) {
        while ($row = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {
            if (strlen($row['DepMuellPuerzfID']) == 0 || strlen($row['CiudadNombreDep']) == 0) {
            } else {
                $ArraySQL = array(
                    'id_trk' => $row['DepMuellPuerzfID'],
                    'Nombre' => $row['CiudadNombreDep'],
                    'Tipo'   => 'ZF',

                );
                $FunctionsMySQL->Insert($ArraySQL, 'tabc_so_DepositosTerminales', $connMysql);
            }
        }
    }

    $SQL2               = "SELECT * FROM [repecev2005].[dbo].[vNombreDeposito]";
    $stmt2              = sqlsrv_query($connMSSQL, $SQL2, $params, $options);
    $CantidadTerminales = sqlsrv_num_rows($stmt2);
    $TotalRefeTax       = 0;
    if ($CantidadTerminales > 0) {

        while ($row = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
            if (strlen($row['DepMuellPuerID']) == 0 || strlen($row['CiudadNombreDep']) == 0) {
            } else {
                $ArraySQL = array(
                    'id_trk' => $row['DepMuellPuerID'],
                    'Nombre' => $row['CiudadNombreDep'],
                    'Tipo'   => 'TP',

                );
                $FunctionsMySQL->Insert($ArraySQL, 'tabc_so_DepositosTerminales', $connMysql);
            }
        }
    }
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

function InsertarHistorico()
{
    $FunctionsMySQL = new FunctionsMySQL();
    $connMysql      = connMysql();

    $SQL  = "SELECT  * FROM IMSeguimientoOperativo ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        $FechaRegistro = date('Y-m-d');
        $arrayData     = array(
            'DirectorID'      => $row['DirectorID'],
            'JefeCuentaID'    => $row['JefeCuentaID'],
            'EjecutivoID'     => $row['EjecutivoID'],
            'ClienteID'       => $row['ClienteID'],
            'GrupoOperacion'  => $row['GrupoOperacion'],
            'RangoEstado'     => $row['RangoEstado'],
            'FechaRegistro'   => $FechaRegistro,
            'DocImpoID'       => $row['DocImpoID'],
            'OrdenNacID'      => $row['OrdenNacID'],
            'EstadoCalculado' => $row['EstadoCalculado'],
            'GrupoEstado'     => $row['EstadoCalculado'],
        );

        $ValidarOperacion = ValidarOperacion($row['DocImpoID'], $row['OrdenNacID'], $FechaRegistro, $connMysql);
        if ($ValidarOperacion > 0) {
            $arrayData['ID'] = $ValidarOperacion;
            $FunctionsMySQL->Update($arrayData, 'tabc_so_HistoricoSegOpe', $connMysql);
        } else if ($ValidarOperacion == 0) {

            $FunctionsMySQL->Insert($arrayData, 'tabc_so_HistoricoSegOpe', $connMysql);
        }
    }
}

function ValidarOperacion($DocImpoID, $OrdenNacID, $FechaRegistro, $connMysql)
{

    if (strlen($OrdenNacID) > 0) {
        $ParametroSelect = "OrdenNacID='$OrdenNacID'";
    } else {
        $ParametroSelect = "DocImpoID='$DocImpoID'";
    }
    $SQL  = "SELECT ID FROM tabc_so_HistoricoSegOpe WHERE  $ParametroSelect  AND FechaRegistro='$FechaRegistro'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        return $row['ID'];
    } else {
        return 0;
    }
}


function SincronizarCorreosPersonal()
{
    $connMysql      = connMysql();
    $FunctionsMySQL = new FunctionsMySQL();
    $TipoUsers      = array('DirectorID', 'JefeCuentaID', 'EjecutivoID');
    foreach ($TipoUsers as $CampoUser) {
        $SQL  = "SELECT DISTINCT $CampoUser FROM IMSeguimientoOperativo ";
        $stmt = $connMysql->prepare($SQL);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {

            foreach ($result as $row) {

                $PersonaID = $row[$CampoUser];
                $CorreoTRK = TraerCorreoTRK($PersonaID);
                $arrayData = array(
                    'PersonaID'    => $PersonaID,
                    'PersonaEmail' => $CorreoTRK,
                );
                $ValidarCorreo = ValidarCorreo($PersonaID, $connMysql);
                //  print_r($ValidarCorreo);

                if ($ValidarCorreo['ID'] == false) {

                    $FunctionsMySQL->Insert($arrayData, 'tabc_so_UsuariosMail', $connMysql);
                } else if ($ValidarCorreo['PersonaEmail'] != $CorreoTRK) {
                    $arrayData['ID'] = $ValidarCorreo['ID'];
                    $FunctionsMySQL->Update($arrayData, 'tabc_so_UsuariosMail', $connMysql);
                }
            }
        }
    }
}

function TraerCorreoTRK($PersonaID)
{
    $FunctionsMySQL = new FunctionsMySQL();

    $connMSSQL = connMSSQL(entorno);
    $options   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $params    = array();
    $DataCopy  = array();
    $SQL       = "  SELECT PersonaEmail FROM [repecev2005].[dbo].[VEmpleadosTotal] WHERE PersonaID='$PersonaID'";
    $stmt      = sqlsrv_query($connMSSQL, $SQL, $params, $options);
    $Cantidad  = sqlsrv_num_rows($stmt);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        return $row['PersonaEmail'];
    }
}

function ValidarCorreo($PersonaID, $connMysql)
{

    $SQL  = "SELECT * FROM tabc_so_UsuariosMail WHERE PersonaID='$PersonaID' ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data       = array();
    $FechasHtml = '';
    $row        = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {

        $data['PersonaEmail'] = $row['PersonaEmail'];
        $data['ID']           = $row['ID'];
    } else {

        $data['ID'] = false;
    }
    return $data;
}
