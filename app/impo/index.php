<?php
require_once '../login/session.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>
        SONAR - ABC-REPECEV
        </title>
        <?php require_once '../includes/headers.php'?>
    </head>
    <body class="alt-menu sidebar-noneoverflow">
        <!-- BEGIN LOADER -->
        <div id="load_screen">
            <div class="loaderPrincipal">
                <div class="loader-content">
                    <div class="spinner-grow align-self-center">
                    </div>
                </div>
            </div>
        </div>
        <!--  END LOADER -->
        <!--  BEGIN NAVBAR  -->
        <?php require_once '../includes/navbar.php'?>
        <!--  END NAVBAR  -->
        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container sidebar-closed sbar-open" id="container">
            <div class="overlay">
            </div>
            <div class="cs-overlay">
            </div>
            <div class="search-overlay">
            </div>
            <!--  BEGIN SIDEBAR  -->
            <?php require_once '../includes/menu.php'?>
            <!--  END SIDEBAR  -->
            <!--  BEGIN CONTENT AREA  -->
            <div class="main-content" id="content">
                <!-- MODALES -->
                <?php require_once 'modales-kpi.php'?>
                <?php require_once 'modales-gen.php'?>

                <!-- MODALES -->
            </div>
            <!-- SPA APLICATION HTML -->
            <?php require_once 'dash-html.php'?>
            <?php require_once 'kpis-html.php'?>
           <!-- SPA APLICATION HTML -->
        </div>
        <!--  END CONTENT AREA  -->
        <?php require_once '../includes/footers.php'?>
    </body>
</html>