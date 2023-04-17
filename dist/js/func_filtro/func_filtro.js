$('#BtnAplicarFiltro').on("click", function () {
    ActivaScripts();
});
$("#BuscadorInput").keyup(function () {
    var count = $("#BuscadorInput").val().length;
    var ValorInput = $("#BuscadorInput").val();
    if (count > 3) {
        // $("#DivFiltro").hide();
        $("#DivResultadosBusqueda").show();
        // $("#SelectDirectores").removeClass("animated slideInLeft");
        var DatosPeticion = {
            'PostMethod': 'BucadorDeTexto',
            'ValorInput': ValorInput
        };
        $.ajax({
            url: "../../dist/php/controller.php?BucadorDeTexto",
            method: "POST",
            data: DatosPeticion,
            cache: false,
            success: function (data) {
                $("#BtnInicio").trigger("click");
                $('#ItemsResultados').html(data);
                $('.TituloFiltro').html('Resultados de la busqueda');

                SeleccionarItemSearch();
                $("#BtnHablitarSeleccion").trigger("click");
            }
        });
    } else {
        //$("#DivFiltro").show();
        $('.TituloFiltro').html('Filtro');
        $("#DivResultadosBusqueda").hide();
    }
});

function SeleccionarItemSearch() {
    $('.BtnsItemSearch').on("click", function () {
        var ValueSeleccionado = $(this).attr('id');
        var CampoSearch = $(this).data('campo');
        // alert(CampoSearch + ' ' + ValueSeleccionado);
        var DatosPeticion = {
            'PostMethod': 'SeleccionarItemSearch',
            'CampoSearch': CampoSearch,
            'ValueSeleccionado': ValueSeleccionado,
        };
        $.ajax({
            url: "../../dist/php/controller.php?SeleccionarItemSearch",
            method: "POST",
            data: DatosPeticion,
            cache: false,
            success: function (data) {
                //$("#DivFiltro").show();
                $("#DivResultadosBusqueda").hide();
                MenuFiltroActivo();
                $("#SelectJefeCuenta").html("");
                $("#SelectCoordinador").html("");
                $("#SelectCliente").html("");
                $("#DivAplicarFiltro").show();
            }
        });
    });
}


$('.BtnsMenuCircular').on("click", function () {
    var BtnSeleccionado = $(this).attr('id');
    $('.BtnsMenuCircular').removeClass('ColorSelect');
    $('.BtnsMenuCircular').addClass('ColorDefault');
    $("#" + BtnSeleccionado).removeClass('ColorDefault');
    $("#" + BtnSeleccionado).addClass('ColorSelect');
    switch (BtnSeleccionado) {
        case 'DirectoresBtn':
            $("#SelectJefeCuenta").html("");
            $("#SelectCoordinador").html("");
            $("#SelectCliente").html("");
            SelectDirectores();
            //SelectJefeCuenta();
            break;
        case 'JefesBtn':
            $("#SelectCoordinador").html("");
            $("#SelectCliente").html("");
            SelectJefeCuenta();
            break;
        case 'CoordinadoresBtn':
            $("#SelectCliente").html("");
            SelectCoordinador();
            break;
        case 'ClientesBtn':
            SelectCliente();
            break;
    }
    $("#DivAplicarFiltro").show();
});

function MenuFiltroActivo(ClikMenuCircular = 0) {
    UrlManage('Filtro', 'aplicar');
    // $("#SelectDirectores").removeClass("animated slideInLeft");
    var DatosPeticion = {
        'PostMethod': 'MenuFiltroActivo',
    };
    $.ajax({
        url: "../../dist/php/controller.php?MenuFiltroActivo",
        method: "POST",
        data: DatosPeticion,
        dataType: 'json',
        cache: false,
        success: function (data) {
            $("#DirectoresSelected").html('<h6 class="text-primary">Director</h6>' + data.DirectoresSelected);
            $("#JefesSelected").html('<h6 class="text-primary">Jefe Cuenta</h6>' + data.JefesSelected);
            $("#CoordinadorSelected").html('<h6 class="text-primary">Coordinador</h6>' + data.CoordinadorSelected);
            $("#ClientesSelected").html('<h6 class="text-primary">Clientes</h6>' + data.ClientesSelected);
            $("#DivAplicarFiltro").show();
            if (ClikMenuCircular == 0) {
                ActivaScripts();
            }
            ActivarRemoveFiltros();
            // $("#SelectDirectores").addClass("animated slideInLeft");
            // $("#SelectDirectores").html(data);
            // activateTooltip();
        }
    });
}
$('#MostrarSeleccion').click(function () {
    MenuFiltroActivo();
});

function ActivarRemoveFiltros() {
    $('.RemoveListBtn').on("click", function () {
        var CamposID = $(this).attr('id');
        var DatosPeticion = {
            'PostMethod': 'RemoveListBtn',
            'CamposID': CamposID,
        };
        $.ajax({
            url: "../../dist/php/controller.php?RemoveListBtn",
            method: "POST",
            data: DatosPeticion,
            cache: false,
            success: function (data) {
                MenuFiltroActivo();
            }
        });
    });
}
///Peticiones Ajax
function ActivarSubmenus(Inicializar) {
    $('.BtnsSubMenuCircular').on("click", function () {
        var BtnClikeado = $(this).data('button');
        var ValueSeleccionado = $(this).attr('id');
        if ($("#" + ValueSeleccionado).hasClass("ColorDefault")) {
            $("#" + ValueSeleccionado).removeClass('ColorDefault');
            $("#" + ValueSeleccionado).addClass('ColorSelect');
        } else {
            $("#" + ValueSeleccionado).removeClass('ColorSelect');
            $("#" + ValueSeleccionado).addClass('ColorDefault');
        }
        var DatosPeticion = {
            'PostMethod': 'GenerarSessionFiltro',
            'TipoFiltro': BtnClikeado,
            'ValueSeleccionado': ValueSeleccionado
        };
        $.ajax({
            url: "../../dist/php/controller.php?GenerarSessionFiltro",
            method: "POST",
            data: DatosPeticion,
            cache: false,
            success: function (data) {
                switch (BtnClikeado) {
                    case 'BtnDirector':
                        //$("#JefesBtn").trigger("click");
                        MenuFiltroActivo();
                        break;
                    case 'BtnJefeCuenta':
                        //$("#CoordinadoresBtn").trigger("click");
                        MenuFiltroActivo();
                        break;
                    case 'BtnCoordinador':
                        // $("#ClientesBtn").trigger("click");
                        // 
                        MenuFiltroActivo();
                        break;
                    case 'BtnCliente':
                        MenuFiltroActivo();
                        break;
                }
            }
        });
    });
}

function SelectDirectores() {
    $("#SelectDirectores").removeClass("animated slideInLeft");
    var DatosPeticion = {
        'PostMethod': 'SelectDirectores',
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectDirectores",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $("#FiltrosSeleccionados").addClass("animated slideInLeft");
            $("#FiltrosSeleccionados").html(data);
            // activateTooltip();
            MenuFiltroActivo(1);
            ActivarSubmenus();
        }
    });
}

function SelectJefeCuenta() {
    $("#SelectJefeCuenta").removeClass("animated slideInLeft");
    var DatosPeticion = {
        'PostMethod': 'SelectJefeCuenta',
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectJefeCuenta",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $("#FiltrosSeleccionados").addClass("animated slideInLeft");
            $("#FiltrosSeleccionados").html(data);
            // activateTooltip();
            MenuFiltroActivo(1);
            ActivarSubmenus();
        }
    });
}

function SelectCoordinador() {
    $("#SelectCoordinador").removeClass("animated slideInLeft");
    var DatosPeticion = {
        'PostMethod': 'SelectCoordinador',
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectCoordinador",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $("#FiltrosSeleccionados").addClass("animated slideInLeft");
            $("#FiltrosSeleccionados").html(data);
            // activateTooltip();
            MenuFiltroActivo(1);
            ActivarSubmenus();
        }
    });
}

function SelectCliente() {
    $("#SelectCliente").removeClass("animated slideInLeft");
    var DatosPeticion = {
        'PostMethod': 'SelectCliente',
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectCliente",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $("#FiltrosSeleccionados").addClass("animated slideInLeft");
            $("#FiltrosSeleccionados").html(data);
            MenuFiltroActivo(1);
            ActivarSubmenus();
        }
    });
}

function HideValues() {
    $("#SelectDirectores").html('');
}
// function GraficaDonaEstados() {
//     var DatosPeticion = {
//         'PostMethod': 'GraficaDonaEstados',
//     };
//     $.ajax({
//         url: "../../dist/php/controller.php?GraficaDonaEstados",
//         method: "POST",
//         data: DatosPeticion,
//         cache: false,
//         dataType: "json",
//         success: function(data) {
//             var options = {
//                 chart: {
//                     height: 350,
//                     type: 'pie',
//                     toolbar: {
//                         show: true,
//                     }
//                 },
//                 noData: {
//                     text: 'Cargando Datos...'
//                 },
//                 series: data.series,
//                 labels: data.labels,
//                 responsive: [{
//                     breakpoint: 480,
//                     options: {
//                         chart: {
//                             width: 200
//                         },
//                         legend: {
//                             position: 'bottom'
//                         }
//                     }
//                 }]
//             };
//             var chart = new ApexCharts(document.querySelector("#GraficaDonaEstados"), options);
//             chart.render();
//         },
//         failure: function(response) {
//             alert('Error en la petición')
//         }
//     });
// }
function activateTooltip() {
    $('[data-toggle="tooltip"]').tooltip();
}

function ValidarUserLog() {
    var DatosPeticion = {
        'PostMethod': 'ValidarUserLog',
    };
    $.ajax({
        url: "../../dist/php/controller.php?ValidarUserLog",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            switch (data) {
                case '1':
                    break;
                case '2':
                    $("#GrupoDirectores").remove();
                    $("#DirectoresSelected").remove();
                    break;
                case '3':
                    $("#GrupoDirectores").remove();
                    $("#GrupoJefes").remove();
                    $("#DirectoresSelected").remove();
                    $("#JefesSelected").remove();
                    break;
                case '4':
                    $("#GrupoDirectores").remove();
                    $("#GrupoJefes").remove();
                    $("#GrupoCoordinadores").remove();
                    $("#DirectoresSelected").remove();
                    $("#JefesSelected").remove();
                    $("#CoordinadorSelected").remove();
                    break;
                case '5':
                    $("#BtnActualizarDatos").remove();
                    break;
            }
        }
    });
}
$('.BtnBorrarFiltro').on("click", function () {
    BorrarFiltro();
});

function BorrarFiltro() {


    $("#RangoParaKPI").val('');
    $("#RangoParaKPIComparar").val('');

    var DatosPeticion = {
        'PostMethod': 'BorrarFiltro',
    };

    $.ajax({
        url: "../../dist/php/controller.php?BorrarFiltro",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            switch (data) {
                case '1':
                case '9410':
                    $("#DirectoresBtn").trigger("click");
                    break;
                case '2':
                    $("#JefesBtn").trigger("click");
                    break;
                case '3':
                    $("#CoordinadoresBtn").trigger("click");
                    break;
                case '4':
                    $("#ClientesBtn").trigger("click");
                    break;
            }
            ActivaScripts();
        }
    });
}
$('.CancelCorreo').on("click", function () {
    CKEDITOR.instances['Mensaje'].setData('');
    $('#ModalCrearCorreo').modal('hide');
});
$('.CancelCierre').on("click", function () {

    $('#ModalCrearCierre').modal('hide');
});
$('body').on('hidden.bs.modal', function () {
    if ($('.modal.in').length > 0) {
        $('body').addClass('modal-open');
    }
});

function FechaTablero() {
    var DatosPeticion = {
        'PostMethod': 'FechaTablero',
    };
    $.ajax({
        url: "../../dist/php/controller.php?FechaTablero",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        beforeSend: function () { },
        success: function (data) {
            $("#FechaTablero").html(data);
            CargasDeprocesos();
        }
    });
}
$('#ZonaFrancaCheckU').click(function () {
    CargasDeprocesos()
});

function CargasDeprocesos() {
    $("#LinkClientesPie").removeClass('active');
    $("#PieClientes").removeClass('fade show active');
    $("#LinkUsuariosPie").removeClass('active');
    $("#LinkUsuariosPie").addClass('active');
    $("#PieUsuarios").removeClass('fade show active');
    $("#PieUsuarios").addClass('fade show active');
    PeticionDatosPies(1);
    PeticionDatosPies(2);
    PeticionDatosPies(3);
}

function PeticionDatosPies(Tipo) {
    var DatosPeticion = {
        'PostMethod': 'CargaLaboraUsuarios',
        'Tipo': Tipo
    };
    $.ajax({
        url: "../../dist/php/controller.php?CargaLaboraUsuarios",
        method: "POST",
        data: DatosPeticion,
        dataType: "json",
        cache: false,
        success: function (data) {
            if (Tipo == 1) {
                GraficarPieUsers(data);
            } else if (Tipo == 2) {
                GraficarPieUsersConZF(data);
            } else {
                GraficarPieUsersAll(data)
            }
        }
    });
}

function GraficarPieUsers(datosGrafica) {
    $('#CargaLaboraUsuarios').remove(); // this is my <canvas> element
    $('#PieUsuariosSinZF').html('<div id="CargaLaboraUsuarios" class="" style="height:180px; "></div>');
    var CargaLaboraUsuarios = echarts.init(document.getElementById('CargaLaboraUsuarios'));
    var option3 = {
        title: {
            text: 'Procesos en Deposito',
            left: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)",
            backgroundColor: 'rgba(33,33,33,1)',
            borderRadius: 0,
            padding: 10,
            textStyle: {
                color: '#fff',
                fontStyle: 'normal',
                fontWeight: 'normal',
                fontFamily: "'Poppins', sans-serif",
                fontSize: 12
            }
        },
        legend: {
            show: false,
        },
        toolbox: {
            show: true,
            feature: {
                mark: {
                    show: true
                },
                dataView: {
                    show: true,
                    readOnly: false
                },
                magicType: {
                    show: true,
                    type: ['pie', 'funnel'],
                    option: {
                        funnel: {
                            x: '25%',
                            width: '50%',
                            funnelAlign: 'center',
                            max: 1548
                        }
                    }
                },
            }
        },
        calculable: true,
        itemStyle: {
            normal: {
                shadowBlur: 15,
                shadowColor: 'rgba(0, 0, 0, 0.5)'
            }
        },
        series: [{
            name: 'Usuario:',
            type: 'pie',
            radius: '40%',
            center: ['50%', '50%'],
            color: ["#8d62cd", "#0095eb", "#243f6b", "#FFC04F", "#FF6E24", "#FF5368", "#DA4296"],
            label: {
                normal: {
                    fontFamily: "'Poppins', sans-serif",
                    fontSize: 12
                }
            },
            data: datosGrafica.sort(function (a, b) {
                return a.value - b.value;
            }),
            itemStyle: {
                normal: {
                    label: {
                        show: true,
                        formatter: "{b}:{c}({d}%)"
                    },
                    labelLine: {
                        show: true
                    }
                }
            }
        }],
        animationType: 'scale',
        animationEasing: 'elasticOut',
        animationDelay: function (idx) {
            return Math.random() * 1000;
        }
    };
    CargaLaboraUsuarios.setOption(option3);
    CargaLaboraUsuarios.on('click', function (params) {
        ActivarDesdePie(params.data.Campo, params.data.seriesId)
    });
}

function GraficarPieUsersConZF(datosGrafica) {
    $('#CargaLaboraUsuariosConZF').remove(); // this is my <canvas> element
    $('#PieUsuariosConZF').html('<div id="CargaLaboraUsuariosConZF" class="" style="height:180px; "></div>');
    var CargaLaboraUsuariosConZF = echarts.init(document.getElementById('CargaLaboraUsuariosConZF'));
    var option3 = {
        title: {
            text: 'Procesos Zona Franca',
            left: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)",
            backgroundColor: 'rgba(33,33,33,1)',
            borderRadius: 0,
            padding: 10,
            textStyle: {
                color: '#fff',
                fontStyle: 'normal',
                fontWeight: 'normal',
                fontFamily: "'Poppins', sans-serif",
                fontSize: 12
            }
        },
        legend: {
            show: false,
        },
        toolbox: {
            show: true,
            feature: {
                mark: {
                    show: true
                },
                dataView: {
                    show: true,
                    readOnly: false
                },
                magicType: {
                    show: true,
                    type: ['pie', 'funnel'],
                    option: {
                        funnel: {
                            x: '25%',
                            width: '50%',
                            funnelAlign: 'center',
                            max: 1548
                        }
                    }
                },
            }
        },
        calculable: true,
        itemStyle: {
            normal: {
                shadowBlur: 15,
                shadowColor: 'rgba(0, 0, 0, 0.5)'
            }
        },
        series: [{
            name: 'Usuario:',
            type: 'pie',
            radius: '40%',
            center: ['50%', '50%'],
            color: ["#8d62cd", "#0095eb", "#243f6b", "#FFC04F", "#FF6E24", "#FF5368", "#DA4296"],
            label: {
                normal: {
                    fontFamily: "'Poppins', sans-serif",
                    fontSize: 12
                }
            },
            data: datosGrafica.sort(function (a, b) {
                return a.value - b.value;
            }),
            itemStyle: {
                normal: {
                    label: {
                        show: true,
                        formatter: "{b}:{c}({d}%)"
                    },
                    labelLine: {
                        show: true
                    }
                }
            }
        }],
        animationType: 'scale',
        animationEasing: 'elasticOut',
        animationDelay: function (idx) {
            return Math.random() * 1000;
        }
    };
    CargaLaboraUsuariosConZF.setOption(option3);
    CargaLaboraUsuariosConZF.on('click', function (params) {
        ActivarDesdePie(params.data.Campo, params.data.seriesId)
    });
}

function GraficarPieUsersAll(datosGrafica) {
    $('#CargaLaboraUsuariosAll').remove(); // this is my <canvas> element
    $('#PieUsuariosAll').html('<div id="CargaLaboraUsuariosAll" class="" style="height:280px; "></div>');
    var CargaLaboraUsuariosAll = echarts.init(document.getElementById('CargaLaboraUsuariosAll'));
    var option3 = {
        title: {
            text: 'Total de procesos',
            left: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)",
            backgroundColor: 'rgba(33,33,33,1)',
            borderRadius: 0,
            padding: 10,
            textStyle: {
                color: '#fff',
                fontStyle: 'normal',
                fontWeight: 'normal',
                fontFamily: "'Poppins', sans-serif",
                fontSize: 12
            }
        },
        legend: {
            show: false,
        },
        toolbox: {
            show: true,
            feature: {
                mark: {
                    show: true
                },
                dataView: {
                    show: true,
                    readOnly: false
                },
                magicType: {
                    show: true,
                    type: ['pie', 'funnel'],
                    option: {
                        funnel: {
                            x: '25%',
                            width: '50%',
                            funnelAlign: 'center',
                            max: 1548
                        }
                    }
                },
                restore: {
                    show: true
                },
                saveAsImage: {
                    show: true
                }
            }
        },
        calculable: true,
        itemStyle: {
            normal: {
                shadowBlur: 15,
                shadowColor: 'rgba(0, 0, 0, 0.5)'
            }
        },
        series: [{
            name: 'Usuario:',
            type: 'pie',
            radius: '40%',
            center: ['50%', '50%'],
            color: ["#8d62cd", "#0095eb", "#243f6b", "#FFC04F", "#FF6E24", "#FF5368", "#DA4296"],
            label: {
                normal: {
                    fontFamily: "'Poppins', sans-serif",
                    fontSize: 12
                }
            },
            data: datosGrafica.sort(function (a, b) {
                return a.value - b.value;
            }),
            itemStyle: {
                normal: {
                    label: {
                        show: true,
                        formatter: "{b}:{c}({d}%)"
                    },
                    labelLine: {
                        show: true
                    }
                }
            }
        }],
        animationType: 'scale',
        animationEasing: 'elasticOut',
        animationDelay: function (idx) {
            return Math.random() * 1000;
        }
    };
    CargaLaboraUsuariosAll.setOption(option3);
    CargaLaboraUsuariosAll.on('click', function (params) {
        ActivarDesdePie(params.data.Campo, params.data.seriesId)
    });
}

function ActivarDesdePie(BtnClikeado, ValueSeleccionado) {
    switch (BtnClikeado) {
        case 'DirectorID':
            var BtnFiltro = 'BtnDirector';
            break;
        case 'JefeCuentaID':
            var BtnFiltro = 'BtnJefeCuenta';
            break;
        case 'EjecutivoID':
            var BtnFiltro = 'BtnCoordinador';
            break;
    }
    var DatosPeticion = {
        'PostMethod': 'GenerarSessionFiltro',
        'TipoFiltro': BtnFiltro,
        'ValueSeleccionado': ValueSeleccionado
    };
    $.ajax({
        url: "../../dist/php/controller.php?GenerarSessionFiltro",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $("#MostrarSeleccion").trigger("click");
        }
    });
}
$('#ZonaFrancaCheckC').click(function () {
    $(".PieCliente").trigger("click");
});
$(".PieCliente").click(function (event) {
    var ZonaFrancaCheckC = 0;
    if ($('#ZonaFrancaCheckC').is(":checked")) {
        var ZonaFrancaCheckC = 1
    }
    var DatosPeticion = {
        'PostMethod': 'CargaClientes',
        'ZonaFrancaCheckC': ZonaFrancaCheckC
    };
    $.ajax({
        url: "../../dist/php/controller.php?CargaClientes",
        method: "POST",
        data: DatosPeticion,
        dataType: "json",
        cache: false,
        success: function (data) {
            GraficarPieClientes(data)
        }
    });
});

function GraficarPieClientes(datosGrafica) {
    var CargaClientes = echarts.init(document.getElementById('CargaClientes'));
    CargaClientes.resize();
    var option3 = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)",
            backgroundColor: 'rgba(33,33,33,1)',
            borderRadius: 0,
            padding: 5,
            textStyle: {
                color: '#fff',
                fontStyle: 'normal',
                fontWeight: 'normal',
                fontFamily: "'Poppins', sans-serif",
                fontSize: 10
            }
        },
        legend: {
            show: false
        },
        toolbox: {
            show: false,
        },
        calculable: true,
        itemStyle: {
            normal: {
                shadowBlur: 15,
                shadowColor: 'rgba(0, 0, 0, 0.5)'
            }
        },
        series: [{
            name: 'Cliente:',
            type: 'pie',
            radius: '40%',
            center: ['50%', '50%'],
            color: ["#8d62cd", "#0095eb", "#243f6b", "#FFC04F", "#FF6E24", "#FF5368", "#DA4296"],
            label: {
                normal: {
                    fontFamily: "'Poppins', sans-serif",
                    fontSize: 12
                }
            },
            data: datosGrafica.sort(function (a, b) {
                return a.value - b.value;
            }),
            itemStyle: {
                normal: {
                    label: {
                        show: true,
                        formatter: "{b}:{c}({d}%)"
                    },
                    labelLine: {
                        show: true
                    }
                }
            }
        }],
        animationType: 'scale',
        animationEasing: 'elasticOut',
        animationDelay: function (idx) {
            return Math.random() * 1000;
        }
    };
    CargaClientes.setOption(option3);
    CargaClientes.resize();
    CargaClientes.on('click', function (params) {
        // alert(params.data.Campo)
    });
}