<?php


function CargaLaboraUsuarios($connMysql)
{
    $FiltroActivo = FiltroActivo();

    if (array_key_exists('BtnJefeCuenta', $_SESSION)) {

        $Campo = 'EjecutivoID';
    } else if (array_key_exists('BtnCoordinador', $_SESSION)) {

        $Campo = 'EjecutivoID';
    } else if (array_key_exists('BtnDirector', $_SESSION)) {

        $Campo = 'JefeCuentaID';
    } else {
        switch ($_SESSION['RolID']) {
            case '1':
            case '9410':
                $Campo = 'DirectorID';
                break;
            case '2':
                $Campo = 'JefeCuentaID';
                break;
            case '3':
                $Campo = 'GrupoOperacion';
                break;
            default:
                $Campo = 'GrupoOperacion';
                break;

        }

    }
    if ($_POST['Tipo'] == 1) {
        $GrupoOperacion = "GrupoOperacion = 0";
    } else if ($_POST['Tipo'] == 2) {
        $GrupoOperacion = "GrupoOperacion = 1";
    } else if ($_POST['Tipo'] == 3) {
        $GrupoOperacion = "(GrupoOperacion = 1 OR GrupoOperacion = 0)";
    }

    $SQL = "SELECT $Campo, count(*) as total_operaciones FROM IMSeguimientoOperativo  WHERE $FiltroActivo AND  $GrupoOperacion   GROUP BY $Campo ORDER BY total_operaciones DESC  ";

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();

    $result = $stmt->fetchAll();
    if ($stmt->rowCount() > 0) {

        $salida = array();
        foreach ($result as $row) {

            if ($Campo == 'GrupoOperacion') {
                switch ($row['GrupoOperacion']) {
                    case 1:
                        $Nombre = 'Zona Franca';
                        break;
                    case 0:
                        $Nombre = 'Procesos Normales';
                        break;

                }
            } else {
                $DataArrayNombres = ReturnNombresSearch($Campo, $row[$Campo], $connMysql);
                $Nombre           = ArreglaNombresForPie($DataArrayNombres['NombreUser']);
            }

            $anidado = array();

            $anidado['value']    = $row["total_operaciones"];
            $anidado['name']     = mb_ucwords($Nombre);
            $anidado['seriesId'] = $row[$Campo];
            $anidado['Campo']    = $Campo;
            $data[]              = $anidado;
        }

        return json_encode($data);

    }

}

function CargaClientes($connMysql)
{
    $FiltroActivo = FiltroActivo();

    if ($_POST['ZonaFrancaCheckC'] == 1) {
        $GrupoOperacion = '(GrupoOperacion = 0 OR GrupoOperacion = 1)';
    } else {
        $GrupoOperacion = "GrupoOperacion = 0";
    }

    $SQL = "SELECT Cliente, count(*) as total_operaciones FROM IMSeguimientoOperativo  WHERE $FiltroActivo  AND $GrupoOperacion GROUP BY Cliente ORDER BY total_operaciones DESC  LIMIT 10  ";

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();

    $result = $stmt->fetchAll();
    if ($stmt->rowCount() > 0) {

        $salida = array();
        foreach ($result as $row) {
            $anidado          = array();
            $anidado['value'] = $row["total_operaciones"];
            $anidado['name']  = $row['Cliente'];
            $data[]           = $anidado;
        }

        echo json_encode($data);

    }

}
