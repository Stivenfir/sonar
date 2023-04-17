<?php
function BucadorDeTexto($connMysql)
{
    $ValorInput = $_POST['ValorInput'];
    $html       = '';
    $UserID     = $_SESSION['UserID'];
    switch ($_SESSION['RolID']) {
        case '1':
        case '9410':
            $html .= SelectData('Director', $ValorInput, 'ID > 0', $connMysql);
            $html .= SelectData('JefeCuenta', $ValorInput, 'ID > 0', $connMysql);
            $html .= SelectData('Coordinador', $ValorInput, 'ID > 0', $connMysql);
            $html .= SelectData('Cliente', $ValorInput, 'ID > 0', $connMysql);
            $html .= SearchDO($ValorInput, 'ID > 0', $connMysql);
            break;
        case '2':
            $html .= SelectData('JefeCuenta', $ValorInput, "DirectorID= '$UserID'", $connMysql);
            $html .= SelectData('Coordinador', $ValorInput, "DirectorID= '$UserID'", $connMysql);
            $html .= SelectData('Cliente', $ValorInput, "DirectorID= '$UserID'", $connMysql);
            $html .= SearchDO($ValorInput, "DirectorID= '$UserID'", $connMysql);
            break;
        case '3':
            $html .= SelectData('Coordinador', $ValorInput, "JefeCuentaID= '$UserID'", $connMysql);
            $html .= SelectData('Cliente', $ValorInput, "JefeCuentaID= '$UserID'", $connMysql);
            $html .= SearchDO($ValorInput, "JefeCuentaID= '$UserID'", $connMysql);
            break;
        case '4':
            $html .= SelectData('Cliente', $ValorInput, "EjecutivoID = '$UserID'", $connMysql);
            $html .= SearchDO($ValorInput, "EjecutivoID = '$UserID'", $connMysql);
            break;
    }
    if (strlen($html) > 0) {
        return $html;
    } else {
        return '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x text-black close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close text-black" data-dismiss="alert"></i> <strong>Sin resultados!</strong> La busqueda que intenta hacer no contienen ningun resultado </div>';
    }
}
function SelectData($Tipo, $value, $FiltroLogin, $connMysql)
{
    $ActivoEnTablero = LastActivoEnTablero($connMysql);
    switch ($Tipo) {
        case 'Director':
            $NombreField = 'Director';
            $IdField     = 'DirectorID';
            break;
        case 'JefeCuenta':
            $NombreField = 'JefeCuenta';
            $IdField     = 'JefeCuentaID';
            break;
        case 'Coordinador':
            $NombreField = 'Ejecutivo';
            $IdField     = 'EjecutivoID';
            break;
        case 'Cliente':
            $NombreField = 'Cliente';
            $IdField     = 'ClienteID';
            break;
            case 'Cliente':
                $NombreField = 'Cliente';
                $IdField     = 'ClienteID';
                break;
    }
    $SQL  = "SELECT distinct $NombreField, $IdField FROM IMSeguimientoOperativo WHERE $FiltroLogin  AND  ($NombreField LIKE '%$value' OR   $NombreField LIKE '%$value%' OR   $NombreField LIKE '$value%' )";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $TotalRefeTax = 0;
    $html         = '';
    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            if (strlen($row[$NombreField]) == 0 || strlen($row[$IdField]) == 0) {
            } else {
                $DataArray = ReturnNombresSearch($IdField, $row[$IdField], $connMysql);
                switch ($Tipo) {
                    case 'Director':
                        $tipoBusqueda = '<div class="user-status">
    <span class="badge badge-primary">Director</span>
</div>';
                        break;
                    case 'JefeCuenta':
                        $tipoBusqueda = '<div class="user-status">
    <span class="badge badge-primary">Jefe Cuenta</span>
</div>';
                        break;
                    case 'Coordinador':
                        $tipoBusqueda = '<div class="user-status">
    <span class="badge badge-primary">Coordinador Cuenta</span>
</div>';
                        break;
                    case 'Cliente':
                        $tipoBusqueda = '<div class="user-status">
    <span class="badge badge-primary">Cliente</span>
</div>';
                        break;
                }
                $NombreBuscar = $DataArray[$NombreField];
                $html .= '
<div id="' . $row[$IdField] . '" data-campo="' . $IdField . '"  class="BtnsItemSearch items">
    <div class="user-name">
        <p class="">' . $NombreBuscar . '</p>
    </div>
    ' . $tipoBusqueda . '
</div>';
            }
        }
        $html .= '';
        return $html;
    }
}
function SearchDO($value, $FiltroLogin, $connMysql)
{
    unset($_SESSION['SessionIDS']);
    $ActivoEnTablero = LastActivoEnTablero($connMysql);
    $SQL  = "SELECT * FROM IMSeguimientoOperativo WHERE   (DocImpoNoDO LIKE '%$value%') AND $FiltroLogin AND ActivoEnTablero =  $ActivoEnTablero ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $TotalRefeTax = 0;
    $html         = '';
    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            $tipoBusqueda = '<div class="user-status">
    <span class="badge badge-default"><p class=""><small>' . DetectarNombreEstado($row['EstadoCalculado']) . '</small></p></span>
</div> <div class="user-status">
    <span class="badge badge-primary">DO</span>
</div>';
            $html .= '
<div id="' . $row['LlaveUnicaDO'] . '" data-campo="' . $row['DocImpoNoDO'] . '"  class="BtnsItemSearchDO items">
    <div class="user-name">
        <p class="">' . $row['DocImpoNoDO'] . '</p>
         <p class=""><small>Nac: ' . $row['OrdenNacID'] . '</small></p>
    </div>
    <div class="user-name">
        <p class=""><small>' . $row['Cliente'] . '</small></p>
    </div>
    ' . $tipoBusqueda . '
</div>';
        }
        $html .= '';
        return $html;
    }
}
function SeleccionarItemSearch($connMysql)
{
    unset($_SESSION['BtnDirector']);
    unset($_SESSION['BtnJefeCuenta']);
    unset($_SESSION['BtnCoordinador']);
    unset($_SESSION['BtnCliente']);
    $Campo            = $_POST['CampoSearch'];
    $Valor            = $_POST['ValueSeleccionado'];
    $DataArrayNombres = ReturnNombresSearch($Campo, $Valor, $connMysql);
    switch ($Campo) {
        case 'DirectorID':
            $_SESSION['BtnDirector'] = $DataArrayNombres['DirectorID'];
            break;
        case 'JefeCuentaID':
            $_SESSION['BtnDirector']   = $DataArrayNombres['DirectorID'];
            $_SESSION['BtnJefeCuenta'] = $DataArrayNombres['JefeCuentaID'];
            break;
        case 'EjecutivoID':
            $_SESSION['BtnDirector']    = $DataArrayNombres['DirectorID'];
            $_SESSION['BtnJefeCuenta']  = $DataArrayNombres['JefeCuentaID'];
            $_SESSION['BtnCoordinador'] = $DataArrayNombres['EjecutivoID'];
            break;
        case 'ClienteID':
            $_SESSION['BtnDirector']    = $DataArrayNombres['DirectorID'];
            $_SESSION['BtnJefeCuenta']  = $DataArrayNombres['JefeCuentaID'];
            $_SESSION['BtnCoordinador'] = $DataArrayNombres['EjecutivoID'];
            $_SESSION['BtnCliente']     = $DataArrayNombres['ClienteID'];
            break;
    }
}
function ReturnNombresSearch($Campo, $Valor, $connMysql)
{
    $SQL  = "  SELECT  * FROM IMSeguimientoOperativo WHERE $Campo = '$Valor'  LIMIT 1";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $TotalRefeTax = 0;
    if ($stmt->rowCount() > 0) {
        $Data = array();
        foreach ($result as $row) {
            $Data['Director']     = $row['Director'];
            $Data['JefeCuenta']   = $row['JefeCuenta'];
            $Data['Ejecutivo']    = $row['Ejecutivo'];
            $Data['Cliente']      = $row['Cliente'];
            $Data['DirectorID']   = $row['DirectorID'];
            $Data['JefeCuentaID'] = $row['JefeCuentaID'];
            $Data['EjecutivoID']  = $row['EjecutivoID'];
            $Data['ClienteID']    = $row['ClienteID'];
            switch ($Campo) {
                case 'DirectorID':
                    $Data['NombreUser'] = $row['Director'];
                    break;
                case 'JefeCuentaID':
                    $Data['NombreUser'] = $row['JefeCuenta'];
                    break;
                case 'EjecutivoID':
                    $Data['NombreUser'] = $row['Ejecutivo'];
                    break;
            }
        }
        return $Data;
    }
}
function SelectDirectores($connMysql)
{
    $ActivoEnTablero = LastActivoEnTablero($connMysql);

    if ($_SESSION['RolID'] == 9410 || $_SESSION['RolID'] == 1) {
        unset($_SESSION['BtnDirector']);
        unset($_SESSION['BtnJefeCuenta']);
        unset($_SESSION['BtnCoordinador']);
        unset($_SESSION['BtnCliente']);
        $SQL  = "  SELECT distinct Director,DirectorID FROM IMSeguimientoOperativo   ";
        $stmt = $connMysql->prepare($SQL);
        $stmt->execute();
        $result       = $stmt->fetchAll();
        $TotalRefeTax = 0;
        if ($stmt->rowCount() > 0) {
            $html = '
<h6>Directores</h6>
<hr>
<ul class="list-icon">';
            foreach ($result as $row) {
                $html .= '<li class="animated bounceIn"><a  href="javascript:void(0);" id="' . $row['DirectorID'] . '" data-button="BtnDirector" class="BtnsSubMenuCircular" ><span class="ti-user"></span>
    <span   class="list-text">' . mb_ucwords($row['Director']) . ' </span></a>
</li>';
            }
            $html .= '</ul>';

            return $html;
        }
    }
}
function SelectJefeCuenta($connMysql)
{
    if ($_SESSION['RolID'] == 9410 || $_SESSION['RolID'] == 1 || $_SESSION['RolID'] == 2) {
        unset($_SESSION['BtnJefeCuenta']);
        unset($_SESSION['BtnCoordinador']);
        unset($_SESSION['BtnCliente']);
        $FiltroActivo = FiltroActivo();

        $SQL  = "  SELECT distinct JefeCuenta,JefeCuentaID FROM IMSeguimientoOperativo WHERE $FiltroActivo  ORDER BY JefeCuenta asc ";
        $stmt = $connMysql->prepare($SQL);
        $stmt->execute();
        $result       = $stmt->fetchAll();
        $TotalRefeTax = 0;
        if ($stmt->rowCount() > 0) {
            $html = '
<h6>Jefes de Cuenta</h6>
<hr>
<ul class="list-icon">';
            foreach ($result as $row) {
                if (strlen($row['JefeCuentaID']) == 0 || strlen($row['JefeCuenta']) == 0 || $row['JefeCuenta'] > 0) {
                } else {

                    $html .= '<li class="animated bounceIn"><a  href="javascript:void(0);" id="' . $row['JefeCuentaID'] . '" data-button="BtnJefeCuenta" class="BtnsSubMenuCircular" ><span class="ti-user"></span>
    <span   class="list-text">' . mb_ucwords($row['JefeCuenta']) . ' </span></a>
</li>';
                }
            }
            $html .= '</ul>';
            return $html;
        }
    }
}
function SelectCoordinador($connMysql)
{
    if ($_SESSION['RolID'] == 9410 || $_SESSION['RolID'] == 9410 || $_SESSION['RolID'] == 1 || $_SESSION['RolID'] == 2 || $_SESSION['RolID'] == 3) {
        unset($_SESSION['BtnCoordinador']);
        unset($_SESSION['BtnCliente']);
        $FiltroActivo = FiltroActivo();

        $SQL = "SELECT COUNT(*) AS RecuentoFilas , EjecutivoID, Ejecutivo
FROM IMSeguimientoOperativo WHERE $FiltroActivo
GROUP BY EjecutivoID,Ejecutivo
HAVING COUNT(*) > 1
ORDER BY Ejecutivo ASC  LIMIT 20 ";
        $stmt = $connMysql->prepare($SQL);
        $stmt->execute();
        $result       = $stmt->fetchAll();
        $TotalRefeTax = 0;
        if ($stmt->rowCount() > 0) {
            $html = '
<h6>Coordinadores de Cuenta</h6>
<hr>
<ul class="list-icon">';
            foreach ($result as $row) {
                if (strlen($row['EjecutivoID']) == 0 || strlen($row['Ejecutivo']) == 0 || $row['Ejecutivo'] > 0) {
                } else {

                    $html .= '<li class="animated bounceIn"><a  href="javascript:void(0);" id="' . $row['EjecutivoID'] . '" data-button="BtnCoordinador" class="BtnsSubMenuCircular" ><span class="ti-user"></span>
    <span   class="list-text">' . mb_ucwords($row['Ejecutivo']) . ' </span></a>
</li>';
                }
            }
            $html .= '</ul>';
            return $html;
        }
    }
}
function SelectCliente($connMysql)
{
    unset($_SESSION['BtnCliente']);
    $FiltroActivo = FiltroActivo();
    $SQL          = " SELECT COUNT(*) AS RecuentoFilas , ClienteID, Cliente
FROM IMSeguimientoOperativo WHERE $FiltroActivo
GROUP BY ClienteID,Cliente
HAVING COUNT(*) > 1
ORDER BY RecuentoFilas DESC  LIMIT 20 ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $TotalRefeTax = 0;
    if ($stmt->rowCount() > 0) {
        $html = '
<h6>Clientes</h6>
<hr>
<ul class="list-icon">';
        foreach ($result as $row) {
            if (strlen($row['ClienteID']) == 0 || strlen($row['Cliente']) == 0 || $row['Cliente'] > 0) {
            } else {

                $html .= '<li class="animated bounceIn"><a  href="javascript:void(0);" id="' . $row['ClienteID'] . '" data-button="BtnCliente" class="BtnsSubMenuCircular" ><span class="ti-briefcase"></span>
    <span   class="list-text">' . mb_ucwords($row['Cliente']) . ' </span></a>
</li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }
}
function FiltrosIN($Session, $Campo)
{
    if (isset($_SESSION[$Session])) {
        $SessionValues = explode(',', $_SESSION[$Session]);
        $ValoresIN     = '';
        foreach ($SessionValues as $row) {
            if ($row == 'TODOS' || $row == 'NA') {
                return "ID > 0 ";
            } else {
                $ValoresIN .= "'$row',";
            }
        }
        $Valores = substr($ValoresIN, 0, -1);
        return "$Campo in ($Valores)  ";
    } else {
        return "ID > 0  ";
    }
}
function InicialesNombre($fullName)
{
    $NombreRows = explode(' ', $fullName);
    if (isset($NombreRows[2]) && isset($NombreRows[0])) {
        return substr($NombreRows[2], 0, 1) . substr($NombreRows[0], 0, 1);
    } else if (isset($NombreRows[2]) && !isset($NombreRows[0])) {
        return substr($NombreRows[2], 0, 2);
    } else {
        return substr($fullName, 0, 2);
    }
}
function GenerarSessionFiltro()
{
    $TipoFiltro        = $_POST['TipoFiltro'];
    $ValueSeleccionado = $_POST['ValueSeleccionado'];
    if (!isset($_SESSION[$TipoFiltro])) {
        $_SESSION[$TipoFiltro] = $ValueSeleccionado;
    } else {
        if ($ValueSeleccionado == $_SESSION[$TipoFiltro]) {
            unset($_SESSION[$TipoFiltro]);
        } else {
            if (ValidarSeleccion($_SESSION[$TipoFiltro], $ValueSeleccionado, $TipoFiltro) == false) {
                $_SESSION[$TipoFiltro] = $_SESSION[$TipoFiltro] . ',' . $ValueSeleccionado;
            }
        }
    }
    if (isset($_SESSION[$TipoFiltro])) {
        return $_SESSION[$TipoFiltro];
    } else {
        unset($_SESSION[$TipoFiltro]);
    }
}
function ValidarSeleccion($sessionActiva, $UserSearch, $TipoFiltro, $Visual = 0)
{
    $UsersRows = explode(',', $sessionActiva);
    if (in_array($UserSearch, $UsersRows, true)) {
        if ($Visual == 0) {
            $_SESSION[$TipoFiltro] = str_replace(',' . $UserSearch, '', $sessionActiva);
        }
        return true;
    } else {
        return false;
    }
}
function FiltroActivo($TipoFiltro = null)
{
    $connMysql      = connMysql();
    // $ActivoEnTablero = LastActivoEnTablero($connMysql);

    if ($TipoFiltro == null) {
        $ActivoEnTablero = "";
    } else {
        $ActivoEnTablero = "";
    }

    // if (in_array(BtnJefeCuenta, haystack)) {
    //     BtnJefeCuenta
    //     BtnCoordinador
    //     BtnCliente
    //     BtnDirector
    if (array_key_exists('BtnCliente', $_SESSION)) {
        $sessionSearhc = 'BtnCliente';
        $Campo         = 'ClienteID';
    } else if (array_key_exists('BtnCoordinador', $_SESSION)) {
        $sessionSearhc = 'BtnCoordinador';
        $Campo         = 'EjecutivoID';
    } else if (array_key_exists('BtnJefeCuenta', $_SESSION)) {
        $sessionSearhc = 'BtnJefeCuenta';
        $Campo         = 'JefeCuentaID';
    } else if (array_key_exists('BtnDirector', $_SESSION)) {
        $sessionSearhc = 'BtnDirector';
        $Campo         = 'DirectorID';
    } else {
        $sessionSearhc = 'Todos';
    }
    //}
    if (isset($_SESSION[$sessionSearhc])) {
        $SessionValues = explode(',', $_SESSION[$sessionSearhc]);
        $ValoresIN     = '';
        foreach ($SessionValues as $row) {
            if ($row == 'TODOS' || $row == 'NA') {
                return "ID > 0 ";
            } else {
                $ValoresIN .= "'$row',";
            }
        }
        $Valores = substr($ValoresIN, 0, -1);
        if (isset($_SESSION['AduanaFiltro'])) {
            $ValoreAduana = $_SESSION['AduanaFiltro'];
            return "(AdminAduanasNombre in ($ValoreAduana)) ";
        }
        return "$Campo in ($Valores)  ";
    } else {
        if (isset($_SESSION['AduanaFiltro'])) {
            $ValoreAduana = $_SESSION['AduanaFiltro'];
            return "ID > 0 AND (AdminAduanasNombre in ($ValoreAduana)) ";
        }
        return "ID > 0  ";
    }
}
// $connMysql = connMSSQL();
// // echo MenuFiltroActivo($connMysql);
// //     print_r($_SESSION);
function MenuFiltroActivo($connMysql)
{
    // if (in_array(BtnJefeCuenta, haystack)) {
    //     BtnJefeCuenta
    //     BtnCoordinador
    //     BtnCliente
    //     BtnDirector
    $Data = array();
    if (array_key_exists('BtnDirector', $_SESSION)) {
        $sessionSearhc              = 'BtnDirector';
        $Campo                      = 'DirectorID';
        $Data['DirectoresSelected'] = BuscarArregloNombres($Campo, 'Director,DirectorID', $sessionSearhc, $connMysql);
    } else {
        $Data['DirectoresSelected'] = 'Todos';
    }
    if (array_key_exists('BtnJefeCuenta', $_SESSION)) {
        $sessionSearhc         = 'BtnJefeCuenta';
        $Campo                 = 'JefeCuentaID';
        $Data['JefesSelected'] = BuscarArregloNombres($Campo, 'JefeCuenta,JefeCuentaID', $sessionSearhc, $connMysql);
    } else {
        $Data['JefesSelected'] = 'Todos';
    }
    if (array_key_exists('BtnCoordinador', $_SESSION)) {
        $sessionSearhc               = 'BtnCoordinador';
        $Campo                       = 'EjecutivoID';
        $Data['CoordinadorSelected'] = BuscarArregloNombres($Campo, 'Ejecutivo,EjecutivoID', $sessionSearhc, $connMysql);
    } else {
        $Data['CoordinadorSelected'] = 'Todos';
    }
    if (array_key_exists('BtnCliente', $_SESSION)) {
        $sessionSearhc            = 'BtnCliente';
        $Campo                    = 'ClienteID';
        $Data['ClientesSelected'] = BuscarArregloNombres($Campo, 'Cliente,ClienteID', $sessionSearhc, $connMysql);
    } else {
        $Data['ClientesSelected'] = 'Todos';
    }
    //}
    return json_encode($Data);
}
function BuscarArregloNombres($Campo, $Campos, $ValueSearch, $connMysql)
{
    if (isset($_SESSION[$ValueSearch])) {
        $SessionValues = explode(',', $_SESSION[$ValueSearch]);
        $ValoresIN     = '';
        foreach ($SessionValues as $row) {
            if ($row == 'TODOS' || $row == 'NA') {
                return "Todos";
            } else {
                $ValoresIN .= "'$row',";
            }
        }
        $Valores = substr($ValoresIN, 0, -1);
        return ReturnNombres($Campos, "$Campo in ($Valores)  ", $connMysql);
    } else {
        return "Todos ";
    }
}
function ReturnNombres($Campos, $FiltrosIN, $connMysql)
{
    $CamposRows = explode(',', $Campos);
    $SQL        = "  SELECT distinct $Campos FROM IMSeguimientoOperativo WHERE $FiltrosIN";
    $stmt       = $connMysql->prepare($SQL);
    $stmt->execute();
    $result       = $stmt->fetchAll();
    $TotalRefeTax = 0;
    if ($stmt->rowCount() > 0) {
        $html = '<ul class="list-icon">';
        foreach ($result as $row) {
            $html .= '<li class="animated bounceIn">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
<span class="list-text">' . mb_ucwords($row[$CamposRows[0]]) . ' </span><a title="Quitar del Filtro" class="RemoveListBtn" id="' . $CamposRows[1] . ',' . $row[$CamposRows[1]] . '"  href="javascript:void(0);">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-danger feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>
</li>';
        }
        $html .= '</ul>';
        return $html;
    }
}
function ValidarUserLog()
{
    $RolID           = $_SESSION['RolID'];
    $UserID          = $_SESSION['UserID'];
    $UsuarioLogueado = $_SESSION['UsuarioLogueado'];
    $RolName         = $_SESSION['RolName'];
    $CampoUser       = $_SESSION['CampoUser'];
    if ($UserID != '9999') {
        return $RolID;
    } else {
        return 5;
    }
}
function BorrarFiltro()
{
    switch ($_SESSION['RolID']) {
        case '9410':
        case '1':
            unset($_SESSION['BtnDirector']);
            unset($_SESSION['BtnJefeCuenta']);
            unset($_SESSION['BtnCoordinador']);
            unset($_SESSION['BtnCliente']);
            break;
        case '2':
            unset($_SESSION['BtnJefeCuenta']);
            unset($_SESSION['BtnCoordinador']);
            unset($_SESSION['BtnCliente']);
            break;
        case '3':
            unset($_SESSION['BtnCoordinador']);
            unset($_SESSION['BtnCliente']);
            break;
        case '4':
            unset($_SESSION['BtnCliente']);
            break;
    }
    return $_SESSION['RolID'];
}
function mb_ucwords($str)
{
    return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
}

function RemoveListBtn()
{

    $CamposRows  = explode(',', $_POST['CamposID']);
    $ValorRemove = $CamposRows[1];
    switch ($CamposRows[0]) {
        case 'DirectorID':
            $sessionSearhc = 'BtnDirector';
            break;
        case 'JefeCuentaID':
            $sessionSearhc = 'BtnJefeCuenta';
            break;
        case 'EjecutivoID':
            $sessionSearhc = 'BtnCoordinador';
            break;
        case 'ClienteID':
            $sessionSearhc = 'BtnCliente';
            break;
    }

    $FiltrosSelected = explode(',', $_SESSION[$sessionSearhc]);

    if (($key = array_search($ValorRemove, $FiltrosSelected)) !== false) {
        unset($FiltrosSelected[$key]);
    }
    if (count($FiltrosSelected) > 0) {

        $_SESSION[$sessionSearhc] = implode(", ", $FiltrosSelected);
    } else {
        unset($_SESSION[$sessionSearhc]);
    }
    return 1;
}
