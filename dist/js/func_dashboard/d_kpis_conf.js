$('.BtnKpi').on("click", function () {
    idKPI = $(this).data('id');
    if (idKPI == 'AgregarKpi') {
        $("#TypePost").val('AgregarKpi');
        $("#idKPI").val('NA');
        UrlManage('KpisAdd', 'new');
        OpenModalKpis();
    }
});

function OpenModalKpis() {
    SelectorClientes();
    SelectorFechasKpis();
    $('#DivDatosKPI').addClass('Hidden');
    $('#DivPruebaKPI').addClass('Hidden');
    $('#DivResultadosPruebaKPI').addClass('Hidden');
    var TypePost = $("#TypePost").val();
    var idKPI = $("#idKPI").val();
    if (TypePost == 'EditarKpi') {
        GetDataKpi();
    }
    $("#ModalKpis").modal();
    $('.modal').css('overflow-y', 'auto');
}

function SelectorClientes() {
    var DatosPeticion = {
        'PostMethod': 'SelectorClientes',
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectorClientes",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $('#SelectorClientes').html(data);
        }
    });
}

function GetDataKpi() {
    var idKPI = $("#idKPI").val();
    var DatosPeticion = {
        'PostMethod': 'GetDataKpi',
        'idKPI': idKPI
    };
    $.ajax({
        url: "../../dist/php/controller.php?GetDataKpi",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        dataType: 'json',
        success: function (data) {
            if (data.total > 0) {
                $('#DivDatosKPI').removeClass('Hidden');
                $('#DivPruebaKPI').removeClass('Hidden');
                $("#NombreKPI").val(data.NombreKPI);
                $("#SelectorClientes").val(data.SelectorClientes).change();
                $("#TipoKPI").val(data.TipoKPI).change();
                $("#FechaInicialKpi").val(data.FechaInicialKpi).change();
                $("#FechaFinalKpi").val(data.FechaFinalKpi).change();
                $("#TipoTransporte").val(data.TipoTransporte).change();
                $("#TipoOperacion").val(data.TipoOperacion).change();
                $("#DiasCalculo").val(data.DiasCalculo).change();
                $("#TiempoMeta").val(data.TiempoMeta);
                $("#PercKpi").val(data.PercKpi);
            } else {
                MostrarAlerta('error', 'Error', 'Sin datos para modificar', 'NombreKPI');
                $("#ModalKpis").modal('hide');
            }
        }
    });
}

function SelectorFechasKpis() {
    var DatosPeticion = {
        'PostMethod': 'SelectorFechasKpis',
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectorFechasKpis",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $('#FechaInicialKpi').html(data);
            $('#FechaFinalKpi').html(data);
        }
    });
}
$('#SelectorClientes').on("change", function () {
    var clienteID = $('#SelectorClientes').val();
    if (clienteID != 'seleccione') {
        $('#DivDatosKPI').removeClass('Hidden');
        $('#DivPruebaKPI').removeClass('Hidden');
        SelectorInstruccion();
    } else {
        $('#DivDatosKPI').removeClass('Hidden');
        $('#DivDatosKPI').addClass('Hidden');
        $('#DivPruebaKPI').removeClass('Hidden');
        $('#DivPruebaKPI').addClass('Hidden');
        $('#TipoInstruccion').html("");
    }
});

function SelectorInstruccion() {
    var ClienteID = $('#SelectorClientes').val();
    var DatosPeticion = {
        'PostMethod': 'SelectorInstruccion',
        'ClienteID': ClienteID
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectorInstruccion",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $('#TipoInstruccion').html(data);

        }
    });
}




$('#DiasCalculo').on("change", function () {
    var DiasCalculo = $('#DiasCalculo').val();
    if (DiasCalculo == 'HorasCorridas' || DiasCalculo == 'HorasHabiles') {
        $("#TipoCalculoText").text('Horas ');
    } else {
        $("#TipoCalculoText").text('Dias ');
    }
});
$('.btnSubmit').on("click", function (e) {
    var forms = $('.Formulario_KPIS');
    var IdBtnSubmit = $(this).attr('id');
    var validation = Array.prototype.filter.call(forms, function (form) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();
            event.stopPropagation();
            switch (IdBtnSubmit) {
                case 'BtnPruebaKPI':
                    PruebaLogicaKpi();
                    break;
                case 'BtnGuardarKPI':
                    GuardarFormKPI();
                    break;
            }
        }
        form.classList.add('was-validated');
    });
});

function PruebaLogicaKpi() {
    var RangoFechaInicialKpi = $("#RangoFechaInicialKpi").val()
    var RangoFechaFinalKpi = $("#RangoFechaFinalKpi").val()

    if (RangoFechaInicialKpi == '') {
        MostrarAlerta('error', 'Error', 'Seleccione Fecha', 'RangoFechaInicialKpi')
    } else if (RangoFechaFinalKpi == '') {
        MostrarAlerta('error', 'Error', 'Seleccione Fecha', 'RangoFechaFinalKpi')
    } else {
        $('#DivResultadosPruebaKPI').removeClass('Hidden');
        var TypePost = $("#TypePost").val();
        var idKPI = $("#idKPI").val();
        var NombreKPI = $("#NombreKPI").val();
        var SelectorClientes = $("#SelectorClientes").val();
        var FechaInicialKpi = $("#FechaInicialKpi").val();
        var FechaFinalKpi = $("#FechaFinalKpi").val();
        var TipoTransporte = $("#TipoTransporte").val();
        var TipoOperacion = $("#TipoOperacion").val();
        var DiasCalculo = $("#DiasCalculo").val();
        var TiempoMeta = $("#TiempoMeta").val();
        var PercKpi = $("#PercKpi").val();
        var TipoInstruccion = $("#TipoInstruccion").val()
        var LimiteDatos = $("#LimiteDatos").val()
        var TipoKPI = $("#TipoKPI").val()
        var DatosPeticion = {
            'PostMethod': 'PruebaLogicaKpi',
            'NombreKPI': NombreKPI,
            'SelectorClientes': SelectorClientes,
            'FechaInicialKpi': FechaInicialKpi,
            'FechaFinalKpi': FechaFinalKpi,
            'TipoTransporte': TipoTransporte,
            'TipoOperacion': TipoOperacion,
            'DiasCalculo': DiasCalculo,
            'TiempoMeta': TiempoMeta,
            'PercKpi': PercKpi,
            'RangoFechaInicialKpi': RangoFechaInicialKpi,
            'RangoFechaFinalKpi': RangoFechaFinalKpi,
            'TipoInstruccion': TipoInstruccion,
            'LimiteDatos': LimiteDatos,
            'TipoKPI': TipoKPI,
        };
        $.ajax({
            url: "../../dist/php/controller.php?PruebaLogica",
            method: "POST",
            data: DatosPeticion,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $("#ResultadosPruebaDiv").html('<div class="col-md-12" align="center"><div align="center" class="loader multi-loader mx-auto"></div><h5 align="center">Simulando información...</h5></div>');
            },
            success: function (data) {
                $("#ResultadosPruebaDiv").html(data.html);
            }
        });
    }
}

function GuardarFormKPI() {
    $('#DivResultadosPruebaKPI').removeClass('Hidden');
    var TypePost = $("#TypePost").val();
    var idKPI = $("#idKPI").val();
    var NombreKPI = $("#NombreKPI").val()
    var SelectorClientes = $("#SelectorClientes").val()
    var FechaInicialKpi = $("#FechaInicialKpi").val()
    var FechaFinalKpi = $("#FechaFinalKpi").val()
    var TipoTransporte = $("#TipoTransporte").val()
    var TipoOperacion = $("#TipoOperacion").val()
    var DiasCalculo = $("#DiasCalculo").val()
    var TiempoMeta = $("#TiempoMeta").val()
    var PercKpi = $("#PercKpi").val()
    var TipoKPI = $("#TipoKPI").val()
    var TipoInstruccion = $("#TipoInstruccion").val()
    var RangoFechaInicialKpi = $("#RangoFechaInicialKpi").val()
    var RangoFechaFinalKpi = $("#RangoFechaFinalKpi").val()

    if (RangoFechaInicialKpi == '') {
        MostrarAlerta('error', 'Error', 'Seleccione Fecha', 'RangoFechaInicialKpi')
    } else if (RangoFechaFinalKpi == '') {
        MostrarAlerta('error', 'Error', 'Seleccione Fecha', 'RangoFechaFinalKpi')
    } else {
        var DatosPeticion = {
            'PostMethod': 'GuardarFormKPI',
            'TypePost': TypePost,
            'idKPI': idKPI,
            'NombreKPI': NombreKPI,
            'SelectorClientes': SelectorClientes,
            'FechaInicialKpi': FechaInicialKpi,
            'FechaFinalKpi': FechaFinalKpi,
            'TipoTransporte': TipoTransporte,
            'TipoOperacion': TipoOperacion,
            'DiasCalculo': DiasCalculo,
            'TiempoMeta': TiempoMeta,
            'PercKpi': PercKpi,
            'TipoKPI': TipoKPI,
            'TipoInstruccion': TipoInstruccion,
            'RangoFechaInicialKpi': RangoFechaInicialKpi,
            'RangoFechaFinalKpi': RangoFechaFinalKpi,
        };
        swal({
            title: 'Esta seguro de guardar?',
            html: '<h6 class="text-danger"> se aplicará a todos los DO del cliente seleccionado a partir de este momento</h6>',
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Guardar KPI',
            padding: '2em'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: "../../dist/php/controller.php?GuardarFormKPI",
                    method: "POST",
                    data: DatosPeticion,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function () {
                        swal({
                            title: 'Guardando ',
                            html: '<div class="spinner-border spinner-border-reverse align-self-center loader-sm text-primary"></div>',
                            type: 'info',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        });
                    },
                    success: function (data) {
                        if (data.status == 'Existe') {
                            MostrarAlerta('warning', 'KPI Existe', 'ya existe un KPI con las mismas condiciones.');
                        } else if (data.status == 'Correcto') {
                            MostrarAlerta('success', 'Correcto', 'Se guardó correctamente el KPI.');
                            $("#idKPI").val(data.idKPI);
                            $("#TypePost").val('EditarKpi');
                            $('#TableKpis').DataTable().ajax.reload();
                        } else {
                            MostrarAlerta('error', 'Error', 'error inesperado' + data);
                        }
                    }
                });
            }
        })
    }
}

function TableKpis() {
    var DatosPeticion = {
        'PostMethod': 'TableKpis',
    };
    if ($.fn.DataTable.isDataTable('#TableKpis')) {
        $('#TableKpis').DataTable().destroy();
    }
    var dataTable = $('#TableKpis').DataTable({
        "oLanguage": {
            "sLoadingRecords": '<p class="text-pri">Cargando... </p><div class="spinner-border spinner-border-reverse align-self-center loader-sm text-primary"></div>',
            "sEmptyTable": '<div class="alert alert-info mb-4" role="alert"><strong>Sin Datos!</strong> No existen Kpis</div> ',
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando Pag _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 30, 50, 100],
        "pageLength": 30,
        "order": [
            [0, 'asc']
        ],
        "ajax": {
            url: "../../dist/php/controller.php?TableKpis",
            data: DatosPeticion, //  Fuente de datos json
            type: "post",
            error: function () {
                AlertToast('error', 'Falló el datatble')
            }
        }
    });
}
$('#TableKpis').on('click', '.BtnKpi', function (e) {
    e.preventDefault(); // <--- prevent form from submitting
    var idkpi = $(this).data('id');
    $("#TypePost").val('EditarKpi');
    $("#idKPI").val(idkpi);
    UrlManage('KpisEdit', idkpi);
    OpenModalKpis();
});

function MostrarAlerta(Tipo, Titulo, Mensaje, idField = false) {
    $("#" + idField).focus();
    swal({
        title: Titulo,
        type: Tipo,
        html: Mensaje,
        showCloseButton: true,
        confirmButtonText: '<i class="flaticon-checked-1"></i> Aceptar!',
        padding: '2em'
    })
}