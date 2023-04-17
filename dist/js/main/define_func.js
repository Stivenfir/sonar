/* Script JavaScript Principal de amarilo Presupuestos
Autor: Bryan Villalobos
Fecha inicio desarrollo: 01/02/2021
Fecha Final Desarrollo:
Version:1.0
Notas del script: definiciones del escript, 
 */
function UrlManage(VariableGet, Dato) {
    var pathname = window.location.pathname;
    var $url = pathname + "?" + VariableGet + "=" + Dato;
    history.pushState(null, '', $url);
}
// $(".BotonMenu").click(function() {
//     var Redirigir = $(this).attr('id');
//     UrlManage(Redirigir, 'All');
//     EjecutarURL();
// });
// 
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function GetNameVarUrl() {
    var myMainSite = window.location.href;
    var splitUrl = myMainSite.split('?');
    if (splitUrl.length > 1) {
        var ValuesVar = splitUrl[1];
        var SplitVar = ValuesVar.split('=');
        if (SplitVar.length > 1) {
            return SplitVar[0];
        }
    }
    return 'NA';
}
var f2 = flatpickr($(".DatePicker"), {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    locale: {
        firstDayOfWeek: 1,
        weekdays: {
            shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        },
        months: {
            shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
            longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        },
    }
});


var f2 = flatpickr($(".DatePickerkPI"), {
    enableTime: false,
    dateFormat: "Y-m-d",
    locale: {
        firstDayOfWeek: 1,
        weekdays: {
            shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        },
        months: {
            shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
            longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        },
    }
});

var f2 = flatpickr($(".DatePickeCierre"), {
    enableTime: false,
    minDate: new Date().fp_incr(1),
    dateFormat: "Y-m-d",
    locale: {
        firstDayOfWeek: 1,
        weekdays: {
            shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        },
        months: {
            shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
            longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        },
    }
});

function Animaciones() {

    if ($('#timerid').length > 0) {
        var cleartimeid = $('#timerid').val();
    } else {
        var cleartimeid = 0;
    }
    clearTimeout(cleartimeid);
    let timerId = setInterval(function () {
        $(".task-FueraTiempo").toggleClass("animate__heartBeat");
        $(".task-FueraTiempoFact").toggleClass("animate__heartBeat");
        $("#border-profile-tab").toggleClass("animated pulse");
        $(".titila").toggleClass("animated pulse");
        $(".task-SinEstado").toggleClass("animated pulse");
    }, 800);
    $('body').remove('#timerid');
    $('body').append('<input type="hidden" id="timerid" value="' + timerId + '">');
}

function AlertsSwet(Titulo, Texto, Type) {
    swal({
        title: Titulo,
        html: Texto,
        type: Type,
        animation: false,
        customClass: 'animated tada',
        padding: '2em'
    })
}

function BlankFields() {
    $('#DocImpoNoDocTransp').val("");
    $('#DocImpoFechaETA').val("");
    $('#FechaManifiesto').val("");
    $('#FechaConsultaInventario').val("");
    $('#FechaDespacho').val("");
    $('#NumeroManifiesto').val("");
    $('#ParcialNumero').val("");
    $('#FechaEntregaDocumentosDespacho').val("");
    $('#FechaFormulario').val("");
    $('#FechaEntregaApoyoOperativo').val("");
    $('#FechaDevolucionFacturacion').val("");
    $('#FechaEntregaDoDevolucionFacturacion').val("");
    $('#DepositoZonaFranca').val("");
    $('#TerminalPortuario').val("");
    $('#ObsSeguimiento').val("");
    $('#ObsCliente').val("");
    $('#ObsBitacora').val("");
    $('#FechaReciboDocs').val("");
    $('#FechaSolicitudAnticipo').val("");
    $('#FechaReciboAnticipo').val("");
    $('#FechaReciboDocsPuerto').val("");
    $('#FechaReciboDocsPuerto').val("");
    $('#FechaEntregaDocumentosDespacho').val("");
}

function BlockAllFields() {
    $('.DocImpoNoDocTransp').hide();
    $('.NumeroManifiesto').hide();
    $('.DocImpoFechaETA').hide();
    $('.FechaManifiesto').hide();
    $('.FechaConsultaInventario').hide();
    $('.FechaDespacho').hide();
    $('.FechaFormulario').hide();
    $('.FechaEntregaApoyoOperativo').hide();
    $('.FechaDevolucionFacturacion').hide();
    $('.FechaEntregaDoDevolucionFacturacion').hide();
    $('#DepositoZonaFranca').attr('disabled', true);
    $('#TerminalPortuario').attr('disabled', true);
    $('.FechaReciboDocs').hide();
    $('.FechaSolicitudAnticipo').hide();
    $('.FechaReciboAnticipo').hide();
    $('.FechaReciboDocumentos').hide();
    $('.FechaReciboDocsPuerto').hide();
    $('.FechaEntregaDocumentosDespacho').hide();
}

function BlockFields(EstadoCalculado, Hidden) {
    BlockAllFields();
    switch (EstadoCalculado) {
        case 'Pendiente Arribo':
        case 'Pendiente Arribo - En digitación':
        case 'Pendiente Arribo - Aceptada':
        case 'Pendiente Arribo - Sin documento de Transpote':
        case 'DTA Sin Arribar':
            if (Hidden == 1) {
                $('.DocImpoNoDocTransp').show();
            }
            $('.DocImpoFechaETA').show();
            $('.FechaManifiesto').show();
            $('#DepositoZonaFranca').attr('disabled', false);
            $('#TerminalPortuario').attr('disabled', false);
            $('.FechaReciboDocs').show();
            $('.FechaReciboDocumentos').show();
            // $('.FechaSolicitudAnticipo').show();
            // $('.FechaReciboAnticipo').show();
            break;
        case 'DTA con ETA vencido sin despacho':
            $('.DocImpoFechaETA').show();
            $('.FechaManifiesto').show();
            $('.FechaConsultaInventario').show();
            if (Hidden == 1) {
                $('.NumeroManifiesto').show();
            }
            $('.FechaFormulario').show();
            $('#DepositoZonaFranca').attr('disabled', false);
            $('#TerminalPortuario').attr('disabled', false);
            $('.FechaReciboDocs').show();
            $('.FechaReciboDocumentos').show();
            // $('.FechaSolicitudAnticipo').show();
            // $('.FechaReciboAnticipo').show();
            break;
        case 'Pendiente Actualizar Manifiesto':
        case 'Anticipada con ETA Vencido':
        case 'Arribo Hoy Sin Pasar a Digitar':
        case 'Arribo Hoy en Digitacion':
        case 'En Elaboracion DIM':
            $('.FechaManifiesto').show();
            if (Hidden == 1) {
                $('.NumeroManifiesto').show();
            }
            $('.FechaFormulario').show();
            $('#DepositoZonaFranca').attr('disabled', false);
            $('#TerminalPortuario').attr('disabled', false);
            $('.FechaReciboDocs').show();
            $('.FechaReciboDocumentos').show();
            // $('.FechaSolicitudAnticipo').show();
            // $('.FechaReciboAnticipo').show();
            break;
        case 'DIM Visada sin Aceptar':
            $('.FechaManifiesto').show();
            $('.FechaConsultaInventario').show();
            $('.FechaReciboDocs').show();
            $('.FechaReciboDocumentos').show();
            // $('.NumeroManifiesto').show();
            // $('.FechaFormulario').show();
            // $('#DepositoZonaFranca').attr('disabled', false);
            // $('#TerminalPortuario').attr('disabled', false);
            break;
        case 'Con Manifiesto Sin Ingreso Deposito':
        case 'En Deposito Sin Pasar a Digitar':
            $('.DocImpoNoDocTransp').show();
            $('.FechaManifiesto').show();
            $('.FechaConsultaInventario').show();
            if (Hidden == 1) {
                $('.NumeroManifiesto').show();
            }
            $('.FechaFormulario').show();
            $('.FechaReciboDocs').show();
            $('.FechaReciboDocumentos').show();
            $('#DepositoZonaFranca').attr('disabled', false);
            $('#TerminalPortuario').attr('disabled', false);
            // $('.FechaSolicitudAnticipo').show();
            // $('.FechaReciboAnticipo').show();
            break;
        case 'En Aceptacion y Pagos Sin Levante':
            $('.FechaReciboDocs').show();
            $('.FechaReciboDocumentos').show();
            // $('.FechaSolicitudAnticipo').show();
            // $('.FechaReciboAnticipo').show();
            break;
        case 'Con Levante Sin Despacho':
            $('.FechaDespacho').show();
            $('.FechaEntregaDocumentosDespacho').show();
            $('.FechaReciboDocsPuerto').show();
            break;
        case 'DTA Despachado sin pasar a Facturar':
            $('.FechaDespacho').show();
            $('.FechaEntregaDocumentosDespacho').show();
            break;
        case 'Con Despacho sin Envio Facturacion':
            $('.FechaDevolucionFacturacion').show();
            $('.FechaEntregaDoDevolucionFacturacion').show();
            $('.FechaEntregaApoyoOperativo').show();
            $('.FechaReciboDocsPuerto').show();
            break;
        case 'DTA Sin generar factura':
        case 'Enviada Facturacion Sin Facturar':
        case 'Gasto Posterior sin Enviar Facturacion':
        case 'Devuelta por Contabilidad':
        case 'Devolución a Facturación':
        case 'Entrega Urgente Total':
        case 'Finalización Urgente Total':
            $('.FechaDevolucionFacturacion').show();
            $('.FechaEntregaDoDevolucionFacturacion').show();
            break;
        case 'Eta1900':
        case 'En Espera Instrucción Cliente':
            $('.FechaManifiesto').show();
            $('.DocImpoFechaETA').show();
            $('.FechaReciboDocs').show();
            $('.FechaReciboDocumentos').show();
            break;
        case 'Revisar Info Para Determinar Estado':
            setTimeout(function () {
                const toast = swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });
                toast({
                    type: 'error',
                    title: 'No puede actualizar fechas y algunos datos en este estado DO',
                    padding: '2em',
                })
            }, 5000);
            break;
    }
}

function SelectorMasivo() {
    var isMouseDown = false,
        isHighlighted;
    $(".items").click(function () {
        isMouseDown = true;
        var Selected = $(this).attr('id')
        $(this).toggleClass("highlighted");
        isHighlighted = $(this).hasClass("highlighted");
        $("." + Selected).toggleClass("text-white");
        $("." + Selected).hasClass("text-white");
        return false; // prevent text selection
    }).bind("selectstart", function () {
        return false;
    })
    $(document).mouseup(function () {
        isMouseDown = false;
    });
}

function SelectoresDepTerminal(DepositoSelected, TerminalSelected) {
    var DatosPeticion = {
        'PostMethod': 'SelectoresDepTerminal',
        'DepositoSelected': DepositoSelected,
        'TerminalSelected': TerminalSelected
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectoresDepTerminal",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        dataType: 'json',
        success: function (data) {
            $("#DepositoZonaFranca").html(data.Depositos);
            $("#TerminalPortuario").html(data.Terminales);
            $("#TerminalPortuario").selectpicker('refresh');
            $("#DepositoZonaFranca").selectpicker('refresh');
        }
    });
}
$('#BtnModificarFecha').on("click", function () {
    if ($('#DivPickerFecha').is(':visible')) {
        $('#DivPickerFecha').hide('slow');
    } else {
        $('#DivPickerFecha').show('slow');
    }
});
var f3 = flatpickr($('.RangosKpi'), {
    mode: "range",
    locale: {
        firstDayOfWeek: 1,
        weekdays: {
            shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        },
        months: {
            shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
            longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        },
    },
    onChange: function (selectedDates, dateStr, instance) { },
});




function SelectorMasivokpi() {
    var isMouseDown = false,
        isHighlighted;
    $(".items").click(function () {
        isMouseDown = true;
        var Selected = $(this).data('id')
        $(this).toggleClass("highlighted");
        isHighlighted = $(this).hasClass("highlighted");
        $("." + Selected).toggleClass("text-white");
        $("." + Selected).hasClass("text-white");
        return false; // prevent text selection
    }).bind("selectstart", function () {
        return false;
    })
    $(document).mouseup(function () {
        isMouseDown = false;
    });
}
$('#BtnSelectAll').on("click", function () {
    $(".items").toggleClass("highlighted");
    $(".item").toggleClass("text-white");
    $(".item").hasClass("text-white");
});
$(".SelectorKpis").select2({
    dropdownParent: $("#ModalKpis"),
});

function AlertToast(Type, Message) {
    const toast = swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        padding: '2em'
    });
    toast({
        type: Type,
        title: Message,
        padding: '2em',
    })
}