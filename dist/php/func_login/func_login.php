<?php

function LoginFunc()
{
    // $data                        = array();
    // $_SESSION['RolID']           = 3;
    // $_SESSION['UserID']          = 16974;
    // $_SESSION['UsuarioLogueado'] = 'bvillalobos';
    // $_SESSION['RolName']         = 'Coordinador de cuenta';
    // $_SESSION['CampoUser']       = 'EjecutivoID';

    // switch ($_SESSION['RolID']) {

    //     case '2':
    //         $_SESSION['BtnDirector'] = 216;
    //         break;
    //     case '3':
    //         $_SESSION['BtnJefeCuenta'] = 16974;
    //         break;
    //     case '4':
    //         $_SESSION['BtnCoordinador'] = 16974;
    //         break;

    // }

    // $data['Success'] = true;
    // return json_encode($data);

    $usuarioLogin    = htmlspecialchars($_POST['username']);
    $UsuarioPassword = htmlspecialchars($_POST['password']);
    if ($usuarioLogin == 'root' && $UsuarioPassword == 'IBsmOL27000') {
        $RolID     = 1;
        $UsuarioID = 31056;
    } else if ($usuarioLogin == 'jfontecha' && $UsuarioPassword == 'Sonarjfontecha2022') {
        $RolID     = 1;
        $UsuarioID = 37897;
    } else if ($usuarioLogin == 'consulta' && $UsuarioPassword == 'SonarConsulta2706*') {
        $RolID     = 1;
        $UsuarioID = 9999;
    } else {

        $ArrayUsuariosAduana = array('Taniat', 'jsandoval',  'dtorres', 'vsanchez', 'ivanb', 'bcruz', 'lleon', 'avera', 'wceron', 'lpadilla', 'gamen', 'kcarvajal', 'mcayola', 'msepulveda');
        $ArrayAduanaUser = array(
            'Taniat' => array('Barranquilla'),
            'jnieves' => array('Barranquilla', 'Cartagena', 'Santa Marta'),
            'jsandoval' => array('Barranquilla'),
            'dtorres' => array('Buenaventura'),
            'vsanchez' => array('Cali'),
            'ivanb' => array('Cartagena'),
            'lleon' => array('Cartagena'),
            'avera' => array('Cartagena'),
            'kcaraballo' => array('Cartagena'),
            'bcruz' => array('Cartagena'),
            'wceron' => array('Ipiales'),
            'lpadilla' => array('Santa Marta'),
            'gamen' => array('Buenaventura'),
            'kcarvajal' => array('Buenaventura'),
            'mcayola' => array('Buenaventura'),
            'msepulveda' => array('Buenaventura'),
        );
        $aduanasSelect = array();
        $ExePass           = 'C:\xampp\IntegracionesTRK\ValidatePass.exe';
        $Parametros        = "$usuarioLogin $UsuarioPassword";
        $salida            = exec('"' . $ExePass . '"  ' . $Parametros . '');
        $row               = explode(',', $salida);
        $CantidadVariables = count($row);

        if ($CantidadVariables == 1) {
            $RolID = $row[0];
        } else {
            $RolID     = $row[0];
            $UsuarioID = $row[1];
            $ArrayUsuariosConfig = array('drivadeneira', 'esarmiento');
            if (in_array(strtolower($usuarioLogin), $ArrayUsuariosConfig)) {
                $RolID = 4;
            }

            if (in_array(strtolower($usuarioLogin), $ArrayUsuariosAduana)) {
                foreach ($ArrayAduanaUser[$usuarioLogin] as $aduanaRow) {

                    $aduanasSelect[] = "'$aduanaRow'";
                }
                $AduanaFiltro             = implode(',', $aduanasSelect);
                $_SESSION['AduanaFiltro'] = $AduanaFiltro;
                $RolID = 1;
            }
        }
    }

    if ($RolID == 1 || $RolID == 2 || $RolID == 3 || $RolID == 4 || $RolID == 9410) {

        $_SESSION['RolID']           = $RolID;
        $_SESSION['UserID']          = $UsuarioID;
        $_SESSION['UsuarioLogueado'] = $usuarioLogin;
        switch ($RolID) {
            case '1':
            case '9410':
                $_SESSION['CampoUser'] = 'DirectorID';
                $_SESSION['RolName']   = 'Administrador';
                $data['Success']       = true;
                break;
            case '2':
                $_SESSION['BtnDirector'] = $UsuarioID;
                $_SESSION['CampoUser']   = 'DirectorID';
                $_SESSION['RolName']     = 'Director';
                $data['Success']         = true;
                break;
            case '3':
                $_SESSION['BtnJefeCuenta'] = $UsuarioID;
                $_SESSION['CampoUser']     = 'JefeCuentaID';
                $_SESSION['RolName']       = 'Jefe de Cuenta';
                $data['Success']           = true;
                break;
            case '4':
                $_SESSION['BtnCoordinador'] = $UsuarioID;
                $_SESSION['CampoUser']      = 'EjecutivoID';
                $_SESSION['RolName']        = 'Coordinador de cuenta';
                $data['Success']            = true;
                break;
            default:
                $data['Error'] = 'Usuario sin rol consulte con el administrador';
                break;
        }
        if ($data['Success'] == true) {
            RegistrarActividad('Ingreso al Sistema');
        } else {
            RegistrarActividad('Falló inicio de sessión');
        }
    } else if ($RolID == 999) {
        $data['Error'] = 'Contraseña o Usuarios Incorrectas Verifique';
    } else {
        $data['Error'] = 'Errror en datos de acceso,validar vencimiento de clave y rol de tracking';
    }
    //echo $row['UsuarioPassword'];

    return json_encode($data);
}

function RegistrarActividad($TipoActividad)
{
    if ($TipoActividad == 'Falló inicio de sessión') {
        $ArraySQL = array(
            'RolID'           => '',
            'UserID'          => '',
            'UsuarioLogueado' => $_POST['usuarioLogin'],
            'TipoActividad'   => $TipoActividad,
        );
    } else {
        $ArraySQL = array(
            'RolID'           => $_SESSION['RolID'],
            'UserID'          => $_SESSION['UserID'],
            'UsuarioLogueado' => $_SESSION['UsuarioLogueado'],
            'TipoActividad'   => $TipoActividad,
        );
    }

    $FunctionsMySQL = new FunctionsMySQL();
    $connMysql      = connMysql();
    $FunctionsMySQL->Insert($ArraySQL, 'tabc_so_analitycs', $connMysql);
}


function ShowMessagesAdmin($connMysql)
{
    $PersonaID = $_SESSION['UserID'];
    $SQL  = "SELECT * FROM tabc_so_usuariosmail WHERE PersonaID='$PersonaID' AND mensaje_alert<=4 ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $row        = $stmt->fetch(PDO::FETCH_ASSOC);
        return MessageActual($connMysql, $row['mensaje_alert']);
    } else {
        return 'NoAlert';
    }
}

function MessageActual($connMysql, $mensaje_alert)
{
    $PersonaID = $_SESSION['UserID'];
    $SQL  = "SELECT * FROM tabc_mensaje_user ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $row        = $stmt->fetch(PDO::FETCH_ASSOC);
    $FunctionsMySQL = new FunctionsMySQL();
    $ArrayData = array(
        'ID' => $PersonaID,
        'FieldIdUpdate'     => 'PersonaID',
        'mensaje_alert'     =>  $mensaje_alert + 1,
    );
    $FunctionsMySQL->Update($ArrayData, 'tabc_so_usuariosmail', $connMysql);
    return $row['mensaje'];
}
