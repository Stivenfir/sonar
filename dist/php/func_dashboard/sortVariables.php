<?php

$SortClass01 = 'ASC';
$title01     = "Ordenar Ascendente";
$Icono01     = '<span class="ti-angle-double-up"></span>';
$SortClass02 = 'ASC';
$title02     = "Ordenar Ascendente";
$Icono02     = '<span class="ti-angle-double-up"></span>';
$SortClass03 = 'ASC';
$title03     = "Ordenar Ascendente";
$Icono03     = '<span class="ti-angle-double-up"></span>';
$SortClass04 = 'ASC';
$title04     = "Ordenar Ascendente";
$Icono04     = '<span class="ti-angle-double-up"></span>';
$SortClass05 = 'ASC';
$title05     = "Ordenar Ascendente";
$Icono05     = '<span class="ti-angle-double-up"></span>';
$SortClass06 = 'ASC';
$title06     = "Ordenar Ascendente";
$Icono06     = '<span class="ti-angle-double-up"></span>';
$SortClass07 = 'ASC';
$title07     = "Ordenar Ascendente";
$Icono07     = '<span class="ti-angle-double-up"></span>';
$SortClass08 = 'ASC';
$title08     = "Ordenar Ascendente";
$Icono08     = '<span class="ti-angle-double-up"></span>';
$SortClass09 = 'ASC';
$title09     = "Ordenar Ascendente";
$Icono09     = '<span class="ti-angle-double-up"></span>';
$SortClass10 = 'ASC';
$title10     = "Ordenar Ascendente";
$Icono10     = '<span class="ti-angle-double-up"></span>';
$SortClass11 = 'ASC';
$title11     = "Ordenar Ascendente";
$Icono11     = '<span class="ti-angle-double-up"></span>';
switch ($CampoSort) {
    case 'DocImpoFechaETA':
        if ($TipoSort == 'ASC') {
            $SortClass01 = 'DESC';
            $title01     = "Ordenar Descendente";
            $Icono01     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass01 = 'ASC';
            $title01     = "Ordenar Ascendente";
            $Icono01     = '<span class="ti-angle-double-up"></span>';
        }

        break;
    case 'DocImpoFechaCrea':
        if ($TipoSort == 'ASC') {
            $SortClass02 = 'DESC';
            $title02     = "Ordenar Descendente";
            $Icono02     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass02 = 'ASC';
            $title02     = "Ordenar Ascendente";
            $Icono02     = '<span class="ti-angle-double-up"></span>';
        }

    case 'FechaNacionalizacion':
        if ($TipoSort == 'ASC') {
            $SortClass03 = 'DESC';
            $title03     = "Ordenar Descendente";
            $Icono03     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass03 = 'ASC';
            $title03     = "Ordenar Ascendente";
            $Icono03     = '<span class="ti-angle-double-up"></span>';
        }

        break;
    case 'DeclImpoFechaAcept':
        if ($TipoSort == 'ASC') {
            $SortClass04 = 'DESC';
            $title04     = "Ordenar Descendente";
            $Icono04     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass04 = 'ASC';
            $title04     = "Ordenar Ascendente";
            $Icono04     = '<span class="ti-angle-double-up"></span>';
        }

        break;
    case 'FechaReciboDocs':
        if ($TipoSort == 'ASC') {
            $SortClass05 = 'DESC';
            $title05     = "Ordenar Descendente";
            $Icono05     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass05 = 'ASC';
            $title05     = "Ordenar Ascendente";
            $Icono05     = '<span class="ti-angle-double-up"></span>';
        }
        break;
    case 'FechaManifiesto':
        if ($TipoSort == 'ASC') {
            $SortClass06 = 'DESC';
            $title06     = "Ordenar Descendente";
            $Icono06     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass06 = 'ASC';
            $title06     = "Ordenar Ascendente";
            $Icono06     = '<span class="ti-angle-double-up"></span>';
        }

        break;
    case 'FechaIngresoDeposito':
        if ($TipoSort == 'ASC') {
            $SortClass07 = 'DESC';
            $title07     = "Ordenar Descendente";
            $Icono07     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass07 = 'ASC';
            $title07     = "Ordenar Ascendente";
            $Icono07     = '<span class="ti-angle-double-up"></span>';
        }

        break;
    case 'DeclImpoFechaLevante':
        if ($TipoSort == 'ASC') {
            $SortClass08 = 'DESC';
            $title08     = "Ordenar Descendente";
            $Icono08     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass08 = 'ASC';
            $title08     = "Ordenar Ascendente";
            $Icono08     = '<span class="ti-angle-double-up"></span>';
        }
    case 'DeclImpoFechaLevante':
        if ($TipoSort == 'ASC') {
            $SortClass09 = 'DESC';
            $title09     = "Ordenar Descendente";
            $Icono09     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass09 = 'ASC';
            $title09     = "Ordenar Ascendente";
            $Icono09     = '<span class="ti-angle-double-up"></span>';
        }
        break;
    case 'FechaEntrDoFact':
        if ($TipoSort == 'ASC') {
            $SortClass10 = 'DESC';
            $title10     = "Ordenar Descendente";
            $Icono10     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass10 = 'ASC';
            $title10     = "Ordenar Ascendente";
            $Icono10     = '<span class="ti-angle-double-up"></span>';
        }
        break;
    case 'FechaDevolucionFacturacion':
        if ($TipoSort == 'ASC') {
            $SortClass11 = 'DESC';
            $title11     = "Ordenar Descendente";
            $Icono11     = '<span class="ti-angle-double-down"></span>';

        } else {
            $SortClass11 = 'ASC';
            $title11     = "Ordenar Ascendente";
            $Icono11     = '<span class="ti-angle-double-up"></span>';
        }
        break;

    default:
        # code...
        break;
}
