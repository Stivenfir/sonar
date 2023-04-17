<?php
// $dataMail = array(
//     'EnviarA'       => '$AsignadoA',
//     'Efecto'        => '$Efecto',
//     'Observacion'   => '$Observacion',
//     'Vence'         => '$FechadeAgenda',
//     'NombreCliente' => '$FechadeAgenda',
//     'IdPublic'      => '$encriptar($idHistorico)',
//     'NombreCliente' => 'Dysat',
//     'FactVencidas'  => '25',
// );
//echo TemplateNotifyOK($dataMail);
function TemplateSendDO($dataMail)
{
  $email = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    width: 520px !important;
    }
    td[class="mobile-block"] {
    width: 100% !important;
    display: block !important;
    }
    }
    .BtnRepe:hover {
    background-color:#db6423;
    }
    .BtnRepe:active {
    position:relative;
    top:1px;
    }
    </style>
  </head>
  <body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
    <table cellpadding="0" cellspacing="0" class="force-full-width" height="100%" >
      <tr>
        <td  valign="top" bgcolor="#ffffff"  width="100%">
          <center>
          <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="600" class="w320">
            <tr>
              <td valign="top">
                <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" class="force-full-width" style="margin:0 auto;">
                  <tr>
                    <td style="font-size: 30px; text-align:center;">
                      <br>
                      <img src="cid:logoAbc" width="238" height="75" alt="Abc Logo">
                      <br>
                      <br>
                    </td>
                  </tr>
                </table>
                <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" class="force-full-width" bgcolor="#163D6C">
                  <tr>
                    <td class="headline">
                     <p> Alerta de Seguimiento Operativo:<p>
                    </td>
                  </tr>
                </table>
                      </center>
                      <div style=" background: white;"> 
                      ' . $dataMail['Mensaje'] . '
                      </div>
                    </td>
                  </tr>
                </td>
              </tr>
              <br>
            </table>
          </td>
        </tr>
      </table>
    </body>
  </html>';
  return $email;
}
