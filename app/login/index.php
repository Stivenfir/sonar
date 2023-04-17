<?php
session_start();
if (!isset($_SESSION['UsuarioLogueado'])) {
} else {
    header("location: ../impo");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Login SONAR ABC Repecev </title>
    <link href="../../dist/assets/img/ABC_soluciones_logisticas_a_su_servicio_globo-0454.png?fit=32%2C32&ssl=1" rel="icon" sizes="32x32" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../../dist/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../dist/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../../dist/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="../../dist/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="../../dist/assets/css/forms/switches.css">
    <link href="../../dist/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="../../dist/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <meta name="google" content="notranslate" />
</head>

<body class="form">
    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <img width="300" alt="Abc Repecev" src="../../dist/assets/img/logo.png">
                        <h3 title="Seguimiento operativo nacional Abc Repecev" class="">SONAR V2.0</h3>
                        <h3 title="Seguimiento operativo nacional Abc Repecev" class="">ABC-REPECEV</h3>
                        <p class="">Ingrese con las credenciales de RpcTracking</p>
                       
                        <form class="text-left">
                            <div class="form">
                                <div id="username-field" class="field-wrapper input">
                                    <p for="username">USUARIO</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="username" type="text" class="form-control" placeholder="Usuario Tracking" autocomplete="off">
                                </div>
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <p for="password">CONTRASEÑA</p>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" autocomplete="new-password" type="password" class="form-control" placeholder="Password Tracking">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button id="LoginBTN" class="btn btn-lg mb-3 mr-3 btn-primary"><span id="TitleButton">INGRESAR</span>
                                            <div style="display: none" class="spinner-grow text-white mr-2 align-self-center loader-sm"></div>
                                        </button>
                                        <!-- <p class="text-danger">le recomendamos eliminar la cache del navegador para mejorar la experiencia puede hacerlo en el siguiente enlace <a href="https://support.google.com/accounts/answer/32050?hl=es-419&co=GENIE.Platform%3DDesktop">Aqui</a></p> -->
                                    </div>
                                </div>
                                <!-- <small> <a class="text-primary font-weight-bold" href="../../../abc-so-v1"> Ir a la Versión anterior diponible hasta 01-12-2021 </a> </small> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../../dist/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../../dist/bootstrap/js/popper.min.js"></script>
    <script src="../../dist/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../dist/plugins/sweetalerts/sweetalert2.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="../../dist/js/func_login/func_login.js?NoCache=<?php time(); ?>"></script>
</body>

</html>
