/* Script JavaScript Principal de Abc Sonar
Autor: Bryan Villalobos
Fecha inicio desarrollo: 01/02/2021
Fecha Final Desarrollo:
Version:1.0
Notas del script:Script Frontend que controla la interfaz y el Backend, 
 */
//Validamos que el documento se cargue  completamente.
$(document).ready(function () {
    EjecutarURL();
    SelectoresDepTerminal(null, null);

    function EjecutarURL() {
        var Parametro = GetNameVarUrl();
        var ValueParametro = getParameterByName(Parametro);
        switch (Parametro) {
            case 'NA':
            case 'Filtro':
                AllScriptTrigger();
                break;
            case 'Analitics':
                AllScriptTrigger();
                OpenModalAnalitics();
                break;
            case 'KpisConf':
                VisibleDiv("KpisConfig");
                TableKpis();
                break;
            case 'KpisAdd':
                VisibleDiv("KpisConfig");
                OpenModalKpis();
                TableKpis();
                break;
            case 'KpisEdit':
                VisibleDiv("KpisConfig");
                $("#TypePost").val('EditarKpi');
                $("#idKPI").val(ValueParametro);
                alert(ValueParametro);
                OpenModalKpis();
                TableKpis();
                break;
            default:
                swal({
                    title: "Error 404",
                    text: "Esta ubicación esta en construcción lo hemos redireccionado al inicio ",
                    type: 'info'
                });
                UrlManage('Filtro', 'aplicar');
                EjecutarURL();
                break;
        }
    }

    function AllScriptTrigger() {
        VisibleDiv("DashPrincipal");
        ValidarUserLog();
        MenuFiltroActivo();
    }
    if (window.history) {
        $(window).on('popstate', function () {
            EjecutarURL();
        });
    }
    $('.BtnMenu').on("click", function () {
        BtnClik = $(this).attr('id');
        switch (BtnClik) {
            case 'BtnInicio':
                VisibleDiv("DashPrincipal");
                UrlManage('Filtro', 'aplicar');
                if ($('#DivFiltro').is(':hidden')) {
                    EjecutarURL();
                }
                break;
            case 'BtnConfKpi':
                UrlManage('KpisConf', 'all');
                EjecutarURL();
                break;
        }
    });

    function VisibleDiv(id_selector) {
        InvisibleAll();
        $("#" + id_selector).removeClass('Hidden');
    }

    function InvisibleAll() {
        $("#DashPrincipal").addClass('Hidden');
        $("#KpisConfig").addClass('Hidden');
    }
    ShowMessagesAdmin();
    function ShowMessagesAdmin() {


        var DatosPeticion = {
            'PostMethod': 'ShowMessagesAdmin',
        };
        $.ajax({
            url: "../../dist/php/controller.php?ShowMessagesAdmin",
            method: "POST",
            data: DatosPeticion,
            cache: false,
            success: function (data) {
                if (data != 'NoAlert') {
                    swal({
                        title: 'Información del administrador',
                        html: data,
                        type: 'info',
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar',
                        animation: false,
                        customClass: 'animated pulse',
                        padding: '2em'
                    })
                }
            }
        });
    }



});


