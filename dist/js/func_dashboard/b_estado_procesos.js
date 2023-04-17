function Estado_Procesos() {
    var DatosPeticion = {
        'PostMethod': 'Estado_Procesos',
    };
    $('#TotalProcesos').html('<p align="center" class="spinner-grow loader-sm"></p>');
    $('#PieEstados').remove(); // this is my <canvas> element
    $('#DivEstados').append('<canvas id="PieEstados" width="200" height="100"></canvas>');
    $.ajax({
        url: "../../dist/php/controller.php?Estado_Procesos",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        dataType: "json",
        beforeSend: function() {
            google.charts.load("current", {
                packages: ["corechart"]
            });
            google.charts.setOnLoadCallback();
            $("#DivFiltro").hide();
            $("#ChartEstados").hide();
            $("#ChartEstadosZF").hide();
            $(".loaderDonaEstados").show();
            $("#CantidadTiempos").hide();
            $('#BtnAplicarFiltro').prop('disabled', true);
            $('.BtnVerDetalle').prop('disabled', true);
            $(".loaderKpi").show();
            $("#DatosKpiGeneral").html("");
            $('#DivHistorico').html('<p align="center" class="spinner-grow loader-sm"></p>');
            $("#table-Totales").hide();
        },
        success: function(data) {
            $("#CantidadTiempos").show();
            $("#DivFiltro").show();
            $(".loaderDonaEstados").hide();
            $('#BtnAplicarFiltro').prop('disabled', false);
            $('.BtnVerDetalle').prop('disabled', false);
            $('#RolID').val(data.RolID);
            $('.BtnVerDetalle').on("click", function() {
                var BtnSeleccionado = $(this).attr('id');
                $("#ModalDetalleProcesos").modal({
                    keyboard: false
                });
                $('#BtnSelected').val(BtnSeleccionado);
                $("#TablaEstados").show();
                $("#MenuZonaFranca").hide();
                var GrupoOperacion = 0;
                switch (BtnSeleccionado) {
                    case 'FueraTiempo':
                        $('.TituloModalPrincipal').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg> Fuera de Tiempo en aduana');
                        $('#TablaEstados').html(data.TablaFueraTiempo);
                        break;
                    case 'FueraTiempoFact':
                        $('.TituloModalPrincipal').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg> Fuera de Tiempo Facturación');
                        $('#TablaEstados').html(data.TablaFueraTiempoFact);
                        break;
                    case 'ATiempo':
                        $('.TituloModalPrincipal').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Procesos A Tiempo');
                        $('#TablaEstados').html(data.TablaATiempo);
                        break;
                    case 'SinEstado':
                        $('.TituloModalPrincipal').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg> Procesos A Sin Estado');
                        $('#TablaEstados').html(data.TablaSinEstado);
                        break;
                    case 'SinArribar':
                        $('.TituloModalPrincipal').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> Procesos Sin Arribar');
                        $('#TablaEstados').html(data.TablaASinArribar);
                        break;
                    case 'AllDetalle':
                        $('.TituloModalPrincipal').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg> Total procesos');
                        $('#TablaEstados').html(data.TablaDetalle);
                        break;
                    case 'ZonaFranca':
                        $("#TablaEstados").hide();
                        $("#MenuZonaFranca").show();
                        $('.TituloModalPrincipal').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg> Procesos en Zona Franca');
                        $('#TablaZonaFranca').html(data.TablaZonaFranca);
                        $('#TablaZFFueraTiempo').html(data.TablaZFFueraTiempo);
                        $('#TablaZFATiempo').html(data.TablaZFATiempo);
                        $('#TablaZFSinArribar').html(data.TablaZFSinArribar);
                        var GrupoOperacion = 1;
                        break;
                    case 'TotalProcesos':
                        $('.TituloModalPrincipal').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg> Total procesos');
                        $('#TablaEstados').html(data.TablaTotalProcesos);
                        break;
                }
                HabilitarBotonRangos(GrupoOperacion)
            });
            $('.task-TotalProcesos').countTo({
                from: 0,
                to: data.TotalProcesos,
                speed: 2000,
                formatter: function(value, options) {
                    return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
            });
            $('.task-FueraTiempo').countTo({
                from: 0,
                to: data.FueraDeTiempo,
                speed: 2000,
                formatter: function(value, options) {
                    return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
            });
            $('.task-FueraTiempoFact').countTo({
                from: 0,
                to: data.FueraTiempoFact,
                speed: 2000,
                formatter: function(value, options) {
                    return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
            });
            $('.task-SinEstado').countTo({
                from: 0,
                to: data.SinEstado,
                speed: 2000,
                formatter: function(value, options) {
                    return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
            });

            $('.task-ATiempo').countTo({
                from: 0,
                to: data.Atiempo,
                speed: 2000,
                formatter: function(value, options) {
                    return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
            });
            $('.task-SinArribar').countTo({
                from: 0,
                to: data.SinArribar,
                speed: 2000,
                formatter: function(value, options) {
                    return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
            });
            $('.task-ZonaFranca').countTo({
                from: 0,
                to: data.TotaZonaFranca,
                speed: 2000,
                formatter: function(value, options) {
                    return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
            });

            setTimeout(function() {
                $("#ChartEstados").show();
                ChartGoogle(data.TotaPorArribar, data.EnProcesoDeAduana, data.ProcesoDespacho, data.EnProcesoDeFacturacion, data.TotaZonaFranca, data.OrosProceos, data.TablaSinArribar, data.TablaEnprocesoAduana, data.TablaEnDespachoPaFact, data.TablaEnProcFact, data.TablaOtrosProcesos, data.TablaZonaFranca, data.TablaZFFueraTiemp, data.TablaZFATiempo, data.TablaZFSinArribar);
                if (data.TotaZonaFranca > 0) {
                    $("#ChartEstadosZF").show();
                    ChartGoogleZonaFranca(data.TotaPorArribarZF, data.EnProcesoDeAduanaZF, data.ProcesoDespachoZF, data.EnProcesoDeFacturacionZF, data.OrosProceosZF);
                }
            }, 3000);

        },
        failure: function(response) {
            alert('Datos erroneos')
        }
    });
}


$('.task-Compromiso').countTo({
    from: 0,
    to: 10,
    speed: 2000,
    formatter: function(value, options) {
        return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
});
$('.task-Incumplidas').countTo({
    from: 0,
    to: 6,
    speed: 2000,
    formatter: function(value, options) {
        return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
});


function HabilitarBotonRangos(GrupoOperacion) {
    $('#GrupoOperacion').val(GrupoOperacion);
}


$('body').on('click', '.BtnSearchDO', function(event) {

    $("#BtnVerLista").removeClass("btn-primary");
    var Campo = $(this).data('campo');
    var Valor = $(this).attr('id');
    var Estado = $(this).data('estado');
    var Titulo = $(this).data('titulo');
    var GrupoOperacion = $('#GrupoOperacion').val();
    $('#CampoInput').val(Campo);
    $('#ValorInput').val(Valor);
    $('#EstadoInput').val(Estado);

    var RolID = $('#RolID').val();
    if (Campo == 'TotalFila') {
        $('.TituloModalSecundario').html(Titulo);
    } else {
        $('.TituloModalSecundario').html(Titulo + ' ' + Valor + ' Dias');
    }
    $('#EstadoModal').val(Titulo);
    OpenModalDetalle();
    if (RolID == 1 || RolID == 9410 || RolID == 2) {
        $('#BtnVerLista').removeClass('btn-primary');
    } else {
        $('#BtnVerLista').addClass('btn-primary');
    }
    $("#BtnVerLista").trigger("click");
});

function ChartGoogle(TotaPorArribar, EnProcesoDeAduana, ProcesoDespacho, EnProcesoDeFacturacion, TotaZonaFranca, OrosProceos, TablaSinArribar, TablaEnprocesoAduana, TablaEnDespachoPaFact, TablaEnProcFact, TablaOtrosProcesos, TablaZonaFranca) {
    var data = google.visualization.arrayToDataTable([
        ["Element", "Operaciones", {
            role: "style"
        }],
        ["Por Arribar", TotaPorArribar, '#2EC218'],
        ["En Proceso de Aduana", EnProcesoDeAduana, '#1b55e2'],
        ["Proceso de Despacho y Pasar a Facturar", ProcesoDespacho, '#2196f3'],
        ["En proceso de Facturación", EnProcesoDeFacturacion, '#e7515a'],
        ["Zona Franca", TotaZonaFranca, '#e2a03f'],
        ["Otros Procesos", OrosProceos, '#e95f2b'],
    ]);
    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1, {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        },
        2
    ]);
    var options = {
        title: "Agrupado por Procesos",
        chartArea: {
            width: '40%'
        },
        width: 500,
        height: 400,
        bar: {
            groupWidth: "80%"
        },
        legend: {
            position: "none"
        },
        animation: {
            duration: 1000,
            easing: 'out',
        },
    };
    var chart = new google.visualization.BarChart(document.getElementById("ChartEstados"));
    chart.draw(view, options);
    google.visualization.events.addListener(chart, 'select', selectHandler);

    function selectHandler() {
        var selection = chart.getSelection();
        var message = '';
        for (var i = 0; i < selection.length; i++) {
            var item = selection[i];
            if (item.row != null && item.column != null) {
                var str = data.getFormattedValue(item.row, item.column);
                var category = data.getValue(chart.getSelection()[0].row, 0)
                var type
            } else if (item.row != null) {
                var str = data.getFormattedValue(item.row, 0);
            } else if (item.column != null) {
                var str = data.getFormattedValue(0, item.column);
            }
        }
        var GrupoOperacion = 0;
        $('#BtnSelected').val(category);
        switch (category) {
            case 'Por Arribar':
                $("#ModalDetalleProcesos").modal({
                    keyboard: false
                });
                $("#TablaEstados").show();
                $("#MenuZonaFranca").hide();
                $('.TituloModalPrincipal').html('Por Arribar');
                $('#TablaEstados').html(TablaSinArribar);
                break;
            case 'En Proceso de Aduana':
                $("#ModalDetalleProcesos").modal({
                    keyboard: false
                });
                $("#TablaEstados").show();
                $("#MenuZonaFranca").hide();
                $('.TituloModalPrincipal').html('En Proceso de Aduana');
                $('#TablaEstados').html(TablaEnprocesoAduana);
                break;
            case 'Proceso de Despacho y Pasar a Facturar':
                $("#ModalDetalleProcesos").modal({
                    keyboard: false
                });
                $("#TablaEstados").show();
                $("#MenuZonaFranca").hide();
                $('.TituloModalPrincipal').html('Proceso de Despacho y Pasar a Facturar');
                $('#TablaEstados').html(TablaEnDespachoPaFact);
                break;
            case 'En proceso de Facturación':
                $("#ModalDetalleProcesos").modal({
                    keyboard: false
                });
                $("#TablaEstados").show();
                $("#MenuZonaFranca").hide();
                $('.TituloModalPrincipal').html('En proceso de Facturación');
                $('#TablaEstados').html(TablaEnProcFact);
                break;
            case 'Otros Procesos':
                $("#ModalDetalleProcesos").modal({
                    keyboard: false
                });
                $("#TablaEstados").show();
                $("#MenuZonaFranca").hide();
                $('.TituloModalPrincipal').html('Otros Procesos');
                $('#TablaEstados').html(TablaOtrosProcesos);
                break;
            case 'Zona Franca':
                $("#ModalDetalleProcesos").modal({
                    keyboard: false
                });
                $("#TablaEstados").hide();
                $("#MenuZonaFranca").show();
                $('.TituloModalPrincipal').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg> Procesos en Zona Franca');
                $('#TablaZonaFranca').html(TablaZonaFranca);
                $('#TablaZFFueraTiempo').html(TablaZFFueraTiempo);
                $('#TablaZFATiempo').html(TablaZFATiempo);
                $('#TablaZFSinArribar').html(TablaZFSinArribar);
                var GrupoOperacion = 1;
                break;
        }
        HabilitarBotonRangos(GrupoOperacion)
    }
}

function ChartGoogleZonaFranca(TotaPorArribarZF, EnProcesoDeAduanaZF, ProcesoDespachoZF, EnProcesoDeFacturacionZF, OrosProceosZF) {
    var data = google.visualization.arrayToDataTable([
        ["Element", "Operaciones", {
            role: "style"
        }],
        ["Por Arribar", TotaPorArribarZF, '#2EC218'],
        ["En Proceso de Aduana", EnProcesoDeAduanaZF, '#1b55e2'],
        ["Proceso de Despacho y Pasar a Facturar", ProcesoDespachoZF, '#2196f3'],
        ["En proceso de Facturación", EnProcesoDeFacturacionZF, '#e7515a'],
        ["Otros Procesos", OrosProceosZF, '#e95f2b'],
    ]);
    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1, {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        },
        2
    ]);
    var options = {
        title: "Agrupado por Procesos Zona Franca",
        chartArea: {
            width: '40%'
        },
        width: 500,
        height: 400,
        bar: {
            groupWidth: "80%"
        },
        legend: {
            position: "none"
        },
        animation: {
            duration: 1000,
            easing: 'out',
        },
    };
    var chart = new google.visualization.BarChart(document.getElementById("ChartEstadosZF"));
    chart.draw(view, options);
    // function selectHandler() {
    //     var selection = chart.getSelection();
    //     var message = '';
    //     for (var i = 0; i < selection.length; i++) {
    //         var item = selection[i];
    //         if (item.row != null && item.column != null) {
    //             var str = data.getFormattedValue(item.row, item.column);
    //             var category = data.getValue(chart.getSelection()[0].row, 0)
    //             var type
    //         } else if (item.row != null) {
    //             var str = data.getFormattedValue(item.row, 0);
    //         } else if (item.column != null) {
    //             var str = data.getFormattedValue(0, item.column);
    //         }
    //     }
    //     var GrupoOperacion = 0;
    //     $('#BtnSelected').val(category);
    //     // switch (category) {
    //     //     case 'Por Arribar':
    //     //         $("#ModalDetalleProcesos").modal({
    //     //             keyboard: false
    //     //         });
    //     //         $("#TablaEstados").show();
    //     //         $("#MenuZonaFranca").hide();
    //     //         $('.TituloModalPrincipal').html('Por Arribar');
    //     //         $('#TablaEstados').html(TablaSinArribar);
    //     //         break;
    //     //     case 'En Proceso de Aduana':
    //     //         $("#ModalDetalleProcesos").modal({
    //     //             keyboard: false
    //     //         });
    //     //         $("#TablaEstados").show();
    //     //         $("#MenuZonaFranca").hide();
    //     //         $('.TituloModalPrincipal').html('En Proceso de Aduana');
    //     //         $('#TablaEstados').html(TablaEnprocesoAduana);
    //     //         break;
    //     //     case 'Proceso de Despacho y Pasar a Facturar':
    //     //         $("#ModalDetalleProcesos").modal({
    //     //             keyboard: false
    //     //         });
    //     //         $("#TablaEstados").show();
    //     //         $("#MenuZonaFranca").hide();
    //     //         $('.TituloModalPrincipal').html('Proceso de Despacho y Pasar a Facturar');
    //     //         $('#TablaEstados').html(TablaEnDespachoPaFact);
    //     //         break;
    //     //     case 'En proceso de Facturación':
    //     //         $("#ModalDetalleProcesos").modal({
    //     //             keyboard: false
    //     //         });
    //     //         $("#TablaEstados").show();
    //     //         $("#MenuZonaFranca").hide();
    //     //         $('.TituloModalPrincipal').html('En proceso de Facturación');
    //     //         $('#TablaEstados').html(TablaEnProcFact);
    //     //         break;
    //     //     case 'Otros Procesos':
    //     //         $("#ModalDetalleProcesos").modal({
    //     //             keyboard: false
    //     //         });
    //     //         $("#TablaEstados").show();
    //     //         $("#MenuZonaFranca").hide();
    //     //         $('.TituloModalPrincipal').html('Otros Procesos');
    //     //         $('#TablaEstados').html(TablaOtrosProcesos);
    //     //         break;
    //     //     case 'Zona Franca':
    //     //         $("#ModalDetalleProcesos").modal({
    //     //             keyboard: false
    //     //         });
    //     //         $("#TablaEstados").hide();
    //     //         $("#MenuZonaFranca").show();
    //     //         $('.TituloModalPrincipal').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg> Procesos en Zona Franca');
    //     //         $('#TablaZonaFranca').html(TablaZonaFranca);
    //     //         $('#TablaZFFueraTiempo').html(TablaZFFueraTiempo);
    //     //         $('#TablaZFATiempo').html(TablaZFATiempo);
    //     //         $('#TablaZFSinArribar').html(TablaZFSinArribar);
    //     //         var GrupoOperacion = 1;
    //     //         break;
    //     // }
    //    //HabilitarBotonRangos(GrupoOperacion)
    // }
}

function OpenModalDetalle() {
    $("#ModalDetalleProcesosDO").modal({
        keyboard: false
    });
    $('#ModalDetalleProcesosDO').on('shown.bs.modal', function(e) {
        $('#ModalDetalleProcesosDO').on('scroll', function() {
            var threshold = 60;
            if ($('#ModalDetalleProcesosDO').scrollTop() > threshold) {
                $('.fixed-header').addClass('affixed');
            } else {
                $('.fixed-header').removeClass('affixed');
            }
        });
        $('#ModalDetalleProcesosDO').on('hide.bs.modal', function(e) {
            $('.fixed-header').removeClass('affixed');
        });
        $('.fixed-header button').click(function() {
            $('#ModalDetalleProcesosDO').modal('hide');
        });
    })
}