<?php

require_once "templates_mail/TemplateNotify.php";
require_once "classes/sendmail/class.phpmailer.php";
require_once "classes/sendmail/class.smtp.php";
define('PORT', '465');
define('CIFRADO', "ssl");
define('HOST', "secure.emailsrvr.com");
define('USERNAME', "informativo@abcrepecev.com");
define('PASS', "Abc123456*");

function SelectAllDo($connMysql)
{
    $BtnEnviar = '<button id="BtnCrearCorreo"  title="Enviar una Notificación" class="btn btn-primary" type="button">Enviar Alerta <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></button>';
    $BtnCrearCierre = '<button id="BtnCrearCierre"  title="Crear compromiso cierre diario" class="btn btn-info" type="button">Crear cierre diario <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg></button>';
    foreach ($_SESSION['SessionMailAll'] as $IDForMail) {
        ValidateMailSessionDO($IDForMail);
    }
    $Total = count($_SESSION['IDSForMail']);
    if ($Total > 0) {
        return $BtnCrearCierre . $BtnEnviar;
    } else {
        return 0;
    }
}

function SelectDoMail($connMysql)
{
    // unset($_SESSION['IDSForMail']);
    $BtnEnviar = '<button id="BtnCrearCorreo"  title="Enviar una Notificación" class="btn btn-primary" type="button">Enviar Alerta <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></button>';
    $BtnCrearCierre = '<button id="BtnCrearCierre"  title="Crear compromiso cierre diario" class="btn btn-info" type="button">Crear cierre diario <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg></button>';
    $IDForMail = $_POST['IDForMail'];
    ValidateMailSessionDO($IDForMail);
    $Total = count($_SESSION['IDSForMail']);
    if ($Total > 0) {
        return $BtnCrearCierre . $BtnEnviar;
    }
}

function ValidateMailSessionDO($IDForMail)
{
    if (isset($_SESSION['IDSForMail'])) {
        $key = array_search($IDForMail, $_SESSION['IDSForMail']);
        if (false !== $key) {
            unset($_SESSION['IDSForMail'][$key]);
        } else {
            array_push($_SESSION['IDSForMail'], $IDForMail);
        }
    } else {
        $_SESSION['IDSForMail'] = array($IDForMail);
    }
}
// $connMysql = connMysql();
// SendNotifysDO($connMysql);
function SendNotifysDO($connMysql)
{
    $Asunto = $_POST['Asunto'];
    $Mensaje = $_POST['Mensaje'];
    $DirectoresCheck = $_POST['DirectoresCheck'];
    $JefesCheck = $_POST['JefesCheck'];
    $CoordinadoresCheck = $_POST['CoordinadoresCheck'];
    $ValidacionMail = $DirectoresCheck . $JefesCheck . $CoordinadoresCheck;
    // print_r($_SESSION['IDSForMail']);
    $FunctionsMySQL = new FunctionsMySQL();

    $idConverted = implode(", ", $_SESSION['IDSForMail']);
    $SQL = "SELECT  DISTINCT EjecutivoID FROM IMSeguimientoOperativo WHERE LlaveUnicaDO  in($idConverted)  ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $html = '';
    $arrayMails = array();
    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            array_push($arrayMails, $row['EjecutivoID']);
        }

        foreach ($arrayMails as $EjecutivoID) {

            $DataMail = SelectMails($connMysql, $EjecutivoID);

            switch ($ValidacionMail) {
                case 111:
                    $Remitentes = $DataMail['MailDirector'] . ',' . $DataMail['MailJefecuenta'] . ',' . $DataMail['MailEjecutivo'];
                    break;
                case 110:
                    $Remitentes = $DataMail['MailDirector'] . ',' . $DataMail['MailJefecuenta'];
                    break;
                case 100:
                    $Remitentes = $DataMail['MailDirector'];
                    break;
                case 001:
                    $Remitentes = $DataMail['MailEjecutivo'];
                    break;
                case 011:
                    $Remitentes = $DataMail['MailJefecuenta'] . ',' . $DataMail['MailEjecutivo'];
                    break;
                case 010:
                    $Remitentes = $DataMail['MailJefecuenta'];
                    break;
                case 101:
                    $Remitentes = $DataMail['MailDirector'] . ',' . $DataMail['MailEjecutivo'];
                    break;
                default:
                    $Remitentes = $DataMail['MailJefecuenta'] . ',' . $DataMail['MailEjecutivo'];
                    break;
            }
        }
        $Adjunto = FileForMail($connMysql, $EjecutivoID);
        $arrayData = array(
            'Remitentes' => $Remitentes,
            'Asunto' => $Asunto,
            'Mensaje' => $Mensaje,
            'Adjunto' => $Adjunto,
            'CreadorID' => $_SESSION['UserID'],

        );
        $FunctionsMySQL->Insert($arrayData, 'tabc_so_AlertasMail', $connMysql);

        $arrayData = array(
            'FieldIdUpdate' => 'PersonaID',
            'ID' => $_SESSION['UserID'],
            'last_mail' => $Mensaje,
        );
        $FunctionsMySQL->Update($arrayData, 'tabc_so_usuariosmail', $connMysql);
        return ValidarColaCorreos($connMysql);
    }
}

function ValidarColaCorreos($connMysql)
{
    $FunctionsMySQL = new FunctionsMySQL();
    $CreadorID = $_SESSION['UserID'];
    $SQL = "SELECT  * FROM tabc_so_AlertasMail WHERE CreadorID  ='$CreadorID' AND Estado='SinEnviar' ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $html = '';
    $arrayMails = array();
    $List = '';
    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            $dataMail = array(
                'Remitentes' => $row['Remitentes'],
                'Asunto' => $row['Asunto'],
                'Mensaje' => $row['Mensaje'],
                'Adjunto' => $row['Adjunto'],
            );
            $Estado = EnviarNotificaciones($connMysql, $dataMail);
            $arrayData = array(
                'ID' => $row['ID'],
                'Estado' => $Estado,
            );
            $FunctionsMySQL->Update($arrayData, 'tabc_so_AlertasMail', $connMysql);

            $List .= 'Estado del envio: ' . $Estado . ' a ' . $row['Remitentes'] . '</br>';
        }
    }
    return $List;
}

function EnviarNotificaciones($connMysql, $dataMail)
{

    $SenderMail = 'Seguimientooperativo@abcrepecev.com';
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->CharSet = 'UTF-8';
    $mail->SMTPSecure = CIFRADO;
    $mail->Host = HOST;
    $mail->Port = PORT;
    $mail->Username = USERNAME;
    $mail->Password = PASS;
    //$mail->SMTPDebug  = 2;
    $DataNombre = ReturnNombresSearch($_SESSION['CampoUser'], $_SESSION['UserID'], $connMysql);
    $NombreBuscar = mb_ucwords($DataNombre['NombreUser']);
    if (strlen($NombreBuscar) == 0) {
        $NombreBuscar = 'Administrador seguimiento operativo';
    }
    $ReplyMail = Mailuser($connMysql, $_SESSION['UserID']);
    if (strlen($ReplyMail) == 0) {
        $ReplyMail = $NombreBuscar;
    }
    $mail->Sender = $SenderMail;
    $mail->SetFrom($SenderMail, $NombreBuscar, false);
    $mail->Subject = $dataMail['Asunto'];
    $mail->MsgHTML(TemplateSendDO($dataMail));
    $mail->addReplyTo($ReplyMail, $NombreBuscar);
    $mail->AddAttachment($dataMail['Adjunto']);
    $mail->AddEmbeddedImage('../../dist/assets/img/logo.png', 'logoAbc');
    $RowRemitentes = explode(',', $dataMail['Remitentes']);

    // $mail->AddAddress($ReplyMail);
    foreach ($RowRemitentes as $remitente) {
        $mail->AddAddress($remitente);
    }
    if ($mail->Send()) {

        return 'Enviado';
    } else {
        return 'FalloEnvio';
    }
}

function SelectMails($connMysql, $EjecutivoID)
{
    $idConverted = implode(", ", $_SESSION['IDSForMail']);
    $SQL = "SELECT * FROM IMSeguimientoOperativo WHERE  EjecutivoID ='$EjecutivoID' AND LlaveUnicaDO  in($idConverted) ";

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data = array();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $data['MailEjecutivo'] = Mailuser($connMysql, $row['EjecutivoID']);
    $data['MailDirector'] = Mailuser($connMysql, $row['DirectorID']);
    $data['MailJefecuenta'] = Mailuser($connMysql, $row['JefeCuentaID']);
    $data['JefeCuentaID'] = $row['JefeCuentaID'];
    $data['EjecutivoID'] = $row['EjecutivoID'];
    $data['DirectorID'] = $row['DirectorID'];
    return $data;
}

function Mailuser($connMysql, $PersonaID)
{

    $SQL = "SELECT * FROM  tabc_so_usuariosmail WHERE  PersonaID ='$PersonaID' ";

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data = array();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        return $row['PersonaEmail'];
    } else {
        return '';
    }
}

function GetLastMessage($connMysql)
{
    $CreadorID = $_SESSION['UserID'];
    $SQL = "SELECT * FROM  tabc_so_usuariosmail WHERE  PersonaID ='$CreadorID' ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data = array();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        return $row['last_mail'];
    } else {
        return '';
    }
}

function SelectEstados($connMysql)
{

    $SQL = "SELECT * FROM  tabc_so_estados order by Orden ASC";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data = array();

    $stmt->execute();
    $result = $stmt->fetchAll();
    $html = '<option value="">Seleccione un estado de compromiso</option>';
    $arrayMails = array();

    foreach ($result as $row) {
        $html .= '<option value="' . $row['EstadoCalculado'] . '">' . $row['Titulo'] . '</option>';
    }
    return $html;
}

function GeneraCierreDiario($connMysql)
{
    $FechaCompromiso = $_POST['FechaCompromiso'];
    $EstadoCalculadoFuturo = $_POST['EstadoCalculadoFuturo'];
    $ComentarioCierre = $_POST['ComentarioCierre'];

    // print_r($_SESSION['IDSForMail']);
    $FunctionsMySQL = new FunctionsMySQL();

    $idConverted = implode(", ", $_SESSION['IDSForMail']);
    $SQL = "SELECT  DISTINCT EjecutivoID FROM IMSeguimientoOperativo WHERE LlaveUnicaDO  in($idConverted)  ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $html = '';
    $arrayMails = array();
    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            array_push($arrayMails, $row['EjecutivoID']);
        }
        $DataCierre = InsertaCierreDiario($connMysql);
        foreach ($arrayMails as $EjecutivoID) {
            $DataMail = SelectMails($connMysql, $EjecutivoID);
            // $Remitentes = $DataMail['MailDirector'] . ',' . $DataMail['MailJefecuenta'] . ',' . $DataMail['MailEjecutivo'];
        }
        $Remitentes = 'bvillalobos@abcrepecev.com';
        $Adjunto = FileForMail($connMysql, $EjecutivoID, $DataCierre['arrayMails']);
        $EstadoCalculadoFuturo = DetectarNombreEstado($EstadoCalculadoFuturo);
        $arrayData = array(
            'Remitentes' => $Remitentes,
            'Asunto' => "Compromiso cierre diario para $FechaCompromiso ",
            'Mensaje' => "<p>Estado del compromiso: <b>$EstadoCalculadoFuturo</b></p>" . $ComentarioCierre,
            'Adjunto' => $Adjunto,
            'CreadorID' => $_SESSION['UserID'],
        );
        $FunctionsMySQL->Insert($arrayData, 'tabc_so_AlertasMail', $connMysql);

        if (strlen($DataCierre['html']) > 0) {
            $html = '</h4>Los siguientes DO no se comprometieron por que no cumplen con el estado:</h4>' . $DataCierre['html'];
        } else {
            $html = '</h4>Se enviaron a la ventana de compromisos del cierre diario, revise su bandeja de correo</h4>';
        }
        // ValidarColaCorreos($connMysql);
        return $html;
    }
}

function InsertaCierreDiario($connMysql)
{
    $EstadoCalculadoFuturo = $_POST['EstadoCalculadoFuturo'];
    $FechaCompromiso = $_POST['FechaCompromiso'];
    $FunctionsMySQL = new FunctionsMySQL();
    $idConverted = implode(", ", $_SESSION['IDSForMail']);
    $SQL = "SELECT *FROM IMSeguimientoOperativo WHERE LlaveUnicaDO  in($idConverted)  ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $html = '';
    $arrayMails = array();
    $arrayDoMal = array();
    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            if (ValidateEstados($connMysql, $row['EstadoCalculado']) <= ValidateEstados($connMysql, $EstadoCalculadoFuturo)) {
                if (ValidateCierreDiario($connMysql, $row['LlaveUnicaDO'], $row['EstadoCalculado'])) {
                    $arrayData = array(
                        'LlaveUnicaDO' => $row['LlaveUnicaDO'],
                        'JefeCuentaID' => $row['JefeCuentaID'],
                        'DirectorID' => $row['DirectorID'],
                        'EjecutivoID' => $row['EjecutivoID'],
                        'DocImpoNoDO' => $row['DocImpoNoDO'],
                        'EstadoCalculadoActual' => $row['EstadoCalculado'],
                        'EstadoCalculadoFuturo' => $EstadoCalculadoFuturo,
                        'FechaCompromiso' => $FechaCompromiso,
                        'ObservacionCompromiso' => $_POST['ComentarioCierre'],
                        'CreadoPor' => $_SESSION['UserID'],
                    );
                    $arrayMails[] = $row['LlaveUnicaDO'];
                    $FunctionsMySQL->Insert($arrayData, ' tabc_so_cierrediario', $connMysql);
                } else {
                    $arrayDoMal[] = $row['LlaveUnicaDO'];
                    $html .= '<li>Do ya en compromiso: ' . $row['DocImpoNoDO'] . '</li>';
                }
            } else {
                $arrayDoMal[] = $row['LlaveUnicaDO'];
                $html .= '<li>No puede ser un estado inferiror DO: ' . $row['DocImpoNoDO'] . '</li>';
            }
        }
    }
    $data['arrayMails'] = $arrayMails;
    $data['arrayDoMal'] = $arrayDoMal;
    $data['html'] = $html;
    return $data;
}

function ValidateEstados($connMysql, $EstadoCalculado)
{
    $SQL = "SELECT * FROM  tabc_so_estados where EstadoCalculado='$EstadoCalculado'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data = array();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['Orden'];
}

function ValidateCierreDiario($connMysql, $LlaveUnicaDO, $EstadoCalculado)
{
    $FechaCompromiso = $_POST['FechaCompromiso'];
    $EstadoCalculadoFuturo = $_POST['EstadoCalculadoFuturo'];
    $SQL = "SELECT * FROM  tabc_so_cierrediario where LlaveUnicaDO='$LlaveUnicaDO' AND FechaCompromiso='$FechaCompromiso'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['EstadoCalculadoFuturo'] == $EstadoCalculadoFuturo) {
        return false;
    }
    if ($row['EstadoCalculadoActual'] == $EstadoCalculado) {
        return false;
    }
    return true;

}
