<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function ExportarFile($connMysql)
{

    $DiaHoy = date('Y-m-d');
    $Campo = $_POST['Campo'];
    $Valor = $_POST['Valor'];
    $FiltroActivo = FiltroActivo();
    $EstadoCalculado = $_POST['Estado'];
    $GrupoOperacion = $_POST['GrupoOperacion'];
    $BtnSelected = $_POST['BtnSelected'];
    $TipoBtn = $_POST['TipoBtn'];
    if ($TipoBtn != 'AllData') {
        if ($Campo == 'TotalFila') {

            $ParametroFiltro = "$Valor AND EstadoCalculado='$EstadoCalculado' ORDER BY DocImpoNoDO ASC";
        } else {

            $ParametroFiltro = "EstadoCalculado='$EstadoCalculado' AND  $Campo ='$Valor' AND GrupoOperacion=$GrupoOperacion AND $FiltroActivo  ORDER BY DocImpoNoDO ASC  ";
        }
    } else {

        switch ($BtnSelected) {
            case 'TotalProcesos':
                $ParametroFiltro = "$FiltroActivo  ORDER BY DocImpoNoDO ASC";
                break;
            case 'FueraTiempo':
                $ParametroFiltro = "$FiltroActivo AND RangoEstado in ('De5a10','De11a15','De16a20','Mayora20')  AND GrupoOperacion = 0 ORDER BY DocImpoNoDO ASC";
                break;
            case 'SinEstado':
                $ParametroFiltro = "$FiltroActivo AND GrupoOperacion = 0 AND EstadoCalculado ='RevisarInfoParaDeterminarEstado' ORDER BY DocImpoNoDO ASC";
                break;
            case 'ATiempo':
                $ParametroFiltro = "$FiltroActivo AND RangoEstado in ('De0a4') AND GrupoOperacion = 0 ORDER BY DocImpoNoDO ASC";
                break;
            case 'SinArribar':
                $ParametroFiltro = "$FiltroActivo AND RangoEstado in ('MenorAMenos5','Menos1aMenos5') AND GrupoOperacion = 0 ORDER BY DocImpoNoDO ASC";
                break;
            case 'ZonaFranca':
            case 'Zona Franca':
                $ParametroFiltro = "$FiltroActivo AND GrupoOperacion = 1 ORDER BY DocImpoNoDO ASC ";
                break;
            case 'Por Arribar':
                $ParametroFiltro = "$FiltroActivo AND GrupoOperacion = 0 AND EstadoCalculado IN ('PendienteArribo','PendArriboEndigita','PendArriboAcept','PendArriboSinDocTransp','DtaSinArribar') ORDER BY DocImpoNoDO ASC";
                break;
            case 'En Proceso de Aduana':
                $ParametroFiltro = "$FiltroActivo AND GrupoOperacion = 0 AND EstadoCalculado IN ('DtaEtaVencidoSinDSP','PendienteActulizarManifiesto','AnticipadaConETAVencido','ArriboHoySinPasarADigitar','ArriboHoyEnDigitacion','EnElaboracionDIM','DIMVisadaSinAceptar','ConManifSinIngresoDeposito','EnEsperaIntruccionCliente','EnDepositoSinPasarDigitar','EnAceptacionSinLevante') ORDER BY DocImpoNoDO ASC ";
                break;
            case 'Proceso de Despacho y Pasar a Facturar':
                $ParametroFiltro = "$FiltroActivo AND GrupoOperacion = 0 AND EstadoCalculado IN ('DtaConDSPSinFAC','ConLevanteSinDSP','ConDSPSinEnvioFact') ORDER BY DocImpoNoDO ASC";
                break;
            case 'En proceso de Facturación':
                $ParametroFiltro = "$FiltroActivo AND GrupoOperacion = 0 AND EstadoCalculado IN ('DtaSinGeneraFAC','EnviadaFactSinFacturar','DevueltaPorContabilidad','DevolucionFacturacion' ORDER BY DocImpoNoDO ASC";
                break;
            case 'Otros Procesos':
                $ParametroFiltro = "$FiltroActivo AND GrupoOperacion = 0 AND EstadoCalculado IN ('GastoPostSinFacturar','EntregaUrgenteTotal','FinalizacionEntregaUrgente','Eta1900','RevisarInfoParaDeterminarEstado' ORDER BY DocImpoNoDO ASC";
                break;
            default:
                # code...
                break;
        }
    }
    $SQL = "SELECT  * FROM IMSeguimientoOperativo WHERE $ParametroFiltro  ";

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Resultados = $stmt->rowCount();
    $inputFileType = 'Xlsx';
    $PlantillaMail = 'classes/Excelinsert/plantillas/plantillaSeguimiento.xlsx';
    $reader = IOFactory::createReader($inputFileType);
    $sheet = $reader->load($PlantillaMail);
    $worksheet = $sheet->getSheetByName('Lista Operaciones');
    // $idInforme  = GuardarInforme($connection, 'Exportar Total', $Resultados);
    $result = $stmt->fetchAll();

    // if ($Resultados > 0) {
    $Fila = 1;

    foreach ($result as $row) {

        $Fila++;
        $DocImpoFechaCrea = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DocImpoFechaCrea'])
        );

        $DocImpoFechaETA = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DocImpoFechaETA'])
        );
        $FechaManifiesto = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaManifiesto'])
        );

        $FechaConsultaInventario = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaConsultaInventario'])
        );

        $FechaNacionalizacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaNacionalizacion'])
        );
        $FechaFormulario = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaFormulario'])
        );
        $FechaSolicReconocimiento = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaSolicReconocimiento'])
        );
        $FechaReconocimiento = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReconocimiento'])
        );
        $FechaReciboDocs = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboDocs'])
        );
        $FechaReciboDocumentos = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboDocumentos'])
        );
        $FechaVisado = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaVisado'])
        );
        $DeclImpoFechaAcept = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DeclImpoFechaAcept'])
        );
        $DeclImpoFechaLevante = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DeclImpoFechaLevante'])
        );
        $FechaEntregaDocumentosDespacho = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntregaDocumentosDespacho'])
        );
        $FechaDespacho = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaDespacho'])
        );
        $FechaReciboDocsPuerto = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboDocsPuerto'])
        );
        $FechaEntregaApoyoOperativo = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntregaApoyoOperativo'])
        );
        $FechaEntrDoFact = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntrDoFact'])
        );
        $FechaDevolucionFacturacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaDevolucionFacturacion'])
        );
        $FechaFacturacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaFacturacion'])
        );
        $FechaSolicitudAnticipo = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaSolicitudAnticipo'])
        );
        $FechaReciboAnticipo = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboAnticipo'])
        );
        $FechaEntregaDoDevolucionFacturacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntregaDoDevolucionFacturacion'])
        );

        $sheet->getActiveSheet()->setCellValue('A' . $Fila, $row['Cliente']);
        $sheet->getActiveSheet()->setCellValue('B' . $Fila, $row['DocImpoNoDO']);
        $sheet->getActiveSheet()->setCellValue('C' . $Fila, DetectarNombreEstado($row['EstadoCalculado']));
        $sheet->getActiveSheet()->setCellValue('D' . $Fila, $row['Ejecutivo']);
        $sheet->getActiveSheet()->setCellValue('E' . $Fila, $row['JefeCuenta']);
        $sheet->getActiveSheet()->setCellValue('F' . $Fila, $row['AdminAduanasNombre']);
        $sheet->getActiveSheet()->setCellValue('G' . $Fila, $row['ModoTransporte']);
        $sheet->getActiveSheet()->setCellValue('H' . $Fila, $row['DocImpoNoDoCliente']);
        $sheet->getActiveSheet()->setCellValue('I' . $Fila, $row['DocImpoNoDocTransp']);

        // Set cell A1 with the Formatted date/time value
        $sheet->getActiveSheet()->setCellValue('J' . $Fila, str_replace('FALSO', "", $DocImpoFechaCrea));
        // $sheet->getActiveSheet()->setCellValue('J' . $Fila, ConvertFechaExcell($row['DocImpoFechaCrea']));
        $sheet->getActiveSheet()->setCellValue('K' . $Fila, str_replace('FALSO', "", $DocImpoFechaETA));
        $sheet->getActiveSheet()->setCellValue('L' . $Fila, str_replace('FALSO', "", $FechaManifiesto));
        $sheet->getActiveSheet()->setCellValue('M' . $Fila, $row['NumeroManifiesto']);
        $sheet->getActiveSheet()->setCellValue('N' . $Fila, str_replace('FALSO', "", $FechaConsultaInventario));
        $sheet->getActiveSheet()->setCellValue('O' . $Fila, str_replace('FALSO', "", $FechaNacionalizacion));
        $sheet->getActiveSheet()->setCellValue('P' . $Fila, $row['TipoNacionalizacion']);
        $sheet->getActiveSheet()->setCellValue('Q' . $Fila, $row['OrdenNacID']);
        $sheet->getActiveSheet()->setCellValue('R' . $Fila, str_replace('FALSO', "", $FechaFormulario));
        $sheet->getActiveSheet()->setCellValue('S' . $Fila, str_replace('FALSO', "", $FechaSolicReconocimiento));
        $sheet->getActiveSheet()->setCellValue('T' . $Fila, str_replace('FALSO', "", $FechaReconocimiento));
        $sheet->getActiveSheet()->setCellValue('U' . $Fila, str_replace('FALSO', "", $FechaReciboDocs));
        $sheet->getActiveSheet()->setCellValue('V' . $Fila, str_replace('FALSO', "", $FechaReciboDocumentos));
        $sheet->getActiveSheet()->setCellValue('W' . $Fila, str_replace('FALSO', "", $FechaVisado));
        $sheet->getActiveSheet()->setCellValue('X' . $Fila, str_replace('FALSO', "", $DeclImpoFechaAcept));
        $sheet->getActiveSheet()->setCellValue('Y' . $Fila, str_replace('FALSO', "", $DeclImpoFechaLevante));
        $sheet->getActiveSheet()->setCellValue('Z' . $Fila, str_replace('FALSO', "", $FechaEntregaDocumentosDespacho));
        $sheet->getActiveSheet()->setCellValue('AA' . $Fila, str_replace('FALSO', "", $FechaDespacho));
        $sheet->getActiveSheet()->setCellValue('AB' . $Fila, str_replace('FALSO', "", $FechaReciboDocsPuerto));
        $sheet->getActiveSheet()->setCellValue('AC' . $Fila, str_replace('FALSO', "", $FechaEntregaApoyoOperativo));
        $sheet->getActiveSheet()->setCellValue('AD' . $Fila, str_replace('FALSO', "", $FechaEntrDoFact));
        $sheet->getActiveSheet()->setCellValue('AE' . $Fila, str_replace('FALSO', "", $FechaDevolucionFacturacion));
        $sheet->getActiveSheet()->setCellValue('AF' . $Fila, str_replace('FALSO', "", $FechaEntregaDoDevolucionFacturacion));
        $sheet->getActiveSheet()->setCellValue('AG' . $Fila, str_replace('FALSO', "", $FechaFacturacion));
        $sheet->getActiveSheet()->setCellValue('AH' . $Fila, str_replace('FALSO', "", $FechaSolicitudAnticipo));
        $sheet->getActiveSheet()->setCellValue('AI' . $Fila, str_replace('FALSO', "", $FechaReciboAnticipo));
        $sheet->getActiveSheet()->setCellValue('AJ' . $Fila, $row['ObsSeguimiento']);
        $sheet->getActiveSheet()->setCellValue('AK' . $Fila, $row['ObsrvBitacora']);
        $sheet->getActiveSheet()->setCellValue('AL' . $Fila, $row['ObsrvCliente']);
        $sheet->getActiveSheet()->setCellValue('AM' . $Fila, $row['DescripcionMercancia']);
        $sheet->getActiveSheet()->setCellValue('AN' . $Fila, TraductorTerminalDeposito($connMysql, $row['Deposito']));
        $sheet->getActiveSheet()->setCellValue('AO' . $Fila, TraductorTerminalDeposito($connMysql, $row['DepositoZonaFranca'], 'ZF'));
        $sheet->getActiveSheet()->setCellValue('AP' . $Fila, $row['ParcialNumero']);
        $sheet->getActiveSheet()->setCellValue('AQ' . $Fila, $row['OrdenNacnaviera']);
        $sheet->getActiveSheet()->setCellValue('AR' . $Fila, $row['OrdenNacbuque']);
        $sheet->getActiveSheet()->setCellValue('AS' . $Fila, $row['OrdenNacmblLiberado']);
        $sheet->getActiveSheet()->setCellValue('AT' . $Fila, $row['Contenedores']);
        $sheet->getActiveSheet()->setCellValue('AU' . $Fila, $row['NoRadicadoProrroga']);
        $sheet->getActiveSheet()->setCellValue('AV' . $Fila, $row['FechaRadicadoProrroga']);
        $sheet->getActiveSheet()->setCellValue('AW' . $Fila, $row['CantContenedores']);
        $sheet->getActiveSheet()->setCellValue('AX' . $Fila, $row['ContactoCliente']);
        $sheet->getActiveSheet()->setCellValue('AY' . $Fila, $row['OrdenCompra']);
        $sheet->getActiveSheet()->setCellValue('AZ' . $Fila, $row['DeliveryNote']);

        $sheet->getActiveSheet()->setCellValue('AX' . $Fila, $row['DocImpoFechaDocAnticipada']);
        $sheet->getActiveSheet()->setCellValue('AY' . $Fila, $row['DocImpoDocRecibidosAnt']);
        $sheet->getActiveSheet()->setCellValue('AZ' . $Fila, $row['DocImpoDocPendAnt']);
    }

    $dataArray = array();

    $NameDate = date('m_d_h_i') . '.xlsx';

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sheet);
    Header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    Header('Content-Disposition: attachment; filename="Seguimiento_operativo' . $NameDate . '"');
    Header('Cache-Control: cache, must-revalidate');
    ob_start();
    $writer->save('php://output');
    $xlsData = ob_get_contents();
    ob_end_clean();

    $response = array(
        'filename' => 'Seguimiento_operativo_' . str_replace(' ', '', $BtnSelected) . '_' . $NameDate . '',
        'op' => 'ok',
        'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($xlsData),
    );
    die(json_encode($response));
    //   return UpdateInformeFile($connection, $ruta_archivo, $Resultados, $idInforme);

}

function FileForMail($connMysql, $EjecutivoID, $idCierreDiario = null)
{

    $DiaHoy = date('Y-m-d');

    $idConverted = ($idCierreDiario == null) ? implode(", ", $_SESSION['IDSForMail']) : implode(", ", $idCierreDiario);
    $SQL = "SELECT  * FROM IMSeguimientoOperativo WHERE EjecutivoID='$EjecutivoID' AND  LlaveUnicaDO  in($idConverted)  ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Resultados = $stmt->rowCount();
    $inputFileType = 'Xlsx';
    $PlantillaMail = 'classes/Excelinsert/plantillas/plantillaSeguimiento.xlsx';
    $reader = IOFactory::createReader($inputFileType);
    $sheet = $reader->load($PlantillaMail);
    $worksheet = $sheet->getSheetByName('Lista Operaciones');
    // $idInforme  = GuardarInforme($connection, 'Exportar Total', $Resultados);
    $result = $stmt->fetchAll();

    // if ($Resultados > 0) {
    $Fila = 1;

    foreach ($result as $row) {

        $Fila++;
        $DocImpoFechaCrea = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DocImpoFechaCrea'])
        );

        $DocImpoFechaETA = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DocImpoFechaETA'])
        );
        $FechaManifiesto = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaManifiesto'])
        );

        $FechaConsultaInventario = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaConsultaInventario'])
        );

        $FechaNacionalizacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaNacionalizacion'])
        );
        $FechaFormulario = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaFormulario'])
        );
        $FechaSolicReconocimiento = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaSolicReconocimiento'])
        );
        $FechaReconocimiento = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReconocimiento'])
        );
        $FechaReciboDocs = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboDocs'])
        );
        $FechaReciboDocumentos = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboDocumentos'])
        );
        $FechaVisado = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaVisado'])
        );
        $DeclImpoFechaAcept = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DeclImpoFechaAcept'])
        );
        $DeclImpoFechaLevante = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DeclImpoFechaLevante'])
        );
        $FechaEntregaDocumentosDespacho = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntregaDocumentosDespacho'])
        );
        $FechaDespacho = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaDespacho'])
        );
        $FechaReciboDocsPuerto = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboDocsPuerto'])
        );
        $FechaEntregaApoyoOperativo = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntregaApoyoOperativo'])
        );
        $FechaEntrDoFact = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntrDoFact'])
        );
        $FechaDevolucionFacturacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaDevolucionFacturacion'])
        );
        $FechaFacturacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaFacturacion'])
        );
        $FechaSolicitudAnticipo = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaSolicitudAnticipo'])
        );
        $FechaReciboAnticipo = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboAnticipo'])
        );
        $FechaEntregaDoDevolucionFacturacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntregaDoDevolucionFacturacion'])
        );

        $sheet->getActiveSheet()->setCellValue('A' . $Fila, $row['Cliente']);
        $sheet->getActiveSheet()->setCellValue('B' . $Fila, $row['DocImpoNoDO']);
        $sheet->getActiveSheet()->setCellValue('C' . $Fila, DetectarNombreEstado($row['EstadoCalculado']));
        $sheet->getActiveSheet()->setCellValue('D' . $Fila, $row['Ejecutivo']);
        $sheet->getActiveSheet()->setCellValue('E' . $Fila, $row['JefeCuenta']);
        $sheet->getActiveSheet()->setCellValue('F' . $Fila, $row['AdminAduanasNombre']);
        $sheet->getActiveSheet()->setCellValue('G' . $Fila, $row['ModoTransporte']);
        $sheet->getActiveSheet()->setCellValue('H' . $Fila, $row['DocImpoNoDoCliente']);
        $sheet->getActiveSheet()->setCellValue('I' . $Fila, $row['DocImpoNoDocTransp']);

        // Set cell A1 with the Formatted date/time value
        $sheet->getActiveSheet()->setCellValue('J' . $Fila, str_replace('FALSO', "", $DocImpoFechaCrea));
        // $sheet->getActiveSheet()->setCellValue('J' . $Fila, ConvertFechaExcell($row['DocImpoFechaCrea']));
        $sheet->getActiveSheet()->setCellValue('K' . $Fila, str_replace('FALSO', "", $DocImpoFechaETA));
        $sheet->getActiveSheet()->setCellValue('L' . $Fila, str_replace('FALSO', "", $FechaManifiesto));
        $sheet->getActiveSheet()->setCellValue('M' . $Fila, $row['NumeroManifiesto']);
        $sheet->getActiveSheet()->setCellValue('N' . $Fila, str_replace('FALSO', "", $FechaConsultaInventario));
        $sheet->getActiveSheet()->setCellValue('O' . $Fila, str_replace('FALSO', "", $FechaNacionalizacion));
        $sheet->getActiveSheet()->setCellValue('P' . $Fila, $row['TipoNacionalizacion']);
        $sheet->getActiveSheet()->setCellValue('Q' . $Fila, $row['OrdenNacID']);
        $sheet->getActiveSheet()->setCellValue('R' . $Fila, str_replace('FALSO', "", $FechaFormulario));
        $sheet->getActiveSheet()->setCellValue('S' . $Fila, str_replace('FALSO', "", $FechaSolicReconocimiento));
        $sheet->getActiveSheet()->setCellValue('T' . $Fila, str_replace('FALSO', "", $FechaReconocimiento));
        $sheet->getActiveSheet()->setCellValue('U' . $Fila, str_replace('FALSO', "", $FechaReciboDocs));
        $sheet->getActiveSheet()->setCellValue('V' . $Fila, str_replace('FALSO', "", $FechaReciboDocumentos));
        $sheet->getActiveSheet()->setCellValue('W' . $Fila, str_replace('FALSO', "", $FechaVisado));
        $sheet->getActiveSheet()->setCellValue('X' . $Fila, str_replace('FALSO', "", $DeclImpoFechaAcept));
        $sheet->getActiveSheet()->setCellValue('Y' . $Fila, str_replace('FALSO', "", $DeclImpoFechaLevante));
        $sheet->getActiveSheet()->setCellValue('Z' . $Fila, str_replace('FALSO', "", $FechaEntregaDocumentosDespacho));
        $sheet->getActiveSheet()->setCellValue('AA' . $Fila, str_replace('FALSO', "", $FechaDespacho));
        $sheet->getActiveSheet()->setCellValue('AB' . $Fila, str_replace('FALSO', "", $FechaReciboDocsPuerto));
        $sheet->getActiveSheet()->setCellValue('AC' . $Fila, str_replace('FALSO', "", $FechaEntregaApoyoOperativo));
        $sheet->getActiveSheet()->setCellValue('AD' . $Fila, str_replace('FALSO', "", $FechaEntrDoFact));
        $sheet->getActiveSheet()->setCellValue('AE' . $Fila, str_replace('FALSO', "", $FechaDevolucionFacturacion));
        $sheet->getActiveSheet()->setCellValue('AF' . $Fila, str_replace('FALSO', "", $FechaEntregaDoDevolucionFacturacion));
        $sheet->getActiveSheet()->setCellValue('AG' . $Fila, str_replace('FALSO', "", $FechaFacturacion));
        $sheet->getActiveSheet()->setCellValue('AH' . $Fila, str_replace('FALSO', "", $FechaSolicitudAnticipo));
        $sheet->getActiveSheet()->setCellValue('AI' . $Fila, str_replace('FALSO', "", $FechaReciboAnticipo));
        $sheet->getActiveSheet()->setCellValue('AJ' . $Fila, $row['ObsSeguimiento']);
        $sheet->getActiveSheet()->setCellValue('AK' . $Fila, $row['ObsrvBitacora']);
        $sheet->getActiveSheet()->setCellValue('AL' . $Fila, $row['ObsrvCliente']);
        $sheet->getActiveSheet()->setCellValue('AM' . $Fila, $row['DescripcionMercancia']);
        $sheet->getActiveSheet()->setCellValue('AN' . $Fila, TraductorTerminalDeposito($connMysql, $row['Deposito']));
        $sheet->getActiveSheet()->setCellValue('AO' . $Fila, TraductorTerminalDeposito($connMysql, $row['DepositoZonaFranca']));
        $sheet->getActiveSheet()->setCellValue('AP' . $Fila, $row['ParcialNumero']);
        $sheet->getActiveSheet()->setCellValue('AQ' . $Fila, $row['OrdenNacnaviera']);
        $sheet->getActiveSheet()->setCellValue('AR' . $Fila, $row['OrdenNacbuque']);
        $sheet->getActiveSheet()->setCellValue('AS' . $Fila, $row['OrdenNacmblLiberado']);
    }

    $dataArray = array();

    $NameDate = date('m_d_h_i') . '.xlsx';

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sheet);
    $NombreFile = 'AlertaSeguimiento_Operativo_' . $EjecutivoID . '_' . $NameDate;
    $writer->save("archivos/$NombreFile");

    return "archivos/$NombreFile";
}

function ConvertFechaExcell($Fecha)
{
    $FechaResult = date('Y-m-d', strtotime($Fecha));
    if ($FechaResult == '1969-12-31') {

        return '';
    } else {
        if ($Fecha == '') {
            return '';
        } else {
            return date('d/m/Y H:i', strtotime($Fecha));
        }
    }
}

function DowloadAnalitics($connMysql)
{

    $FechaInformeAnalitics = $_POST['FechaInformeAnalitics'];
    $FechaRows = explode('to', $FechaInformeAnalitics);
    if (isset($FechaRows[0]) && isset($FechaRows[1])) {
        $FechaIni = $FechaRows[0] . ' 00:00:00';
        $FechaFin = $FechaRows[1] . ' 23:59:59';
        $ParamRango = "created between  '$FechaIni' AND '$FechaFin'";
    } else {
        $ParamRango = "created between  '$FechaInformeAnalitics  00:00:00' AND '$FechaInformeAnalitics  23:59:59'";
    }
    $SQL = "SELECT  * FROM tabc_so_analitycs  WHERE  $ParamRango ";

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Resultados = $stmt->rowCount();
    $inputFileType = 'Xlsx';
    $PlantillaMail = 'classes/Excelinsert/plantillas/plantillaAnalitics.xlsx';
    $reader = IOFactory::createReader($inputFileType);
    $sheet = $reader->load($PlantillaMail);
    $worksheet = $sheet->getSheetByName('Analitics');
    // $idInforme  = GuardarInforme($connection, 'Exportar Total', $Resultados);
    $result = $stmt->fetchAll();

    // if ($Resultados > 0) {
    $Fila = 1;

    foreach ($result as $row) {

        $Fila++;
        $created = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['created'])
        );

        $sheet->getActiveSheet()->setCellValue('A' . $Fila, $row['UserID']);
        $sheet->getActiveSheet()->setCellValue('B' . $Fila, $row['UsuarioLogueado']);
        $sheet->getActiveSheet()->setCellValue('C' . $Fila, $row['TipoActividad']);
        $sheet->getActiveSheet()->setCellValue('D' . $Fila, $created);
    }

    $dataArray = array();

    $NameDate = date('m_d_h_i') . '.xlsx';

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sheet);
    Header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    Header('Content-Disposition: attachment; filename="AnaliticsSeguimiento_' . $NameDate . '"');
    Header('Cache-Control: cache, must-revalidate');
    ob_start();
    $writer->save('php://output');
    $xlsData = ob_get_contents();
    ob_end_clean();

    $response = array(
        'filename' => 'AnaliticsSeguimiento_' . $NameDate . '',
        'op' => 'ok',
        'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($xlsData),
        'SQL' => $SQL,
    );
    die(json_encode($response));
    //   return UpdateInformeFile($connection, $ruta_archivo, $Resultados, $idInforme);

}

function DescargarExcelKPI($connMysql)
{

    $FiltroActivo = FiltroActivo();
    $ClienteID = $_POST['ClienteID'];
    $ParamFecha = ReturnRangoKpi();
    $ParamCampo = ($_POST['TipoBusqueda'] == 'Clientes') ? 'ClienteID' : 'EjecutivoID';
    $SQL = "SELECT  * FROM tabc_hist_levantes WHERE  $ParamCampo='$ClienteID'  $ParamFecha ";
    // return $SQL;
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Resultados = $stmt->rowCount();
    $inputFileType = 'Xlsx';
    $PlantillaMail = 'classes/Excelinsert/plantillas/plantillaSeguimientoKpi.xlsx';
    $reader = IOFactory::createReader($inputFileType);
    $sheet = $reader->load($PlantillaMail);
    $worksheet = $sheet->getSheetByName('Lista Operaciones');
    // $idInforme  = GuardarInforme($connection, 'Exportar Total', $Resultados);
    $result = $stmt->fetchAll();

    // if ($Resultados > 0) {
    $Fila = 1;

    foreach ($result as $row) {

        $Fila++;
        $DocImpoFechaCrea = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DocImpoFechaCrea'])
        );

        $DocImpoFechaETA = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DocImpoFechaETA'])
        );
        $FechaManifiesto = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaManifiesto'])
        );

        $FechaConsultaInventario = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaConsultaInventario'])
        );

        $FechaNacionalizacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaNacionalizacion'])
        );
        $FechaFormulario = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaFormulario'])
        );
        $FechaSolicReconocimiento = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaSolicReconocimiento'])
        );
        $FechaReconocimiento = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReconocimiento'])
        );
        $FechaReciboDocs = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboDocs'])
        );
        $FechaReciboDocumentos = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboDocumentos'])
        );
        $FechaVisado = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaVisado'])
        );
        $DeclImpoFechaAcept = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DeclImpoFechaAcept'])
        );
        $DeclImpoFechaLevante = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['DeclImpoFechaLevante'])
        );
        $FechaEntregaDocumentosDespacho = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntregaDocumentosDespacho'])
        );
        $FechaDespacho = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaDespacho'])
        );
        $FechaReciboDocsPuerto = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboDocsPuerto'])
        );
        $FechaEntregaApoyoOperativo = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntregaApoyoOperativo'])
        );
        $FechaEntrDoFact = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntrDoFact'])
        );
        $FechaDevolucionFacturacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaDevolucionFacturacion'])
        );
        $FechaFacturacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaFacturacion'])
        );
        $FechaSolicitudAnticipo = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaSolicitudAnticipo'])
        );
        $FechaReciboAnticipo = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaReciboAnticipo'])
        );
        $FechaEntregaDoDevolucionFacturacion = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
            ConvertFechaExcell($row['FechaEntregaDoDevolucionFacturacion'])
        );

        $sheet->getActiveSheet()->setCellValue('A' . $Fila, $row['Cliente']);
        $sheet->getActiveSheet()->setCellValue('B' . $Fila, $row['DocImpoNoDO']);
        $sheet->getActiveSheet()->setCellValue('C' . $Fila, DetectarNombreEstado($row['EstadoCalculado']));
        $sheet->getActiveSheet()->setCellValue('D' . $Fila, $row['Ejecutivo']);
        $sheet->getActiveSheet()->setCellValue('E' . $Fila, $row['JefeCuenta']);
        $sheet->getActiveSheet()->setCellValue('F' . $Fila, $row['AdminAduanasNombre']);
        $sheet->getActiveSheet()->setCellValue('G' . $Fila, $row['ModoTransporte']);
        $sheet->getActiveSheet()->setCellValue('H' . $Fila, $row['DocImpoNoDoCliente']);
        $sheet->getActiveSheet()->setCellValue('I' . $Fila, $row['DocImpoNoDocTransp']);

        // Set cell A1 with the Formatted date/time value
        $sheet->getActiveSheet()->setCellValue('J' . $Fila, str_replace('FALSO', "", $DocImpoFechaCrea));
        // $sheet->getActiveSheet()->setCellValue('J' . $Fila, ConvertFechaExcell($row['DocImpoFechaCrea']));
        $sheet->getActiveSheet()->setCellValue('K' . $Fila, str_replace('FALSO', "", $DocImpoFechaETA));
        $sheet->getActiveSheet()->setCellValue('L' . $Fila, str_replace('FALSO', "", $FechaManifiesto));
        $sheet->getActiveSheet()->setCellValue('M' . $Fila, $row['NumeroManifiesto']);
        $sheet->getActiveSheet()->setCellValue('N' . $Fila, str_replace('FALSO', "", $FechaConsultaInventario));
        $sheet->getActiveSheet()->setCellValue('O' . $Fila, str_replace('FALSO', "", $FechaNacionalizacion));
        $sheet->getActiveSheet()->setCellValue('P' . $Fila, $row['TipoNacionalizacion']);
        $sheet->getActiveSheet()->setCellValue('Q' . $Fila, $row['OrdenNacID']);
        $sheet->getActiveSheet()->setCellValue('R' . $Fila, str_replace('FALSO', "", $FechaFormulario));
        $sheet->getActiveSheet()->setCellValue('S' . $Fila, str_replace('FALSO', "", $FechaSolicReconocimiento));
        $sheet->getActiveSheet()->setCellValue('T' . $Fila, str_replace('FALSO', "", $FechaReconocimiento));
        $sheet->getActiveSheet()->setCellValue('U' . $Fila, str_replace('FALSO', "", $FechaReciboDocs));
        $sheet->getActiveSheet()->setCellValue('V' . $Fila, str_replace('FALSO', "", $FechaReciboDocumentos));
        $sheet->getActiveSheet()->setCellValue('W' . $Fila, str_replace('FALSO', "", $FechaVisado));
        $sheet->getActiveSheet()->setCellValue('X' . $Fila, str_replace('FALSO', "", $DeclImpoFechaAcept));
        $sheet->getActiveSheet()->setCellValue('Y' . $Fila, str_replace('FALSO', "", $DeclImpoFechaLevante));
        $sheet->getActiveSheet()->setCellValue('Z' . $Fila, str_replace('FALSO', "", $FechaEntregaDocumentosDespacho));
        $sheet->getActiveSheet()->setCellValue('AA' . $Fila, str_replace('FALSO', "", $FechaDespacho));
        $sheet->getActiveSheet()->setCellValue('AB' . $Fila, str_replace('FALSO', "", $FechaReciboDocsPuerto));
        $sheet->getActiveSheet()->setCellValue('AC' . $Fila, str_replace('FALSO', "", $FechaEntregaApoyoOperativo));
        $sheet->getActiveSheet()->setCellValue('AD' . $Fila, str_replace('FALSO', "", $FechaEntrDoFact));
        $sheet->getActiveSheet()->setCellValue('AE' . $Fila, str_replace('FALSO', "", $FechaDevolucionFacturacion));
        $sheet->getActiveSheet()->setCellValue('AF' . $Fila, str_replace('FALSO', "", $FechaEntregaDoDevolucionFacturacion));
        $sheet->getActiveSheet()->setCellValue('AG' . $Fila, str_replace('FALSO', "", $FechaFacturacion));
        $sheet->getActiveSheet()->setCellValue('AH' . $Fila, str_replace('FALSO', "", $FechaSolicitudAnticipo));
        $sheet->getActiveSheet()->setCellValue('AI' . $Fila, str_replace('FALSO', "", $FechaReciboAnticipo));
        $sheet->getActiveSheet()->setCellValue('AJ' . $Fila, $row['ObsSeguimiento']);
        $sheet->getActiveSheet()->setCellValue('AK' . $Fila, $row['ObsrvBitacora']);
        $sheet->getActiveSheet()->setCellValue('AL' . $Fila, $row['ObsrvCliente']);
        $sheet->getActiveSheet()->setCellValue('AM' . $Fila, $row['DescripcionMercancia']);
        $sheet->getActiveSheet()->setCellValue('AN' . $Fila, TraductorTerminalDeposito($connMysql, $row['Deposito']));
        $sheet->getActiveSheet()->setCellValue('AO' . $Fila, TraductorTerminalDeposito($connMysql, $row['DepositoZonaFranca']));
        $sheet->getActiveSheet()->setCellValue('AP' . $Fila, $row['ParcialNumero']);
        $sheet->getActiveSheet()->setCellValue('AQ' . $Fila, $row['OrdenNacnaviera']);
        $sheet->getActiveSheet()->setCellValue('AR' . $Fila, $row['OrdenNacbuque']);
        $sheet->getActiveSheet()->setCellValue('AS' . $Fila, $row['OrdenNacmblLiberado']);
    }

    $dataArray = array();

    $NameDate = date('m_d_h_i') . '.xlsx';

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sheet);
    Header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    Header('Content-Disposition: attachment; filename="Seguimiento_operativo' . $NameDate . '"');
    Header('Cache-Control: cache, must-revalidate');
    ob_start();
    $writer->save('php://output');
    $xlsData = ob_get_contents();
    ob_end_clean();

    $response = array(
        'filename' => 'Kpis_operativo_' . str_replace(' ', '', 'EstadoKpis') . '_' . $NameDate . '',
        'op' => 'ok',
        'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($xlsData),
    );
    die(json_encode($response));
    //   return UpdateInformeFile($connection, $ruta_archivo, $Resultados, $idInforme);

}

function ReturnarResultado($connMysql, $IdKpi, $IdLevante)
{
    $SQL = " SELECT * FROM tabc_so_resultadoskpis WHERE  IdKpi='$IdKpi' AND IdLevante = '$IdLevante'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['ID'];
    } else {
        return false;
    }
}

function ValidarKpis($connMysql, $FechaCampo)
{

    $SQL = " SELECT * FROM tabc_so_fechaskpis WHERE CampoFecha='$FechaCampo' ORDER BY id ASC ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result[0]['TituloCampo'];
}
