$('#BtnSelectAllDo').on("click", function () {
    var DatosPeticion = {
        'PostMethod': 'SelectAllDo',
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectAllDo",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            if (data == '0') {
                $('#ListaDOTable tr').removeClass('highlighted');
                $('#ListaDOTable td').removeClass('text-white');
                $("#BtnEnviar").html("");
            } else {
                $('#ListaDOTable tr').addClass('highlighted ');
                $('#ListaDOTable td').addClass('text-white');
                $("#BtnEnviar").html(data);
                HabilitarBotonCorreo();
            }
        }
    });
});

function HabilitarSelectDOMail() {
    $('.BtnSelectDO').on("click", function () {
        var IDForMail = $(this).data('id');
        var DatosPeticion = {
            'PostMethod': 'SelectDoMail',
            'IDForMail': IDForMail
        };
        $.ajax({
            url: "../../dist/php/controller.php?SelectDoMail",
            method: "POST",
            data: DatosPeticion,
            cache: false,
            success: function (data) {
                $("#BtnEnviar").html(data);

            }
        });
    });
}

$('.modal').on('click', '#BtnCrearCorreo', function (event) {
    var DatosPeticion = {
        'PostMethod': 'GetLastMessage',
    };
    $.ajax({
        url: "../../dist/php/controller.php?GetLastMessage",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $("#ModalCrearCorreo").modal({
                backdrop: 'static',
                keyboard: false
            });
            setTimeout(function () {

                CKEDITOR.instances['Mensaje'].insertHtml(data);
            }, 1000);
        }
    });
});





$('.modal').on('click', '#ClearTextArea', function (event) {
    CKEDITOR.instances['Mensaje'].setData('');
});



$('#BtnSendNotifysDO').on("click", function () {
    var Asunto = $("#Asunto").val();

    var Mensaje = CKEDITOR.instances['Mensaje'].getData();

    var DirectoresCheck = 0;
    var JefesCheck = 0;
    var CoordinadoresCheck = 0;
    if ($('#DirectoresCheck').is(":checked")) {
        var DirectoresCheck = 1
    }
    if ($('#JefesCheck').is(":checked")) {
        var JefesCheck = 1
    }
    if ($('#CoordinadoresCheck').is(":checked")) {
        var CoordinadoresCheck = 1
    }
    if (Asunto == "") {
        AlertsSwet('Error', 'El Asunto no puede estar Vacio!', 'error');
    } else if (!Mensaje) {
        AlertsSwet('Error', 'El mensaje no puede estar Vacio!', 'error');
    } else if (DirectoresCheck == 0 && JefesCheck == 0 && CoordinadoresCheck == 0) {
        AlertsSwet('Error', 'Seleccione al menos un usuario a notificar', 'error');
    } else {
        swal({
            title: 'Esta seguro de Notificar?',
            text: "Si Acepta se enviaran las notificaciones a los usuarios correspondientes.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            padding: '2em'
        }).then(function (result) {
            if (result.value) {
                swal.close();
                var DatosPeticion = {
                    'PostMethod': 'SendNotifysDO',
                    'Asunto': Asunto,
                    'Mensaje': Mensaje,
                    'DirectoresCheck': DirectoresCheck,
                    'JefesCheck': JefesCheck,
                    'CoordinadoresCheck': CoordinadoresCheck,
                };
                $.ajax({
                    url: "../../dist/php/controller.php?SendNotifysDO",
                    method: "POST",
                    data: DatosPeticion,
                    cache: false,
                    beforeSend: function () {
                        $('#BtnSendNotifysDO').attr('disabled', true);
                        $('#BtnSendNotifysDO').html(' <h4 class="text-white"><div class="spinner-border text-white align-self-center loader-sm "></div>Enviando Alertas</h4>');
                    },
                    success: function (data) {
                        $('#BtnSendNotifysDO').attr('disabled', false);
                        $('#BtnSendNotifysDO').html('Enviar Alertas');
                        var Asunto = $("#Asunto").val("");
                        var Mensaje = $("#Mensaje").val("");

                        swal({
                            title: 'Correcto',
                            text: "Se enviarón las alertas a los correos correspondientes ",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Si',
                            padding: '2em'
                        });
                        CKEDITOR.instances['Mensaje'].setData('');
                        $("#ModalCrearCorreo").modal('hide');
                    }
                });
            }
        })
    }
})


$('.modal').on('click', '#BtnCrearCierre', function (event) {
    $("#ModalCrearCierre").modal({
        backdrop: 'static'
    });
    SelectEstados();
});




$('#BtnGeneraCierreDiario').on("click", function () {

    var FechaCompromiso = $("#FechaCompromiso").val();
    var EstadoCalculadoFuturo = $("#EstadoCalculadoFuturo").val();
    var ComentarioCierre = $("#ComentarioCierre").val();
    if (FechaCompromiso == "") {
        AlertsSwet('Atención', 'Seleccione una fecha de compromiso', 'info');
    } else if (EstadoCalculadoFuturo == "") {
        AlertsSwet('Atención', 'Seleccione un estado del compromiso', 'info');
    } else if (ComentarioCierre == "") {
        AlertsSwet('Atención', 'Ingrese una observación de compromiso', 'info');
    } else {
        swal({
            title: 'Esta seguro de generar cierre diario de operaciones?',
            text: "Si Acepta se enviaran las notificaciones y se asignaran los compromisos para la fecha seleccionada.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            padding: '2em'
        }).then(function (result) {
            if (result.value) {
                swal.close();
                var DatosPeticion = {
                    'PostMethod': 'GeneraCierreDiario',
                    'FechaCompromiso': FechaCompromiso,
                    'EstadoCalculadoFuturo': EstadoCalculadoFuturo,
                    'ComentarioCierre': ComentarioCierre,
                };
                $.ajax({
                    url: "../../dist/php/controller.php?GeneraCierreDiario",
                    method: "POST",
                    data: DatosPeticion,
                    cache: false,
                    beforeSend: function () {
                        $('#BtnGeneraCierreDiario').attr('disabled', true);
                        $('#BtnGeneraCierreDiario').html(' <h4 class="text-white"><div class="spinner-border text-white align-self-center loader-sm "></div>Generando cierre diario</h4>');
                    },
                    success: function (data) {
                        $('#BtnGeneraCierreDiario').attr('disabled', false);
                        $('#BtnGeneraCierreDiario').html('Generar cierre diario');
                        var FechaCompromiso = $("#FechaCompromiso").val("");
                        var EstadoCalculadoFuturo = $("#EstadoCalculadoFuturo").val("");
                        var ComentarioCierre = $("#ComentarioCierre").val("");
                        AlertsSwet('Atención', data, 'info');
                        $("#ModalCrearCierre").modal('hide');
                    }
                });
            }
        })
    }
})

function SelectEstados() {

    var DatosPeticion = {
        'PostMethod': 'SelectEstados',
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectEstados",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $("#EstadoCalculadoFuturo").html(data);
        }
    });
}