<?php
function TemplateNotifyOK($datosNotificacion)
{
    $DatosRow             = explode('||', $datosNotificacion);
    $CantidadCargados     = $DatosRow[1];
    $cantidadYaexistentes = $DatosRow[2];
    $CantidadFilas        = $DatosRow[3];
    $hoja_cargar          = $DatosRow[4];
    $ruta_archivo         = $DatosRow[5];
    $DescripcionMercancia = $DatosRow[6];
    $cantidadYaCreados    = $DatosRow[8];
    $CantidadUnicos       = $DatosRow[9];
    $nombreCliente        = $DatosRow[10];
    $info                 = new SplFileInfo($ruta_archivo);
    $NombreArchivo        = $info->getFilename();
    $email                = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Notificación de Cargues</title>
    <style type="text/css">
    @import url(http://fonts.googleapis.com/css?family=Droid+Sans);
    /* Take care of image borders and formatting */
    img {
    max-width: 600px;
    outline: none;
    text-decoration: none;
    -ms-interpolation-mode: bicubic;
    }
    a {
    text-decoration: none;
    border: 0;
    outline: none;
    color: #bbbbbb;
    }
    a img {
    border: none;
    }
    /* General styling */
    td, h1, h2, h3  {
    font-family: Helvetica, Arial, sans-serif;
    font-weight: 400;
    }
    td {
    text-align: center;
    }
    body {
    -webkit-font-smoothing:antialiased;
    -webkit-text-size-adjust:none;
    width: 100%;
    height: 100%;
    color: #37302d;
    background: #ffffff;
    font-size: 16px;
    }
    table {
    border-collapse: collapse !important;
    }
    .headline {
    color: #ffffff;
    font-size: 20px;
    }
    .force-full-width {
    width: 100% !important;
    }
    .force-width-80 {
    width: 80% !important;
    }
    </style>
    <style type="text/css" media="screen">
    @media screen {
    /*Thanks Outlook 2013! http://goo.gl/XLxpyl*/
    td, h1, h2, h3 {
    font-family: "Droid Sans", "Helvetica Neue", "Arial", "sans-serif" !important;
    }
    }
    </style>
    <style type="text/css" media="only screen and (max-width: 480px)">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {
    table[class="w320"] {
    width: 320px !important;
    }
    td[class="mobile-block"] {
    width: 100% !important;
    display: block !important;
    }
    }
    </style>
  </head>
  <body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
    <table align="center" cellpadding="0" cellspacing="0" class="force-full-width" height="100%" >
      <tr>
        <td align="center" valign="top" bgcolor="#ffffff"  width="100%">
          <center>
          <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="600" class="w320">
            <tr>
              <td align="center" valign="top">
                <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" class="force-full-width" style="margin:0 auto;">
                  <tr>
                    <td style="font-size: 30px; text-align:center;">
                      <br>
                      <img src="cid:logoAbc" width="130" height="85" alt="Abc Logo">
                      <br>
                      <br>
                    </td>
                  </tr>
                </table>
                <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" class="force-full-width" bgcolor="#163D6C">
                  <tr>
                    <td class="headline">
                      <p>&nbsp;</p>
                      Proceso Automático para Apertura de D.O
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <br>
                      <img src="cid:RobotAbc" width="130" height="138" alt="Imagen Robot">
                    </td>
                  </tr>
                  <tr>
                    <td class="headline">
                      Se ha procesado un archivo. Por favor revisar Tracking.
                      <p>&nbsp;</p>
                    </td>
                  </tr>
                </table>
                <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" class="force-full-width" bgcolor="#DB6323">
                  <tr>
                    <td style="background-color:#DB6323;">
                      <table  style="margin: 0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                        <tr>
                          <td style="color:#ffffff; text-align:left;">
                            <br>
                            Cliente:
                            <strong><p>' . $nombreCliente . ' </p> </strong>
                            Archivo Procesado:
                            <strong><p>' . $NombreArchivo . ' </p> </strong>

                            Hoja procesada: <strong>' . $hoja_cargar . '.</strong>
                            <br>
                          </td>
                        </tr>
                      </table>
                      <table style="margin:0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                        <tr>
                          <td class="mobile-block">
                            <br>
                            <br>
                            <table cellspacing="0" cellpadding="0" class="force-full-width">
                              <tr>
                                <td style="color:#ffffff; background-color:#ac4d2f; padding: 10px 0px;">
                                  Filas Procesadas
                                </td>
                              </tr>
                              <tr>
                                <td style="color:#933f24; padding:10px 0px; background-color: #f7a084;">
                                  ' . $CantidadFilas . '
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td  class="mobile-block" >
                            <br>
                            <br>
                            <table cellspacing="0" cellpadding="0" class="force-full-width">
                              <tr>
                                <td style="color:#ffffff; background-color:#ac4d2f; padding: 10px 0px;">
                                  Doc Transp. Unicos
                                </td>
                              </tr>
                              <tr>
                                <td style="color:#933f24; padding:10px 0px; background-color: #f7a084;">
                                  ' . $CantidadUnicos . '
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td  class="mobile-block">
                            <br>
                            <br>
                            <table cellspacing="0" cellpadding="0" class="force-full-width">
                              <tr>
                                <td style="color:#ffffff; background-color:#ac4d2f; padding: 10px 0px;">
                                  Datos ya existentes
                                </td>
                              </tr>
                              <tr>
                                <td style="color:#933f24; padding:10px 0px; background-color: #f7a084;">
                                  ' . $cantidadYaCreados . '
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td  class="mobile-block">
                            <br>
                            <br>
                            <table cellspacing="0" cellpadding="0" class="force-full-width">
                              <tr>
                                <td style="color:#ffffff; background-color:#ac4d2f; padding: 10px 0px;">
                                  DO Creados para confirmar
                                </td>
                              </tr>
                              <tr>
                                <td style="color:#933f24; padding:10px 0px; background-color: #f7a084;">
                                  ' . $CantidadCargados . '
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <table style="margin: 0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                        <tr>
                          <td style="text-align:left; color:#ffffff;">
                            <br>
                            <p> <strong>Descripcion Mercancia:</strong></p>
                            <p>' . $DescripcionMercancia . '.</p>
                            <br>
                            <br>
                          </td>
                        </tr>
                      </table>
                      </center>
                    </td>
                  </tr>
                </td>
              </tr>
              <br>
            </table>
            </center>
          </td>
        </tr>
      </table>
    </body>
  </html>';
    return $email;
}
function TemplateNotifyFail($datosNotificacion)
{
    $DatosRow      = explode('||', $datosNotificacion);
    $hoja_cargar   = $DatosRow[4];
    $ruta_archivo  = $DatosRow[5];
    $info          = new SplFileInfo($ruta_archivo);
    $NombreArchivo = $info->getFilename();
    $email         = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title>Notificación de Cargues</title>
      <style type="text/css">
      @import url(http://fonts.googleapis.com/css?family=Droid+Sans);
      /* Take care of image borders and formatting */
      img {
      max-width: 600px;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
      }
      a {
      text-decoration: none;
      border: 0;
      outline: none;
      color: #bbbbbb;
      }
      a img {
      border: none;
      }
      /* General styling */
      td, h1, h2, h3  {
      font-family: Helvetica, Arial, sans-serif;
      font-weight: 400;
      }
      td {
      text-align: center;
      }
      body {
      -webkit-font-smoothing:antialiased;
      -webkit-text-size-adjust:none;
      width: 100%;
      height: 100%;
      color: #37302d;
      background: #ffffff;
      font-size: 16px;
      }
      table {
      border-collapse: collapse !important;
      }
      .headline {
      color: #ffffff;
      font-size: 20px;
      }
      .force-full-width {
      width: 100% !important;
      }
      .force-width-80 {
      width: 80% !important;
      }
      </style>
      <style type="text/css" media="screen">
      @media screen {
      /*Thanks Outlook 2013! http://goo.gl/XLxpyl*/
      td, h1, h2, h3 {
      font-family: "Droid Sans", "Helvetica Neue", "Arial", "sans-serif" !important;
      }
      }
      </style>
      <style type="text/css" media="only screen and (max-width: 480px)">
      /* Mobile styles */
      @media only screen and (max-width: 480px) {
      table[class="w320"] {
      width: 320px !important;
      }
      td[class="mobile-block"] {
      width: 100% !important;
      display: block !important;
      }
      }
      </style>
    </head>
    <body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
      <table align="center" cellpadding="0" cellspacing="0" class="force-full-width" height="100%" >
        <tr>
          <td align="center" valign="top" bgcolor="#ffffff"  width="100%">
            <center>
            <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="600" class="w320">
              <tr>
                <td align="center" valign="top">
                  <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" class="force-full-width" style="margin:0 auto;">
                    <tr>
                      <td style="font-size: 30px; text-align:center;">
                        <br>
                        <img src="cid:logoAbc" width="130" height="85" alt="Abc Logo">
                        <br>
                        <br>
                      </td>
                    </tr>
                  </table>
                  <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" class="force-full-width" bgcolor="#163D6C">
                    <tr>
                      <td class="headline">
                        <p>&nbsp;</p>
                        Proceso Automático para Apertura de D.O
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <br>
                        <img src="cid:RobotAbc" width="130" height="138" alt="Imagen Robot">
                      </td>
                    </tr>
                    <tr>
                      <td class="headline">
                        Se ha procesado un archivo. Pero el contenido no se puede leer revise la matriz de Archivo el listado de remitentes permitidos o el archivo adjunto.
                        <p>&nbsp;</p>
                      </td>
                    </tr>
                  </table>
                  <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" class="force-full-width" bgcolor="#DB6323">
                    <tr>
                      <td style="background-color:#DB6323;">
                        <table  style="margin: 0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                          <tr>
                            <td style="color:#ffffff; text-align:left;">
                              <br>
                              Cliente:
                            <strong><p>' . $nombreCliente . ' </p> </strong>
                              Error Encontrado:
                              <strong><p>' . $NombreArchivo . ' </p> </strong>
                              Hoja procesada: <strong>' . $hoja_cargar . '.</strong>
                              <br>
                            </td>
                          </tr>
                        </table>
                        <table style="margin:0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                          <tr>
                            <td  class="mobile-block" >
                              <br>
                              <br>
                            </td>
                          </tr>
                        </table>
                        <table style="margin: 0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                          <tr>
                            <td style="text-align:left; color:#ffffff;">
                              <br>
                              <br>
                            </td>
                          </tr>
                        </table>
                        </center>
                      </td>
                    </tr>
                  </td>
                </tr>
                <br>
              </table>
              </center>
            </td>
          </tr>
        </table>
      </body>
    </html>';
    return $email;
}
