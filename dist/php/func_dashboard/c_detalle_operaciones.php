<?php
function DetalleDO($connMysql)
{

    unset($_SESSION['SessionIDS']);
    unset($_SESSION['IDSForMail']);

    $DiaHoy          = date('Y-m-d');
    $Campo           = $_POST['Campo'];
    $Valor           = $_POST['Valor'];
    $FiltroActivo    = FiltroActivo();
    $EstadoCalculado = $_POST['Estado'];
    $GrupoOperacion  = $_POST['GrupoOperacion'];
    $CampoSort       = str_replace('Tit', '', $_POST['CampoSort']);
    $TipoSort        = $_POST['TipoSort'];
    require 'sortVariables.php';

    if ($Campo == 'TotalFila') {
        $ParametroFiltro = "$FiltroActivo  AND $Valor AND EstadoCalculado='$EstadoCalculado' ORDER BY $CampoSort $TipoSort";
    } else {

        $ParametroFiltro = "EstadoCalculado='$EstadoCalculado' AND  $Campo ='$Valor' AND GrupoOperacion=$GrupoOperacion AND $FiltroActivo  ORDER BY $CampoSort $TipoSort  ";
    }
    $SQL  = "SELECT  * FROM IMSeguimientoOperativo WHERE  $ParametroFiltro ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result   = $stmt->fetchAll();
    $data     = array();
    $html     = '';
    $Cantidad = $stmt->rowCount();
    if ($stmt->rowCount() > 0) {

        $DoTit                         = '<th  title="#DO" class="HidenLarge">#DO</th>';
        $ClienteTi                     = '<th  title="Cliente" class="HidenLarge">Cliente</th>';
        $EtaTit                        = '<th  title="Eta" class="HidenLarge"><a title="' . $title01 . '" class="text-primary BtnSort ' . $SortClass01 . '" id="DocImpoFechaETATit"  href="javascript:void(0);">' . $Icono01 . ' Eta </a></th>';
        $DiasEtaTit                    = '<th  title="Dias Eta Hoy" class="HidenLarge"> Dias Eta Hoy</th>';
        $FechaCraDoTit                 = '<th  title="Fecha Creación Do" class="HidenLarge"><a title="' . $title02 . '" class="text-primary BtnSort ' . $SortClass02 . '" id="DocImpoFechaCreaTit" href="javascript:void(0);">' . $Icono02 . ' Fecha Crea Do</a></th>';
        $AdminTit                      = '<th  title="Admin" class="HidenLarge">Admin</th>';
        $DepositoTit                   = '<th  title="Deposito" class="HidenLarge">Deposito</th>';
        $EmbalajeTit                   = '<th  title="Embalaje" class="HidenLarge">Embalaje</th>';
        $AplicaAnticipadaTit           = '<th  title="Aplica Anticipada" class="HidenLarge">Aplica Anticipada</th>';
        $PrtOrigTit                    = '<th  title="Puerto Origen" class="HidenLarge">Puerto Origen</th>';
        $SolicitudAntiTit              = '<th  title="Solicitud Anticipo" class="HidenLarge">Solicitud Anticipo</th>';
        $RecibeAticipoTit              = '<th  title="Recibe Anticipo" class="HidenLarge">Recibe Anticipo</th>';
        $ObsSegTit                     = '<th  title="Obs Seguimiento" class="ShowLarge">Obs Seguimiento</th>';
        $ObsBitTit                     = '<th  title="Obs Bitacora" class="ShowLarge">Obs Bitacora</th>';
        $ObsClienteTit                 = '<th  title="Obs Cliente" class="ShowLarge">Obs Cliente</th>';
        $FechaNaciTit                  = '<th  title="Fecha Nacionalización" class="HidenLarge"><a title="' . $title03 . '" class="text-primary BtnSort ' . $SortClass03 . '" id="FechaNacionalizacionTit" href="javascript:void(0);">' . $Icono03 . ' Fecha Nacionalización</a></th>';
        $FechaAcepTit                  = '<th title="Fecha Aceptación"  class="HidenLarge"><a title="' . $title04 . '" class="text-primary BtnSort ' . $SortClass04 . '" id="DeclImpoFechaAceptTit" href="javascript:void(0);">' . $Icono04 . ' Fecha Aceptación</a></th>';
        $FechaReciboDocsTit            = '<th title="Fecha Recibo Docs"  class="HidenLarge"><a title="' . $title05 . '" class="text-primary BtnSort ' . $SortClass05 . '" id="FechaReciboDocsTit" href="javascript:void(0);">' . $Icono05 . '</span> Fecha Recibo Docs</a></th>';
        $FechaMAnifiesTit              = '<th title="Fecha Manifiesto"  class="HidenLarge"><a title="' . $title06 . '" class="text-primary BtnSort ' . $SortClass06 . '" id="FechaManifiestoTit" href="javascript:void(0);">' . $Icono06 . ' Fecha Manifiesto</a></th>';
        $FechaIngDepTit                = '<th  title="Fecha Ingreso Deposito" class="HidenLarge"><a title="' . $title07 . '" class="text-primary BtnSort ' . $SortClass07 . '" id="FechaIngresoDepositoTit" href="javascript:void(0);">' . $Icono07 . ' Fecha Ing Deposito</a></th>';
        $FormaPagoTit                  = '<th  title="Forma Pago" class="HidenLarge">Forma Pago</th>';
        $FechaLEvanteTit               = '<th  title="Fecha Levante" class="HidenLarge"><a title="' . $title08 . '" class="text-primary BtnSort ' . $SortClass08 . '" id="DeclImpoFechaLevanteTit" href="javascript:void(0);">' . $Icono08 . ' Fecha Levante</a></th>';
        $DiasMainfTit                  = '<th  title="Dias Manifiesto Hoy" class="HidenLarge"> Dias Manif Hoy</th>';
        $FechaDespachoTit              = '<th  title="Fecha despacho" class="HidenLarge"><a title="' . $title09 . '" class="text-primary BtnSort ' . $SortClass09 . '" id="FechaDespachoTit" href="javascript:void(0);">' . $Icono09 . ' Fecha despacho</a></th>';
        $FechaEnvioFacTit              = '<th  title="Fecha Envio Facturación" class="HidenLarge"><a title="' . $title10 . '" class="text-primary BtnSort ' . $SortClass10 . '" id="FechaEntrDoFactTit" href="javascript:void(0);">' . $Icono10 . 'Fecha Envio Fact</a></th>';
        $FechaDevolucionFacturacionTit = '<th  title="Fecha Devolución Facturación" class="HidenLarge"><a title="' . $title11 . '" class="text-primary BtnSort ' . $SortClass11 . '" id="FechaDevolucionFacturacionTit" href="javascript:void(0);">' . $Icono11 . ' Fecha Devolución Fact</a></th>';
        if ($_POST['Lista'] == 'NO') {

            switch ($EstadoCalculado) {
                case 'PendienteArribo':
                case 'PendArriboEndigita':
                case 'PendArriboAcept':
                case 'PendArriboSinDocTransp':
                case 'DtaSinArribar':
                case 'PendienteActulizarManifiesto':
                    $TituloFecha = '<th width="26%"><a title="' . $title01 . '" class="text-primary BtnSort ' . $SortClass01 . '" id="DocImpoFechaETATit"  href="javascript:void(0);">' . $Icono01 . ' Eta </a></th>';
                    break;

                case 'AnticipadaConETAVencido':
                case 'ArriboHoySinPasarADigitar':
                case 'ArriboHoyEnDigitacion':
                case 'EnElaboracionDIM':
                case 'ConManifSinIngresoDeposito':
                case 'EnAceptacionSinLevante':
                case 'EnDepositoSinPasarDigitar':
                case 'DIMVisadaSinAceptar':
                    $TituloFecha = '<th width="26%"><a title="' . $title06 . '" class="text-primary BtnSort ' . $SortClass06 . '" id="FechaManifiestoTit" href="javascript:void(0);">' . $Icono06 . 'Fecha Manifiesto</a></th>';
                    break;

                case 'ConLevanteSinDSP':
                case 'DtaConDSPSinFAC':
                    $TituloFecha = '<th width="26%"><a title="' . $title08 . '" class="text-primary BtnSort ' . $SortClass08 . '" id="DeclImpoFechaLevanteTit" href="javascript:void(0);">' . $Icono08 . 'Fecha Levante</a></th>';
                    break;
                case 'ConDSPSinEnvioFact':
                    $TituloFecha = '<th width="26%"><a title="' . $title09 . '" class="text-primary BtnSort ' . $SortClass09 . '" id="FechaDespachoTit" href="javascript:void(0);">' . $Icono09 . 'Fecha despacho</a></th>';
                    break;

                case 'DtaSinGeneraFAC':
                case 'EnviadaFactSinFacturar':
                case 'DevueltaPorContabilidad':
                case 'DevolucionFacturacion':
                    $TituloFecha = '<th width="26%"><a title="' . $title10 . '" class="text-primary BtnSort ' . $SortClass10 . '" id="FechaEntrDoFactTit" href="javascript:void(0);">' . $Icono10 . 'F Envia Facturación</a></th>';

                    break;

                default:
                    $TituloFecha = '<th width="26%"><a title="' . $title02 . '" class="text-primary BtnSort ' . $SortClass02 . '" id="DocImpoFechaCreaTit" href="javascript:void(0);">' . $Icono02 . ' Fecha Crea Do</a></th>';
                    break;
            }

            $headerList = '
<th width="4%"> - </th>
<th width="23%"> #DO</th>
<th width="48%"> Cliente </th>
 ' . $TituloFecha . ' ';
        } else if ($_POST['Lista'] == 'SI') {
            switch ($EstadoCalculado) {
                case 'PendienteArribo':
                    $headerList = $DoTit . $ClienteTi . $EtaTit . $DiasEtaTit . $FechaCraDoTit . $AdminTit . $DepositoTit . $EmbalajeTit . $AplicaAnticipadaTit . $PrtOrigTit . $SolicitudAntiTit . $RecibeAticipoTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'PendArriboEndigita':
                    $headerList = $DoTit . $ClienteTi . $EtaTit . $DiasEtaTit . $FechaCraDoTit . $AdminTit . $DepositoTit . $EmbalajeTit . $AplicaAnticipadaTit . $PrtOrigTit . $FechaNaciTit . $SolicitudAntiTit . $RecibeAticipoTit . $FechaReciboDocsTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'PendArriboAcept':
                    $headerList = $DoTit . $ClienteTi . $EtaTit . $DiasEtaTit . $FechaCraDoTit . $AdminTit . $DepositoTit . $EmbalajeTit . $AplicaAnticipadaTit . $PrtOrigTit . $FechaNaciTit . $FechaAcepTit . $SolicitudAntiTit . $RecibeAticipoTit . $FechaReciboDocsTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'PendArriboSinDocTransp':
                case 'PendienteActulizarManifiesto':
                    $headerList = $DoTit . $ClienteTi . $EtaTit . $DiasEtaTit . $FechaCraDoTit . $AdminTit . $DepositoTit . $EmbalajeTit . $AplicaAnticipadaTit . $PrtOrigTit . $SolicitudAntiTit . $RecibeAticipoTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'AnticipadaConETAVencido':
                    $headerList = $DoTit . $ClienteTi . $EtaTit . $DiasEtaTit . $FechaCraDoTit . $AdminTit . $DepositoTit . $EmbalajeTit . $AplicaAnticipadaTit . $PrtOrigTit . $FechaAcepTit . $SolicitudAntiTit . $RecibeAticipoTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'ArriboHoySinPasarADigitar':
                case 'ArriboHoyEnDigitacion':
                    $headerList = $DoTit . $ClienteTi . $EtaTit . $DiasEtaTit . $FechaCraDoTit . $AdminTit . $DepositoTit . $EmbalajeTit . $AplicaAnticipadaTit . $PrtOrigTit . $FechaMAnifiesTit . $SolicitudAntiTit . $RecibeAticipoTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'EnElaboracionDIM':
                case 'ConManifSinIngresoDeposito':
                    $headerList = $DoTit . $ClienteTi . $EtaTit . $DiasEtaTit . $FechaCraDoTit . $AdminTit . $DepositoTit . $EmbalajeTit . $AplicaAnticipadaTit . $PrtOrigTit . $FechaMAnifiesTit . $FechaNaciTit . $SolicitudAntiTit . $RecibeAticipoTit . $FechaReciboDocsTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'EnDepositoSinPasarDigitar':
                    $headerList = $DoTit . $ClienteTi . $EtaTit . $DiasEtaTit . $FechaCraDoTit . $AdminTit . $DepositoTit . $EmbalajeTit . $AplicaAnticipadaTit . $PrtOrigTit . $FechaMAnifiesTit . $FechaNaciTit . $SolicitudAntiTit . $RecibeAticipoTit . $FechaReciboDocsTit . $FechaIngDepTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'EnAceptacionSinLevante':
                    $headerList = $DoTit . $ClienteTi . $EtaTit . $DiasEtaTit . $FechaCraDoTit . $AdminTit . $DepositoTit . $EmbalajeTit . $AplicaAnticipadaTit . $PrtOrigTit . $FechaMAnifiesTit . $FechaNaciTit . $SolicitudAntiTit . $RecibeAticipoTit . $FechaReciboDocsTit . $FechaIngDepTit . $FormaPagoTit . $FechaAcepTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'ConLevanteSinDSP':
                    $headerList = $DoTit . $ClienteTi . $AdminTit . $DepositoTit . $EmbalajeTit . $DiasMainfTit . $FechaMAnifiesTit . $SolicitudAntiTit . $RecibeAticipoTit . $FechaReciboDocsTit . $FormaPagoTit . $FechaAcepTit . $FechaLEvanteTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'ConDSPSinEnvioFact':
                    $headerList = $DoTit . $ClienteTi . $AdminTit . $DepositoTit . $EmbalajeTit . $DiasMainfTit . $FechaMAnifiesTit . $SolicitudAntiTit . $RecibeAticipoTit . $FechaReciboDocsTit . $FechaAcepTit . $FechaLEvanteTit . $FechaDespachoTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'EnviadaFactSinFacturar':
                    $headerList = $DoTit . $ClienteTi . $EmbalajeTit . $DiasMainfTit . $FechaMAnifiesTit . $FechaAcepTit . $FechaLEvanteTit . $FechaDespachoTit . $FechaEnvioFacTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                case 'GastoPostSinFacturar':
                    $headerList = $DoTit . $ClienteTi . $EmbalajeTit . $DiasMainfTit . $FechaMAnifiesTit . $FechaAcepTit . $FechaLEvanteTit . $FechaDespachoTit . $FechaDevolucionFacturacionTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
                default:
                    $headerList = $DoTit . $ClienteTi . $EtaTit . $DiasEtaTit . $FechaCraDoTit . $AdminTit . $DepositoTit . $EmbalajeTit . $AplicaAnticipadaTit . $PrtOrigTit . $FechaAcepTit . $SolicitudAntiTit . $RecibeAticipoTit . $ObsSegTit . $ObsBitTit . $ObsClienteTit;
                    break;
            }
        }
        $html .= '<div  class="Data  tableFixHead " style="overflow-x: auto">
    <table id="ListaDOTable" class="table table-bordered  TableFixeada">
        <thead>
            <tr class="HeadTable">
                ' . $headerList . '
            </tr>
        </thead>
        <tbody>
            ';

        $ArraySelectDos = array();
        foreach ($result as $row) {
            $ArraySelectDos[] = $row['LlaveUnicaDO'];
            $ColorLetra       = '';
            if ($row['RangoEstado'] == 'De5a10' || $row['RangoEstado'] == 'De11a15' || $row['RangoEstado'] == 'De16a20' || $row['RangoEstado'] == 'Mayora20') {
                $icon       = '<span class="ti-alert text-danger"></span>';
                $ColorLetra = '#EB0101';
                $ColorFecha = 'Fecha-danger';
            } else if ($row['RangoEstado'] == 'De0a4') {
                $icon = '<span class="ti-time text-warning"></span>';

                $ColorFecha = 'Fecha-warning';
            } else {
                $icon       = '<span class="ti-check-box text-success"></span>';
                $ColorFecha = 'Fecha-success';
            }
            $DiasEta   = CalcularDias(ConvertFecha($row['DocImpoFechaETA']), $DiaHoy);
            $DiasMainf = CalcularDias(ConvertFecha($row['FechaManifiesto']), $DiaHoy);
            if ($_POST['Lista'] == 'NO') {

                switch ($EstadoCalculado) {
                    case 'PendienteArribo':
                    case 'PendArriboEndigita':
                    case 'PendArriboAcept':
                    case 'PendArriboSinDocTransp':
                    case 'DtaSinArribar':
                    case 'PendienteActulizarManifiesto':
                        $ValueFecha = ConvertFecha($row['DocImpoFechaETA']);
                        break;

                    case 'AnticipadaConETAVencido':
                    case 'ArriboHoySinPasarADigitar':
                    case 'ArriboHoyEnDigitacion':
                    case 'EnElaboracionDIM':
                    case 'ConManifSinIngresoDeposito':
                    case 'EnAceptacionSinLevante':
                    case 'EnDepositoSinPasarDigitar':
                    case 'DIMVisadaSinAceptar':

                        $ValueFecha = ConvertFechaHour($row['FechaManifiesto']);
                        break;
                    case 'ConLevanteSinDSP':
                    case 'DtaConDSPSinFAC':
                        $ValueFecha = ConvertFechaHour($row['DeclImpoFechaLevante']);
                        break;
                    case 'ConDSPSinEnvioFact':
                        $ValueFecha = ConvertFechaHour($row['FechaDespacho']);
                        break;
                    case 'DtaSinGeneraFAC':
                    case 'EnviadaFactSinFacturar':
                    case 'DevueltaPorContabilidad':
                    case 'DevolucionFacturacion':
                        $ValueFecha = ConvertFechaHour($row['FechaEntrDoFact']);
                        break;
                    default:
                        $ValueFecha = ConvertFecha($row['DocImpoFechaCrea']);
                        break;
                }

                $html .= '
            <tr class= "items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '">
            <td width="4%" class= "HidenLarge NumDO  ' . $row['LlaveUnicaDO'] . '" > ' . $icon . ' </td>
                <td width="23%" class= "HidenLarge NumDO  ' . $row['LlaveUnicaDO'] . '" > <font  color="' . $ColorLetra . '">' . $row['DocImpoNoDO'] . ' </font></td>
                <td width="48%" title="' . $row['Cliente'] . '" class="HidenLarge ' . $row['LlaveUnicaDO'] . '"><small>' . $row['Cliente'] . '</small></td>
                <td width="26%" class="HidenLarge ' . $row['LlaveUnicaDO'] . '"><span class="' . $ColorFecha . '">' . $ValueFecha . '</span></td>
            </tr>';
            } else if ($_POST['Lista'] == 'SI') {

                $DocImpoNoDOVal                = '<td class="NumDO HidenLarge text-center ' . $row['LlaveUnicaDO'] . '"><font color="' . $ColorLetra . '">  ' . $icon . ' ' . $row['DocImpoNoDO'] . '</font></td>';
                $ClienteVal                    = '<td title="' . $row['Cliente'] . '" class="HidenLarge ' . $row['LlaveUnicaDO'] . '"><small>' . $row['Cliente'] . '</small></td>';
                $DocImpoFechaETAVal            = '<td class="HidenLarge text-center ' . $row['LlaveUnicaDO'] . '">' . ConvertFecha($row['DocImpoFechaETA']) . '</td>';
                $DiasEtaVal                    = '<td class="HidenLarge text-center ' . $row['LlaveUnicaDO'] . '">' . $DiasEta . '</td>';
                $DocImpoFechaCreaVal           = '<td class="HidenLarge text-center ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['DocImpoFechaCrea']) . '</td>';
                $AdminAduanasNombreVal         = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . $row['AdminAduanasNombre'] . '</td>';
                $DepositoVal                   = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '"><small>' . TraductorTerminalDeposito($connMysql, $row['Deposito']) . '</small></td>';
                $TipoEmbalajeVal               = '<td class="HidenLarge text-center ' . $row['LlaveUnicaDO'] . '">' . $row['TipoEmbalaje'] . '</td>';
                $AplicaAnticipadaVal           = '<td class="HidenLarge text-center ' . $row['LlaveUnicaDO'] . '">' . $row['AplicaAnticipada'] . '</td>';
                $PrtOrigVal                    = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '"><small>FALTA CAMPO</small></td>';
                $FechaReciboAnticipoVal        = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['FechaReciboAnticipo']) . '</td>';
                $FechaReciboAnticipoVal        = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['FechaReciboAnticipo']) . '</td>';
                $FechaSolicitudAnticipoVal     = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['FechaSolicitudAnticipo']) . '</td>';
                $ObsSeguimientoVal             = '<td class="ShowLarge ' . $row['LlaveUnicaDO'] . '"><small>' . $row['ObsSeguimiento'] . '</small></td>';
                $ObsrvBitacoraVal              = '<td class="ShowLarge ' . $row['LlaveUnicaDO'] . '"><small>' . $row['ObsrvBitacora'] . '</small></td>';
                $ObsrvClienteVal               = '<td class="ShowLarge ' . $row['LlaveUnicaDO'] . '"><small>' . $row['ObsrvCliente'] . '</small></td>';
                $DeclImpoFechaAceptVal         = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['DeclImpoFechaAcept']) . '</td>';
                $FechaNacionalizacionVal       = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['FechaNacionalizacion']) . '</td>';
                $FechaReciboDocsVal            = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['FechaReciboDocs']) . '</td>';
                $FechaManifiestoVal            = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['FechaManifiesto']) . '</td>';
                $FechaIngresoDepositoVal       = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['FechaIngresoDeposito']) . '</td>';
                $FormaPagoVal                  = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['OrdenNacfechaPagoHasta']) . '</td>';
                $DeclImpoFechaLevanteVal       = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['DeclImpoFechaLevante']) . '</td>';
                $FechaDespachoVal              = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['FechaDespacho']) . '</td>';
                $DiasMainfVal                  = '<td class="HidenLarge text-center ' . $row['LlaveUnicaDO'] . '">' . $DiasMainf . '</td>';
                $FechaEntrDoFactVal            = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['FechaEntrDoFact']) . '</td>';
                $FechaDevolucionFacturacionVal = '<td class="HidenLarge ' . $row['LlaveUnicaDO'] . '">' . ConvertFechaHour($row['FechaDevolucionFacturacion']) . '</td>';
                switch ($EstadoCalculado) {
                    case 'PendienteArribo':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $DocImpoFechaETAVal . $DiasEtaVal . $DocImpoFechaCreaVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $AplicaAnticipadaVal . $PrtOrigVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'PendArriboEndigita':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $DocImpoFechaETAVal . $DiasEtaVal . $DocImpoFechaCreaVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $AplicaAnticipadaVal . $PrtOrigVal . $FechaSolicitudAnticipoVal . $FechaNacionalizacionVal . $FechaReciboAnticipoVal . $FechaReciboDocsVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'PendArriboAcept':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $DocImpoFechaETAVal . $DiasEtaVal . $DocImpoFechaCreaVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $AplicaAnticipadaVal . $PrtOrigVal . $DeclImpoFechaAceptVal . $FechaNacionalizacionVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $FechaReciboDocsVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'PendArriboSinDocTransp':
                    case 'PendienteActulizarManifiesto':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $DocImpoFechaETAVal . $DiasEtaVal . $DocImpoFechaCreaVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $AplicaAnticipadaVal . $PrtOrigVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'AnticipadaConETAVencido':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $DocImpoFechaETAVal . $DiasEtaVal . $DocImpoFechaCreaVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $AplicaAnticipadaVal . $PrtOrigVal . $DeclImpoFechaAceptVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'ArriboHoySinPasarADigitar':
                    case 'ArriboHoyEnDigitacion':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $DocImpoFechaETAVal . $DiasEtaVal . $DocImpoFechaCreaVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $AplicaAnticipadaVal . $PrtOrigVal . $FechaManifiestoVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'EnElaboracionDIM':
                    case 'ConManifSinIngresoDeposito':

                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $DocImpoFechaETAVal . $DiasEtaVal . $DocImpoFechaCreaVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $AplicaAnticipadaVal . $PrtOrigVal . $FechaManifiestoVal . $FechaNacionalizacionVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $FechaReciboDocsVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'EnDepositoSinPasarDigitar':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $DocImpoFechaETAVal . $DiasEtaVal . $DocImpoFechaCreaVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $AplicaAnticipadaVal . $PrtOrigVal . $FechaManifiestoVal . $FechaNacionalizacionVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $FechaReciboDocsVal . $FechaIngresoDepositoVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'EnAceptacionSinLevante':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $DocImpoFechaETAVal . $DiasEtaVal . $DocImpoFechaCreaVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $AplicaAnticipadaVal . $PrtOrigVal . $FechaManifiestoVal . $FechaNacionalizacionVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $FechaReciboDocsVal . $FechaIngresoDepositoVal . $FormaPagoVal . $FechaNacionalizacionVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'ConLevanteSinDSP':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $DiasMainfVal . $FechaManifiestoVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $FechaReciboDocsVal . $FormaPagoVal . $DeclImpoFechaAceptVal . $DeclImpoFechaLevanteVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'ConDSPSinEnvioFact':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $DiasMainfVal . $FechaManifiestoVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $FechaReciboDocsVal . $DeclImpoFechaAceptVal . $DeclImpoFechaLevanteVal . $FechaDespachoVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'EnviadaFactSinFacturar':

                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $TipoEmbalajeVal . $DiasMainfVal . $FechaManifiestoVal . $DeclImpoFechaAceptVal . $DeclImpoFechaLevanteVal . $FechaDespachoVal . $FechaEntrDoFactVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    case 'GastoPostSinFacturar':
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $DiasMainfVal . $FechaManifiestoVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $FechaReciboDocsVal . $DeclImpoFechaAceptVal . $DeclImpoFechaLevanteVal . $FechaDespachoVal . $FechaDevolucionFacturacionVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                    default:
                        $ValuesRow = $DocImpoNoDOVal . $ClienteVal . $DocImpoFechaETAVal . $DiasEtaVal . $DocImpoFechaCreaVal . $AdminAduanasNombreVal . $DepositoVal . $TipoEmbalajeVal . $AplicaAnticipadaVal . $PrtOrigVal . $DeclImpoFechaAceptVal . $FechaSolicitudAnticipoVal . $FechaReciboAnticipoVal . $ObsSeguimientoVal . $ObsrvBitacoraVal . $ObsrvClienteVal;
                        $html .= '
            <tr class="items BtnSelectDO ' . $row['LlaveUnicaDO'] . '" id="' . $row['LlaveUnicaDO'] . '" data-id="' . $row['LlaveUnicaDO'] . '" data-nacid="' . $row['OrdenNacID'] . '" >
                ' . $ValuesRow . '
            </tr>';
                        break;
                }
            }
        }

        $html .= '</tbody>
    </table> </div>';
    }
    //print_r($data);
    $_SESSION['FiltroInternoDO'] = "EstadoCalculado = '$EstadoCalculado' and $Campo = '$Valor'";
    $data['html']                = $html;
    $data['Cantidad']            = $Cantidad;
    unset($_SESSION['SessionMailAll']);
    $_SESSION['SessionMailAll'] = $ArraySelectDos;
    return json_encode($data);
}
function SelectDO($connMysql)
{
    $ID = $_POST['ID_DO'];
    ValidateSessionDO($ID);
    $DoSeleccionados = count($_SESSION['SessionIDS']);
    $FiltroActivo    = FiltroActivo();
    if ($DoSeleccionados > 1) {
        $HideDiv = true;
    } else if ($DoSeleccionados == 0) {
        $HideDiv = true;
    } else if ($DoSeleccionados == 1) {
        $HideDiv     = false;
        $idConverted = implode(", ", $_SESSION['SessionIDS']);
        $SQL         = "SELECT * FROM IMSeguimientoOperativo WHERE LlaveUnicaDO IN('$idConverted') AND $FiltroActivo";
        $stmt        = $connMysql->prepare($SQL);
        $stmt->execute();
        $data     = array();
        $DataHtml = '';
        $row      = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['RangoEstado'] == 'De5a10' || $row['RangoEstado'] == 'De11a15' || $row['RangoEstado'] == 'De16a20' || $row['RangoEstado'] == 'Mayora20') {
            $icon = '<span class="ti-alert text-danger"></span>';
        } else if ($row['RangoEstado'] == 'De0a4') {
            $icon = '<span class="ti-time text-warning"></span>';
        } else {
            $icon = '<span class="ti-check-box text-success"></span>';
        }

        $DataHtml .= '<div class="col-xl-6 mb-2">
        <h6 class="text-primaryBold card-user_name">Cliente</h6>
        <h6 class="card-user_occupation">' . $row['Cliente'] . '</h6>

</div>';
        $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Ejecutivo</h6>
<h6 class="card-user_occupation" id="Ejecutivo">' . $row['Ejecutivo'] . '</h6>
</div>';
        $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Instrucción</h6>
<h6 class="card-user_occupation" id="Instruccion">' . $row['Instruccion'] . '</h6>
</div>';
        $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Estado</h6>
<h6 class="card-user_occupation" id="EstadoCalculado">' . DetectarNombreEstado($row['EstadoCalculado']) . '  ' . $icon . '</h6>
</div>';
        $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Número DO</h6>
<h6 class="card-user_occupation" id="DocImpoNoDO">' . $row['DocImpoNoDO'] . '</h6>
</div>';
        if (strlen($row['DocImpoNoDoCliente']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">DO Cliente</h6>
<h6 class="card-user_occupation" id="DocImpoNoDoCliente">' . $row['DocImpoNoDoCliente'] . '</h6>
</div>';
        }

        $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Suma Días Hoy Estado</h6>
<h6 class="card-user_occupation" id="DiasEstado">' . $row['DiasEstado'] . '</h6>
</div>';
        $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Rango Estado</h6>
<h6 class="card-user_name" id="RangoEstado">' . $row['RangoEstado'] . '</h6>
</div>';

        if (strlen($row['DocImpoFechaCrea']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Creación DO</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['DocImpoFechaCrea']) . '</h6>
</div>';
        }

        if (strlen($row['DocImpoNoDocTransp']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Documento de transporte</h6>
<h6 class="card-user_occupation" id="DocImpoNoDocTranspTxt">' . $row['DocImpoNoDocTransp'] . '</h6>
</div>';
        }

        if (strlen($row['DocImpoFechaETA']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha ETA</h6>
<h6 class="card-user_occupation" id="FechaManifiestoText">' . ConvertFechaHour($row['DocImpoFechaETA']) . '</h6>
</div>';
        }

        if (strlen($row['NumeroManifiesto']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Número Manifiesto</h6>
<h6 class="card-user_occupation" id="NumeroManifiestoText">' . $row['NumeroManifiesto'] . '</h6>
</div>';
        }

        if (strlen($row['FechaManifiesto']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Manifiesto</h6>
<h6 class="card-user_occupation" id="FechaManifiestoText">' . ConvertFechaHour($row['FechaManifiesto']) . '</h6>
</div>';
        }
        if (strlen($row['FechaFormulario']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Formulario  (FFMM) </h6>
<h6 class="card-user_occupation" id="FechaFormularioText">' . ConvertFechaHour($row['FechaFormulario']) . '</h6>
</div>';
        }

        if (strlen($row['FechaConsultaInventario']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Consulta Inventario</h6>
<h6 class="card-user_occupation" id="FechaConsultaInventarioText">' . ConvertFechaHour($row['FechaConsultaInventario']) . '</h6>
</div>';
        }

        if (strlen($row['FechaReciboDocumentos']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Recibo Docs DO</h6>
<h6 class="card-user_occupation" >' . ConvertFechaHour($row['FechaReciboDocumentos']) . '</h6>
</div>';
        }

        if (strlen($row['FechaReciboDocsPuerto']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Recibo Docs Puerto</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['FechaReciboDocsPuerto']) . '</h6>
</div>';
        }

        if (strlen($row['FechaReciboDocs']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Recibo Docs Nac</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['FechaReciboDocs']) . '</h6>
</div>';
        }

        if (strlen($row['OrdenNacID']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Nacionalización</h6>
<h6 class="card-user_occupation" id="OrdenNacID">' . $row['OrdenNacID'] . '</h6>
</div>';
        }
        if (strlen($row['TipoNacionalizacion']) > 0) {
            $DataHtml .= '   <div class="col-xl-6 mb-2">
<h6 title="Tipo Nacionalización" class="text-primaryBold card-user_name">Tipo  Nacionalización</h6>
<h6 class="card-user_occupation" id="TipoNacionalizacion">' . $row['TipoNacionalizacion'] . '</h6>
</div>';
        }

        if (strlen($row['FechaNacionalizacion']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Nacionalización</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['FechaNacionalizacion']) . '</h6>
</div>';
        }

        if (strlen($row['FechaVisado']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Visado</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['FechaVisado']) . '</h6>
</div>';
        }

        if (strlen($row['DeclImpoFechaAcept']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2" >
<h6 class="text-primaryBold card-user_name">Fecha Aceptación</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['DeclImpoFechaAcept']) . '</h6>
</div>';
        }
        if (strlen($row['DeclImpoFechaLevante']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Levante</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['DeclImpoFechaLevante']) . '</h6>
</div>';
        }

        if (strlen($row['FechaEntregaDocumentosDespacho']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Entrega docs Despacho </h6>
<h6 class="card-user_occupation" id="FechaEntregaDocumentosDespachoText">' . ConvertFechaHour($row['FechaEntregaDocumentosDespacho']) . '</h6>
</div>';
        }

        if (strlen($row['FechaEntregaApoyoOperativo']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Entrega Apoyo operativo</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['FechaEntregaApoyoOperativo']) . '</h6>
</div>';
        }

        if (strlen($row['FechaDespacho']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Despacho </h6>
<h6 class="card-user_occupation" id="FechaDespachoText">' . ConvertFechaHour($row['FechaDespacho']) . '</h6>
</div>';
        }

        if (strlen($row['FechaEntrDoFact']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold">Fecha Entrega Facturación</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['FechaEntrDoFact']) . '</h6>
</div>';
        }

        if (strlen($row['FechaDevolucionFacturacion']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold">Fecha Devolución contabilidad</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['FechaDevolucionFacturacion']) . '</h6>
</div>';
        }

        if (strlen($row['FechaEntregaDoDevolucionFacturacion']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold">Fecha Devolución a contabilidad</h6>
<h6 class="card-user_occupation">' . ConvertFechaHour($row['FechaEntregaDoDevolucionFacturacion']) . '</h6>
</div>';
        }

        if (strlen($row['FechaSolicitudAnticipo']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Solicitud Anticipo</h6>
<h6 class="card-user_occupation" id="FechaSolicitudAnticipo">' . ConvertFechaHour($row['FechaSolicitudAnticipo']) . '</h6>
</div>';
        }
        if (strlen($row['FechaReciboAnticipo']) > 0) {
            $DataHtml .= '
<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold card-user_name">Fecha Recibo Anticipo</h6>
<h6 class="card-user_occupation" id="FechaReciboAnticipo">' . ConvertFechaHour($row['FechaReciboAnticipo']) . '</h6>
</div>';
        }
        if (strlen($row['Deposito']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold">Depósito</h6>
<h6 class="card-user_occupation">' . TraductorTerminalDeposito($connMysql, $row['Deposito']) . '</h6>
</div>';
        }
        if (strlen($row['DepositoZonaFranca']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold">Deposito Zona Franca</h6>
<h6 class="card-user_occupation">' . TraductorTerminalDeposito($connMysql, $row['DepositoZonaFranca'], 'ZF') . '</h6>
</div>';
        }
        if (strlen($row['TerminalPortuario']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold">Terminal Porturario</h6>
<h6 class="card-user_occupation">' . TraductorTerminalDeposito($connMysql, $row['TerminalPortuario']) . '</h6>
</div>';
        }
        if (strlen($row['ParcialNumero']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold">Número Parcial</h6>
<h6 class="card-user_occupation">' . $row['ParcialNumero'] . '</h6>
</div>';
        }

        if (strlen($row['DescripcionMercancia']) > 0) {
            $DataHtml .= '<div class="col-xl-6 mb-2">
<h6 class="text-primaryBold">Descripción Mercancia</h6>
<h6 class="card-user_occupation">' . $row['DescripcionMercancia'] . '</h6>
</div>';
        }

        if (strlen($row['ObsSeguimiento']) > 0) {
            $DataHtml .= '<div class="col-xl-12 mb-2">
<h6 class="text-primaryBold">Observaciones Seguimiento</h6>
<p class="text-dark card-user_occupation">' . $row['ObsSeguimiento'] . '</p>
</div>';
        }

        if (strlen($row['ObsrvBitacora']) > 0) {
            $DataHtml .= '<div class="col-xl-12 mb-2">
<h6 class="text-primaryBold">Observaciones Bitacora</h6>
<p class="text-dark card-user_occupation">' . $row['ObsrvBitacora'] . '</p>
</div>';
        }

        if (strlen($row['ObsrvCliente']) > 0) {
            $DataHtml .= '<div class="col-xl-12 mb-2">
<h6 class="text-primaryBold">Observaciones Cliente</h6>
<p class="text-dark card-user_occupation">' . $row['ObsrvCliente'] . '</p>
</div>';
        }

        $data['DocImpoNoDocTransp']                  = $row['DocImpoNoDocTransp'];
        $data['DocImpoFechaETA']                     = ConvertFechaHour($row['DocImpoFechaETA']);
        $data['FechaManifiesto']                     = ConvertFechaHour($row['FechaManifiesto']);
        $data['FechaConsultaInventario']             = ConvertFechaHour($row['FechaConsultaInventario']);
        $data['DataHtml']                            = $DataHtml;
        $data['NumeroManifiesto']                    = $row['NumeroManifiesto'];
        $data['ObsSeguimiento']                      = $row['ObsSeguimiento'];
        $data['ObsrvBitacora']                       = $row['ObsrvBitacora'];
        $data['ObsrvCliente']                        = $row['ObsrvCliente'];
        $data['FechaDespacho']                       = ConvertFechaHour($row['FechaDespacho']);
        $data['FechaEntregaDocumentosDespacho']      = ConvertFechaHour($row['FechaEntregaDocumentosDespacho']);
        $data['FechaFormulario']                     = ConvertFechaHour($row['FechaFormulario']);
        $data['FechaEntregaApoyoOperativo']          = ConvertFechaHour($row['FechaEntregaApoyoOperativo']);
        $data['FechaDevolucionFacturacion']          = ConvertFechaHour($row['FechaDevolucionFacturacion']);
        $data['FechaEntregaDoDevolucionFacturacion'] = ConvertFechaHour($row['FechaEntregaDoDevolucionFacturacion']);
        $data['DepositoZonaFranca']                  = $row['DepositoZonaFranca'];
        $data['TerminalPortuario']                   = $row['Deposito'];
        $data['EstadoCalculado']                     = DetectarNombreEstado($row['EstadoCalculado']);
        $data['FechaReciboDocs']                     = ConvertFechaHour($row['FechaReciboDocs']);
        $data['FechaSolicitudAnticipo']              = ConvertFechaHour($row['FechaSolicitudAnticipo']);
        $data['FechaReciboAnticipo']                 = ConvertFechaHour($row['FechaReciboAnticipo']);
        $data['FechaReciboDocumentos']               = ConvertFechaHour($row['FechaReciboDocumentos']);
        $data['FechaReciboDocsPuerto']               = ConvertFechaHour($row['FechaReciboDocsPuerto']);

        $data['SQL'] = $SQL;
    }
    $data['Seleccionados'] = $_SESSION['SessionIDS'];
    $data['HideDiv']       = $HideDiv;
    if ($_POST['DoSelected'] == 'yes') {
        $_SESSION['SessionIDSUnico'] = $_SESSION['SessionIDS'];
        unset($_SESSION['SessionIDS']);
    }
    return json_encode($data);
}
function ValidateSessionDO($ID)
{

    if (isset($_SESSION['SessionIDS'])) {
        $key = array_search($ID, $_SESSION['SessionIDS']);
        if (false !== $key) {
            if (($_POST['DoSelected']) == 'NO') {
                unset($_SESSION['SessionIDS'][$key]);
            }
        } else {
            array_push($_SESSION['SessionIDS'], $ID);
        }
    } else {
        $_SESSION['SessionIDS'] = array($ID);
    }
}
function ActualizarDOS($connMysql)
{
    if (isset($_SESSION['SessionIDS'])) {
    } else {
        $_SESSION['SessionIDS'] = $_SESSION['SessionIDSUnico'];
    }
    $DoSeleccionados = $_SESSION['SessionIDS'];
    if (count($DoSeleccionados) == 0) {
        $data['Errores'] = 'No seleccionó ningun DO';
        $data['Success'] = false;
    } else {
        $arrayData = array(
            'DocImpoNoDocTransp'                  => ValidatePostingChar($_POST['DocImpoNoDocTransp']),
            'DocImpoFechaETA'                     => ValidatePostingChar($_POST['DocImpoFechaETA']),
            'FechaManifiesto'                     => ValidatePostingChar($_POST['FechaManifiesto']),
            'FechaConsultaInventario'             => ValidatePostingChar($_POST['FechaConsultaInventario']),
            'FechaDespacho'                       => ValidatePostingChar($_POST['FechaDespacho']),
            'NumeroManifiesto'                    => ValidatePostingChar($_POST['NumeroManifiesto']),
            'FechaEntregaDocumentosDespacho'      => ValidatePostingChar($_POST['FechaEntregaDocumentosDespacho']),
            'FechaFormulario'                     => ValidatePostingChar($_POST['FechaFormulario']),
            'FechaEntregaApoyoOperativo'          => ValidatePostingChar($_POST['FechaEntregaApoyoOperativo']),
            'FechaDevolucionFacturacion'          => ValidatePostingChar($_POST['FechaDevolucionFacturacion']),
            'FechaEntregaDoDevolucionFacturacion' => ValidatePostingChar($_POST['FechaEntregaDoDevolucionFacturacion']),
            'DepositoZonaFranca'                  => ValidatePostingChar($_POST['DepositoZonaFranca']),
            'Deposito'                            => ValidatePostingChar($_POST['TerminalPortuario']),
            'ObsSeguimiento'                      => ValidatePostingChar($_POST['ObsSeguimiento']),
            'ObsrvCliente'                        => ValidatePostingChar($_POST['ObsCliente']),
            'ObsrvBitacora'                       => ValidatePostingChar($_POST['ObsBitacora']),
            'FechaReciboDocs'                     => ValidatePostingChar($_POST['FechaReciboDocs']),
            'FechaSolicitudAnticipo'              => ValidatePostingChar($_POST['FechaSolicitudAnticipo']),
            'FechaReciboAnticipo'                 => ValidatePostingChar($_POST['FechaReciboAnticipo']),
            'FechaReciboDocumentos'               => ValidatePostingChar($_POST['FechaReciboDocumentos']),
            'FechaReciboDocsPuerto'               => ValidatePostingChar($_POST['FechaReciboDocsPuerto']),
        );
        $CadenaUpdate = array();
        foreach ($DoSeleccionados as $ID) {

            $ValidacionDeFechas = ValidacionDeFechas($connMysql, $arrayData, $ID);
            $Errores            = 0;
            $Success            = 0;
            $CampoUpdate        = '';
            $MensajeError       = '';
            $data               = array();

            if ($ValidacionDeFechas != 0) {
                foreach ($ValidacionDeFechas as $row) {
                    if ($row['Status'] == 'Error') {
                        $Errores += 1;
                        $MensajeError .= '<li><small>' . $row['MensajeError'] . '</small></li>';
                    }
                    if ($row['Status'] == 'Success') {
                        array_push($CadenaUpdate, array('CampoUpdate' => $row['CampoUpdate'], 'Value' => $row['Value']));
                        $Success += 1;
                    }
                }
            }
        }

        if ($Errores > 0) {
            $data['Errores'] = $MensajeError;
            $data['Success'] = false;
        } else if ($Errores == 0 && $Success >= 0) {
            if (strlen($arrayData['ObsSeguimiento']) > 0) {
                array_push($CadenaUpdate, array('CampoUpdate' => 'ObsSeguimiento', 'Value' => $arrayData['ObsSeguimiento']));
            }
            if (strlen($arrayData['ObsrvCliente']) > 0) {
                array_push($CadenaUpdate, array('CampoUpdate' => 'ObsrvCliente', 'Value' => $arrayData['ObsrvCliente']));
            }
            if (strlen($arrayData['ObsrvBitacora']) > 0) {

                array_push($CadenaUpdate, array('CampoUpdate' => 'ObsrvBitacora', 'Value' => $arrayData['ObsrvBitacora']));
            }

            if (count($CadenaUpdate) > 0) {

                $idConverted = implode(',', $_SESSION['SessionIDS']);

                $DataUpatde = EjecutarProcedimientoTRK($connMysql, $CadenaUpdate);
                // print_r($DataUpatde);
                if ($DataUpatde['Result'] == 'OK') {
                    $ResultadosSQL       = SQLUpdaterData($connMysql, $CadenaUpdate, $ID);
                    $data['idConverted'] = $idConverted;
                    if (count($_SESSION['SessionIDS']) > 0) {
                        $data['FirstDO'] = $_SESSION['SessionIDS'][0];
                    }

                    // $data['token']       = GenerarToken($connMysql);
                    $data['Success']         = true;
                    $data['Actualizados']    = count($_SESSION['SessionIDS']);
                    $data['ResultsConsulta'] = $DataUpatde['Result'];
                    $data['ApiSonar']        = $DataUpatde['ApiSonar'];

                    $file = fopen("ProcedimientosTrk.txt", "a+");
                    fwrite($file, $DataUpatde['sqlTxt'] . PHP_EOL);
                    fclose($file);
                } else {
                    $data['Errores'] = 'Problemas en la Actualización con la integración RpcTracking';
                    $data['Success'] = false;
                    $file            = fopen("ProcedimientosTrk.txt", "a+");
                    fwrite($file, $DataUpatde['sqlTxt'] . PHP_EOL);
                    fclose($file);
                }
            } else {
                $data['Errores'] = 'No actualizó ningun campo';
                $data['Success'] = false;
            }
        }
    }

    return json_encode($data);
}
function ValidacionDeFechas($connMysql, $arrayData, $ID)
{

    $DataResult = array();

    $SQL  = "SELECT * FROM IMSeguimientoOperativo WHERE LlaveUnicaDO ='$ID' ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $row               = $stmt->fetch(PDO::FETCH_ASSOC);
    $Cantidad          = $stmt->rowCount();
    $DatosActualizados = 0;
    if ($Cantidad > 0) {

        ReparaCadenas($row['FechaNacionalizacion']);

        foreach ($arrayData as $key => $value) {
            $DocImpoFechaETA                     = SelectCampo($arrayData['DocImpoFechaETA'], $row['DocImpoFechaETA']);
            $FechaManifiesto                     = SelectCampo($arrayData['FechaManifiesto'], $row['FechaManifiesto']);
            $DocImpoFechaCrea                    = SelectCampo(null, $row['DocImpoFechaCrea']);
            $FechaConsultaInventario             = SelectCampo($arrayData['FechaConsultaInventario'], $row['FechaConsultaInventario']);
            $FechaDespacho                       = SelectCampo($arrayData['FechaDespacho'], $row['FechaDespacho']);
            $FechaEntregaDocumentosDespacho      = SelectCampo($arrayData['FechaEntregaDocumentosDespacho'], $row['FechaEntregaDocumentosDespacho']);
            $FechaFormulario                     = SelectCampo($arrayData['FechaFormulario'], $row['FechaFormulario']);
            $FechaEntregaApoyoOperativo          = SelectCampo($arrayData['FechaEntregaApoyoOperativo'], $row['FechaEntregaApoyoOperativo']);
            $FechaDevolucionFacturacion          = SelectCampo($arrayData['FechaDevolucionFacturacion'], $row['FechaDevolucionFacturacion']);
            $FechaEntregaDoDevolucionFacturacion = SelectCampo($arrayData['FechaEntregaDoDevolucionFacturacion'], $row['FechaEntregaDoDevolucionFacturacion']);

            switch ($key) {

                case 'FechaReciboDocs':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaReciboDocs']) > 0 && ConvertFechaHour($arrayData['FechaReciboDocs']) != ConvertFechaHour($row['FechaReciboDocs'])) {

                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaReciboDocs', 'Value' => $value));
                        }
                    }
                    break;
                case 'FechaSolicitudAnticipo':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaSolicitudAnticipo']) > 0 && ConvertFechaHour($arrayData['FechaSolicitudAnticipo']) != ConvertFechaHour($row['FechaSolicitudAnticipo'])) {

                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaSolicitudAnticipo', 'Value' => $value));
                        }
                    }
                    break;
                case 'FechaReciboAnticipo':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaReciboAnticipo']) > 0 && ConvertFechaHour($arrayData['FechaReciboAnticipo']) != ConvertFechaHour($row['FechaReciboAnticipo'])) {

                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaReciboAnticipo', 'Value' => $value));
                        }
                    }
                    break;
                case 'FechaReciboDocumentos':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaReciboDocumentos']) > 0 && ConvertFechaHour($arrayData['FechaReciboDocumentos']) != ConvertFechaHour($row['FechaReciboDocumentos'])) {

                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaReciboDocumentos', 'Value' => $value));
                        }
                    }
                    break;
                case 'FechaReciboDocsPuerto':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaReciboDocsPuerto']) > 0 && ConvertFechaHour($arrayData['FechaReciboDocsPuerto']) != ConvertFechaHour($row['FechaReciboDocsPuerto'])) {

                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaReciboDocsPuerto', 'Value' => $value));
                        }
                    }
                    break;
                case 'DocImpoNoDocTransp':

                    $ErrorField = false;
                    if (strlen($arrayData['DocImpoNoDocTransp']) > 0 && $arrayData['DocImpoNoDocTransp'] != $row['DocImpoNoDocTransp']) {

                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'DocImpoNoDocTransp', 'Value' => $value));
                        }
                    }
                    break;
                case 'NumeroManifiesto':

                    $ErrorField = false;
                    if (strlen($arrayData['NumeroManifiesto']) > 0 && $arrayData['NumeroManifiesto'] != $row['NumeroManifiesto']) {

                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'NumeroManifiesto', 'Value' => $value));
                        }
                    }
                    break;

                case 'DepositoZonaFranca':

                    $ErrorField = false;
                    if (strlen($arrayData['DepositoZonaFranca']) > 0 && $arrayData['DepositoZonaFranca'] != $row['DepositoZonaFranca']) {

                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'DepositoZonaFranca', 'Value' => $value));
                        }
                    }
                    break;
                case 'Deposito':

                    $ErrorField = false;
                    if (strlen($arrayData['Deposito']) > 0 && $arrayData['Deposito'] != $row['Deposito']) {

                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'Deposito', 'Value' => $value));
                        }
                    }
                    break;

                case 'DocImpoFechaETA':

                    $ErrorField = false;

                    if (strlen($arrayData['DocImpoFechaETA']) > 0 && ConvertFechaHour($arrayData['DocImpoFechaETA']) != ConvertFechaHour($row['DocImpoFechaETA'])) {

                        // $DiasMaxManifEta  = CalcularDias($FechaManifiesto, $DocImpoFechaETA);
                        // $DiasMaxCreaDOEta = CalcularDias($DocImpoFechaCrea, $DocImpoFechaETA);
                        // if ($DiasMaxManifEta <= -5) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha ETA del DO: ' . $row['DocImpoNoDO'] . ' no puede ser menor a 5 Dias con la fecha de Manifiesto'));
                        //     $ErrorField = true;
                        // }
                        // if ($DiasMaxCreaDOEta > 30) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha ETA del DO: ' . $row['DocImpoNoDO'] . ' no puede ser mayor a 30 Dias con la fecha de creación'));
                        //     $ErrorField = true;
                        // }
                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'DocImpoFechaETA', 'Value' => $value));
                        }
                    }
                    break;

                case 'FechaManifiesto':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaManifiesto']) > 0 && ConvertFechaHour($arrayData['FechaManifiesto']) != ConvertFechaHour($row['FechaManifiesto'])) {
                        // if ($row['DocImpoEtaBot'] == 1) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha De manifiesto del DO: ' . $row['DocImpoNoDO'] . ' Fue Actualizada por un bot '));
                        //     $ErrorField = true;
                        // }
                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaManifiesto', 'Value' => $value));
                        }
                    }
                    break;

                case 'FechaConsultaInventario':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaConsultaInventario']) > 0 && ConvertFechaHour($arrayData['FechaConsultaInventario']) != ConvertFechaHour($row['FechaConsultaInventario'])) {
                        // if (strlen($FechaManifiesto) == 0) {
                        //     $FechaManifiesto = SelectCampo(null, $row['FechaIngresoDeposito']);
                        // }
                        // $DiasMaxManifInventario = CalcularDias($FechaManifiesto, $FechaConsultaInventario);
                        // if ($DiasMaxManifInventario < 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha Consulta Inventario del DO: ' . $row['DocImpoNoDO'] . ' no puede ser menor a la fecha de Manifiesto'));
                        //     $ErrorField = true;
                        // }
                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaConsultaInventario', 'Value' => $value));
                        }
                    }
                    break;
                case 'FechaDespacho':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaDespacho']) > 0 && ConvertFechaHour($arrayData['FechaDespacho']) != ConvertFechaHour($row['FechaDespacho'])) {
                        // $DiasMaxManifDespacho = CalcularDias($FechaManifiesto, $FechaDespacho);
                        // if ($DiasMaxManifDespacho < 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de despacho del DO: ' . $row['DocImpoNoDO'] . ' no puede ser menor a la fecha de Manifiesto'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaConsultaInventario']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha consulta de invetario del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaVisado']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Visado del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['DeclImpoFechaAcept']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Aceptación del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['DeclImpoFechaLevante']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Levante del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($FechaEntregaDocumentosDespacho) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de entrega de documentos para despacho del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaDespacho', 'Value' => $value));
                        }
                    }
                    break;
                case 'FechaEntregaDocumentosDespacho':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaEntregaDocumentosDespacho']) > 0 && ConvertFechaHour($arrayData['FechaEntregaDocumentosDespacho']) != ConvertFechaHour($row['FechaEntregaDocumentosDespacho'])) {
                        // $DiasMaxManifEntrgaDocs = CalcularDias($FechaManifiesto, $FechaEntregaDocumentosDespacho);
                        // if ($DiasMaxManifEntrgaDocs < 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de entrega de documentos para despacho del DO: ' . $row['DocImpoNoDO'] . ' no puede ser menor a la fecha de Manifiesto'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaConsultaInventario']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha consulta de invetario del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaVisado']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Visado del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['DeclImpoFechaAcept']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Aceptación del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['DeclImpoFechaLevante']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Levante del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaEntregaDocumentosDespacho', 'Value' => $value));
                        }
                    }
                    break;
                case 'FechaFormulario':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaFormulario']) > 0 && ConvertFechaHour($arrayData['FechaFormulario']) != ConvertFechaHour($row['FechaFormulario'])) {
                        // $DiasMaxManifFormulario = CalcularDias($FechaManifiesto, $FechaFormulario);
                        // if ($DiasMaxManifFormulario < 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Fomulario (FFMM)  del DO: ' . $row['DocImpoNoDO'] . ' no puede ser menor a la fecha de Manifiesto'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaConsultaInventario']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha consulta de invetario del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaFormulario', 'Value' => $value));
                        }
                    }
                    break;
                case 'FechaEntregaApoyoOperativo':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaEntregaApoyoOperativo']) > 0 && ConvertFechaHour($arrayData['FechaEntregaApoyoOperativo']) != ConvertFechaHour($row['FechaEntregaApoyoOperativo'])) {
                        // $DiasMaxManifEntregaApoyo = CalcularDias($FechaManifiesto, $FechaEntregaApoyoOperativo);
                        // if ($DiasMaxManifEntregaApoyo < 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de despacho del DO: ' . $row['DocImpoNoDO'] . ' no puede ser menor a la fecha de Manifiesto'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaConsultaInventario']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha consulta de invetario del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaVisado']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Visado del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['DeclImpoFechaAcept']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Aceptación del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['DeclImpoFechaLevante']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Levante del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($FechaEntregaDocumentosDespacho) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de entrega de documentos para despacho del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaEntregaApoyoOperativo', 'Value' => $value));
                        }
                    }
                    break;
                case 'FechaDevolucionFacturacion':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaDevolucionFacturacion']) > 0 && $arrayData['FechaDevolucionFacturacion'] != ConvertFechaHour($row['FechaDevolucionFacturacion'])) {
                        // $DiasMaxManifDevFacturacion = CalcularDias($FechaManifiesto, $FechaDevolucionFacturacion);
                        // if ($DiasMaxManifDevFacturacion < 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Fecha de Devolución Facturación del DO: ' . $row['DocImpoNoDO'] . ' no puede ser menor a la fecha de Manifiesto'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaConsultaInventario']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha consulta de invetario del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaVisado']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Visado del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['DeclImpoFechaAcept']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Aceptación del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['DeclImpoFechaLevante']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Levante del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaDevolucionFacturacion', 'Value' => $value));
                        }
                    }
                    break;
                case 'FechaEntregaDoDevolucionFacturacion':
                    $ErrorField = false;
                    if (strlen($arrayData['FechaEntregaDoDevolucionFacturacion']) > 0 && $arrayData['FechaEntregaDoDevolucionFacturacion'] != ConvertFechaHour($row['FechaEntregaDoDevolucionFacturacion'])) {
                        // $DiasMaxManifDoDevolucion = CalcularDias($FechaManifiesto, $FechaEntregaDoDevolucionFacturacion);
                        // if ($DiasMaxManifDoDevolucion < 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Fecha de Devolución Facturación del DO: ' . $row['DocImpoNoDO'] . ' no puede ser menor a la fecha de Manifiesto'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaConsultaInventario']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha consulta de invetario del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['FechaVisado']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Visado del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['DeclImpoFechaAcept']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Aceptación del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($row['DeclImpoFechaLevante']) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Levante del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        // if (strlen($FechaDevolucionFacturacion) == 0) {
                        //     array_push($DataResult, array('Status' => 'Error', 'MensajeError' => 'La Fecha de Fecha de Devolución Facturación del DO: ' . $row['DocImpoNoDO'] . ' No puede estar Vacia'));
                        //     $ErrorField = true;
                        // }
                        if ($ErrorField == false) {
                            array_push($DataResult, array('Status' => 'Success', 'CampoUpdate' => 'FechaEntregaDoDevolucionFacturacion', 'Value' => $value));
                        }
                    }
                    break;
                default:
                    break;
            }
        }

        if (count($DataResult) > 0) {
            return $DataResult;
        } else {
            return 0;
        }
    }
}

function SQLUpdaterData($connMysql, $CadenaUpdate)
{

    $Parametros = '';
    $data       = array();
    foreach ($CadenaUpdate as $row) {
        $CampoUpdate        = $row['CampoUpdate'];
        $Value              = $row['Value'];
        $DataNombre         = ReturnNombresSearch($_SESSION['CampoUser'], $_SESSION['UserID'], $connMysql);
        $NombreBuscar       = $DataNombre['NombreUser'];
        $ConcateFechaNombre = '[' . date('Y-m-d H:i') . ' ' . $NombreBuscar . ']<br>';
        switch ($CampoUpdate) {
            case 'ObsrvCliente':
                $ObsrvCliente = $row['Value'] . '<br>';

                $Parametros .= "$CampoUpdate=CONCAT('$ConcateFechaNombre $Value',$CampoUpdate),";
                break;
            case 'ObsrvBitacora':
                $ObsrvBitacora = $row['Value'] . '<br>';

                $Parametros .= "$CampoUpdate=CONCAT('$ConcateFechaNombre $Value',$CampoUpdate),";
                break;
            case 'ObsSeguimiento':
                $ObsSeguimiento = $row['Value'] . '<br>';

                $Parametros .= "$CampoUpdate=CONCAT('$ConcateFechaNombre $Value',$CampoUpdate),";
                break;
            default:
                $Parametros .= "$CampoUpdate='$Value',";
                break;
        }
    }
    $idConverted = implode(',', $_SESSION['SessionIDS']);
    $Parametros  = substr($Parametros, 0, -1);
    $UpdateSQL   = "UPDATE IMSeguimientoOperativo  SET $Parametros   WHERE LlaveUnicaDO IN ('$idConverted') ";
    $stmt        = $connMysql->prepare($UpdateSQL);
    $stmt->execute();
}
function EjecutarProcedimientoTRK($connMysql, $CadenaUpdate)
{
    $SessionIDS = $_SESSION['SessionIDS'];
    $UsuarioID  = $_SESSION['UserID'];

    $connMSSQL = connMSSQL(4);
    $sqlTxt    = '';
    //print_r($CadenaUpdate);
    foreach ($SessionIDS as $ID) {
        $DocImpoNoDocTransp                  = "Null";
        $FechaDespacho                       = "Null";
        $FechaFormulario                     = "Null";
        $FechaManifiesto                     = "Null";
        $NumeroManifiesto                    = "Null";
        $ParcialNumero                       = "Null";
        $DepositoZonaFranca                  = "Null";
        $Deposito                            = "Null";
        $DocimpoObsSeguimiento               = "Null";
        $ObsrvCliente                        = "Null";
        $ObsrvBitacora                       = "Null";
        $DocImpoFechaETA                     = "Null";
        $FechaConsultaInventario             = "Null";
        $FechaEntregaDocumentosDespacho      = "Null";
        $FechaFomulario                      = "Null";
        $FechaEntregaApoyoOperativo          = "Null";
        $FechaDevolucionFacturacion          = "Null";
        $FechaEntregaDoDevolucionFacturacion = "Null";
        $FechaReciboDocs                     = 'Null';
        $FechaSolicitudAnticipo              = 'Null';
        $FechaReciboAnticipo                 = 'Null';
        $FechaReciboDocumentos               = 'Null';
        $FechaReciboDocsPuerto               = 'Null';
        $DataDO                              = SeleccionarIDTRK($connMysql, $ID);
        $OrdenNacID                          = $DataDO['OrdenNacID'];
        $DocImpoID                           = $DataDO['DocImpoID'];
        foreach ($CadenaUpdate as $row) {

            switch ($row['CampoUpdate']) {
                case 'FechaReciboDocs':
                    $FechaReciboDocs = ConvertFechaForInsert($row['Value']);
                    $FechaReciboDocs = "'$FechaReciboDocs'";
                    break;
                case 'FechaSolicitudAnticipo':
                    $FechaSolicitudAnticipo = ConvertFechaForInsert($row['Value']);
                    $FechaSolicitudAnticipo = "'$FechaSolicitudAnticipo'";
                    break;
                case 'FechaReciboAnticipo':
                    $FechaReciboAnticipo = ConvertFechaForInsert($row['Value']);
                    $FechaReciboAnticipo = "'$FechaReciboAnticipo'";
                    break;
                case 'FechaReciboDocumentos':
                    $FechaReciboDocumentos = ConvertFechaForInsert($row['Value']);
                    $FechaReciboDocumentos = "'$FechaReciboDocumentos'";
                    break;
                case 'FechaReciboDocsPuerto':
                    $FechaReciboDocsPuerto = ConvertFechaForInsert($row['Value']);
                    $FechaReciboDocsPuerto = "'$FechaReciboDocsPuerto'";
                    break;
                case 'DocImpoNoDocTransp':
                    $DocImpoNoDocTransp = $row['Value'];
                    $DocImpoNoDocTransp = "'$DocImpoNoDocTransp'";
                    break;
                case 'FechaDespacho':
                    $FechaDespacho = ConvertFechaForInsert($row['Value']);
                    $FechaDespacho = "'$FechaDespacho'";
                    break;
                case 'FechaFormulario':
                    $FechaFomulario = ConvertFechaForInsert($row['Value']);
                    $FechaFomulario = "'$FechaFomulario'";
                    break;
                case 'FechaManifiesto':
                    $FechaManifiesto = ConvertFechaForInsert($row['Value']);
                    $FechaManifiesto = "'$FechaManifiesto'";
                    break;
                case 'NumeroManifiesto':
                    $NumeroManifiesto = trim($row['Value']);
                    $NumeroManifiesto = "'$NumeroManifiesto'";
                    break;
                case 'ParcialNumero':
                    $ParcialNumero = $row['Value'];
                    $ParcialNumero = "$ParcialNumero";
                    break;
                case 'DepositoZonaFranca':
                    $DepositoZonaFranca = $row['Value'];
                    $DepositoZonaFranca = "$DepositoZonaFranca";
                    break;
                case 'Deposito':
                    $Deposito = $row['Value'];
                    $Deposito = "$Deposito";
                    break;
                case 'ObsSeguimiento':
                    $DocimpoObsSeguimiento = $row['Value'];
                    $DocimpoObsSeguimiento = "'$DocimpoObsSeguimiento'";
                    break;
                case 'ObsrvCliente':
                    $ObsrvCliente = $row['Value'];
                    $ObsrvCliente = "'$ObsrvCliente'";
                    break;
                case 'ObsrvBitacora':
                    $ObsrvBitacora = $row['Value'];
                    $ObsrvBitacora = "'$ObsrvBitacora'";
                    break;
                case 'DocImpoFechaETA':
                    $DocImpoFechaETA = ConvertFechaForInsert($row['Value']);
                    $DocImpoFechaETA = "'$DocImpoFechaETA'";
                    break;
                case 'FechaConsultaInventario':
                    $FechaConsultaInventario = ConvertFechaForInsert($row['Value']);
                    $FechaConsultaInventario = "'$FechaConsultaInventario'";
                    break;
                case 'FechaEntregaDocumentosDespacho':
                    $FechaEntregaDocumentosDespacho = ConvertFechaForInsert($row['Value']);
                    $FechaEntregaDocumentosDespacho = "'$FechaEntregaDocumentosDespacho'";
                    break;
                case 'FechaFormulario':
                    $FechaFormulario = ConvertFechaForInsert($row['Value']);
                    $FechaFormulario = "'$FechaFormulario'";
                    break;
                case 'FechaEntregaApoyoOperativo':
                    $FechaEntregaApoyoOperativo = ConvertFechaForInsert($row['Value']);
                    $FechaEntregaApoyoOperativo = "'$FechaEntregaApoyoOperativo'";
                    break;
                case 'FechaDevolucionFacturacion':
                    $FechaDevolucionFacturacion = ConvertFechaForInsert($row['Value']);
                    $FechaDevolucionFacturacion = "'$FechaDevolucionFacturacion'";
                    break;
                case 'FechaEntregaDoDevolucionFacturacion':
                    $FechaEntregaDoDevolucionFacturacion = ConvertFechaForInsert($row['Value']);
                    $FechaEntregaDoDevolucionFacturacion = "'$FechaEntregaDoDevolucionFacturacion'";
                    break;
            }
        }
        $Proceso          = 2;
        $procedure_params = array();

        $sql = "EXEC [Repecev2005].[dbo].[SP_ActualizarDatosSeguimientoOperativo]
        @Proceso = 2,
        @DocimpoID = " . $DocImpoID . ",
        @OrdenNacID = " . $OrdenNacID . ",
        @DocImpoNoDocTransp = " . $DocImpoNoDocTransp . ",
        @DocImpoFechaETA = " . $DocImpoFechaETA . ",
        @FechaManifiesto = " . $FechaManifiesto . ",
        @FechaConsultaInventario = " . $FechaConsultaInventario . ",
        @FechaDespacho = " . $FechaDespacho . ",
        @NumeroManifiesto = " . $NumeroManifiesto . ",
        @ParcialNumero = " . $ParcialNumero . ",
        @FechaEntregaDocumentosDespacho = " . $FechaEntregaDocumentosDespacho . ",
        @FechaFomulario = " . $FechaFomulario . ",
        @FechaEntregaApoyoOperativo = " . $FechaEntregaApoyoOperativo . ",
        @FechaDevolucionFacturacion = " . $FechaDevolucionFacturacion . ",
        @FechaEntregaDoDevolucionFacturacion = " . $FechaEntregaDoDevolucionFacturacion . ",
        @DepositoZonaFranca = " . $DepositoZonaFranca . ",
        @TerminalPortuario = " . $Deposito . ",
        @DocimpoObsSeguimiento = " . $DocimpoObsSeguimiento . ",
        @DocimpoObsCliente = " . $ObsrvCliente . ",
        @DocimpoObsBitacora = " . $ObsrvBitacora . ",
        @UsuarioID = " . $UsuarioID . ",
        @DocImpoFechaReciboDocs = " . $FechaReciboDocumentos . ",
        @OrdenNacFechaReciboDocs = " . $FechaReciboDocs . ",
        @FechaSolicitudAnticipo = " . $FechaSolicitudAnticipo . ",
        @FechaReciboAnticipo = " . $FechaReciboAnticipo . ",
        @OrdenNAcFechaReciboDocsPuerto = " . $FechaReciboDocsPuerto . "";

        $sqlTxt .= "EXEC [Repecev2005].[dbo].[SP_ActualizarDatosSeguimientoOperativo]
        @Proceso = 2,
        @DocimpoID = " . $DocImpoID . ",
        @OrdenNacID = " . $OrdenNacID . ",
        @DocImpoNoDocTransp = " . $DocImpoNoDocTransp . ",
        @DocImpoFechaETA = " . $DocImpoFechaETA . ",
        @FechaManifiesto = " . $FechaManifiesto . ",
        @FechaConsultaInventario = " . $FechaConsultaInventario . ",
        @FechaDespacho = " . $FechaDespacho . ",
        @NumeroManifiesto = " . $NumeroManifiesto . ",
        @ParcialNumero = " . $ParcialNumero . ",
        @FechaEntregaDocumentosDespacho = " . $FechaEntregaDocumentosDespacho . ",
        @FechaFomulario = " . $FechaFomulario . ",
        @FechaEntregaApoyoOperativo = " . $FechaEntregaApoyoOperativo . ",
        @FechaDevolucionFacturacion = " . $FechaDevolucionFacturacion . ",
        @FechaEntregaDoDevolucionFacturacion = " . $FechaEntregaDoDevolucionFacturacion . ",
        @DepositoZonaFranca = " . $DepositoZonaFranca . ",
        @TerminalPortuario = " . $Deposito . ",
        @DocimpoObsSeguimiento = " . $DocimpoObsSeguimiento . ",
        @DocimpoObsCliente = " . $ObsrvCliente . ",
        @DocimpoObsBitacora = " . $ObsrvBitacora . ",
        @UsuarioID = " . $UsuarioID . ",
        @DocImpoFechaReciboDocs = " . $FechaReciboDocumentos . ",
        @OrdenNacFechaReciboDocs = " . $FechaReciboDocs . ",
        @FechaSolicitudAnticipo = " . $FechaSolicitudAnticipo . ",
        @FechaReciboAnticipo = " . $FechaReciboAnticipo . ",
        @OrdenNAcFechaReciboDocsPuerto = " . $FechaReciboDocsPuerto . "\n";

        $stmt   = sqlsrv_prepare($connMSSQL, $sql, $procedure_params);
        $result = sqlsrv_execute($stmt);

        // if ($err = sqlsrv_errors()) {
        //     echo "There were errors or warnings!<br/>";
        //     print_r($err);
        //     echo "<br/>";
        // }
        $ValidarEjecucionTRK = ValidarEjecucionTRK($connMSSQL, $DocImpoID, $OrdenNacID);
        if ($ValidarEjecucionTRK == false) {
            $data['Result'] = 'Problema de ejecución';
        } else {
            $data['Result']   = 'OK';
            $data['ApiSonar'] = PeticionAPI($ID);
        }
        // sqlsrv_close($connMSSQL);

    }
    $data['sqlTxt'] = $sqlTxt;
    sqlsrv_close($connMSSQL);
    return $data;
}

function SelectCampo($FechaPost, $FechaDB)
{
    if (strlen($FechaPost) > 0) {
        return ConvertFecha($FechaPost);
    } else if (strlen($FechaDB) > 0) {
        return ConvertFecha($FechaDB);
    } else {
        return '';
    }
}

function ValidatePostingChar($String)
{
    $Funcion1 = htmlspecialchars($String);
    return $Funcion1;
}

function RemoveBR($String)
{
    return preg_replace("/\r|\n|\s+/", "", $String);
}

function SelectoresDepTerminal($connMysql)
{
    $DepositoSelected = $_POST['DepositoSelected'];
    $TerminalSelected = $_POST['TerminalSelected'];

    $SQL  = "SELECT * FROM tabc_so_depositosterminales";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $Cantidad     = $stmt->rowCount();
    $data         = array();
    $TotalRefeTax = 0;
    if ($Cantidad > 0) {
        if (strlen($DepositoSelected) == 0) {
            $Depositos = '<option selected value="">-Seleccione Depositos-</option>';
        } else {
            $Depositos = '<option value="">-Seleccione Depositos-</option>';
        }
        if (strlen($TerminalSelected) == 0) {
            $Terminales = '<option selected value="">-Seleccione Terminal Portuario-</option>';
        } else {
            $Terminales = '<option value="">-Seleccione Terminal Portuario-</option>';
        }

        foreach ($result as $row) {
            if ($TerminalSelected == $row['id_trk']) {
                $SelectedTerminal = 'selected';
            } else {
                $SelectedTerminal = '';
            }
            if ($DepositoSelected == $row['id_trk']) {
                $SelectedDeposito = 'selected';
            } else {
                $SelectedDeposito = '';
            }

            if ($row['Tipo'] == 'ZF') {
                $Depositos .= '<option ' . $DepositoSelected . ' value="' . $row['id_trk'] . '">' . $row['Nombre'] . '</option>';
            } else {
                $Terminales .= '<option  ' . $SelectedTerminal . ' value="' . $row['id_trk'] . '">' . $row['Nombre'] . '</option>';
            }
        }
    }
    $data               = array();
    $data['Depositos']  = $Depositos;
    $data['Terminales'] = $Terminales;
    return json_encode($data);
}


function SeleccionarIDTRK($connMysql, $ID)
{
    $FiltroActivo = FiltroActivo();
    $SQL          = "SELECT * FROM IMSeguimientoOperativo WHERE LlaveUnicaDO='$ID' AND $FiltroActivo  LIMIT 1";
    $stmt         = $connMysql->prepare($SQL);
    $stmt->execute();
    $data = array();
    $row  = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        $data['DocImpoID'] = $row['DocImpoID'];
        if (is_numeric($row['OrdenNacID'])) {
            $data['OrdenNacID'] = $row['OrdenNacID'];
        } else {
            $data['OrdenNacID'] = 'Null';
        }
    }
    return $data;
}

function PeticionAPI($ID)
{

    CalcularData($param = "ID = $ID");

    //     $opciones = array(
    //         'http' => array(
    //             'method' => "GET",
    //             'header' => "Accept-language: en\r\n",
    //         ),
    //     );

    //     $contexto = stream_context_create($opciones);

    // // Abre el fichero usando las cabeceras HTTP establecidas arriba
    //     $Respuesta = file_get_contents('http://localhost/abc-so/dist/php/?APIV1=CalcularDatos&Token=pruebas&ID=' . $ID, false, $contexto);
}

function ConvertFechaForInsert($Fecha)
{
    $FechaResult = date('Y-m-d', strtotime($Fecha));
    if ($FechaResult == '1969-12-31') {

        return '';
    } else {
        if ($Fecha == '') {
            return '';
        } else {
            return date('d/m/Y H:i:s', strtotime($Fecha));
        }
    }
}

function ValidarEjecucionTRK($connMSSQL, $DocImpoID, $OrdenNacID)
{
    if ($OrdenNacID != 'Null') {
        $paramSearch = "OrdenNacID='$OrdenNacID'";
    } else {
        $paramSearch = "DocImpoID='$DocImpoID'";
    }

    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $params  = array();

    $SQL      = " SELECT * FROM [BotAbc].[dbo].[BSLogSentencias] WHERE $paramSearch and Estado='1'";
    $stmt     = sqlsrv_query($connMSSQL, $SQL, $params, $options);
    $Cantidad = sqlsrv_num_rows($stmt);
    $row      = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($Cantidad > 0) {
        $params['Estado']               = $row['Estado'];
        $params['SentenciaObservacion'] = $row['SentenciaObservacion'];
        ActulizarEstadoSentencia($connMSSQL, $row['ID']);
        return $params;
    } else {
        return false;
    }
}

function ActulizarEstadoSentencia($connMSSQL, $ID)
{

    $UpdateSQL = "UPDATE [BotAbc].[dbo].[BSLogSentencias] SET Estado='2'  WHERE ID='$ID' ";
    $stmt      = sqlsrv_prepare($connMSSQL, $UpdateSQL, array());
    if (sqlsrv_execute($stmt) === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        return 1;
    }
}
