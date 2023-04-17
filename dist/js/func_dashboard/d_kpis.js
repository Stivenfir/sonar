function KpisGenerales() {
    $("#DatosKpiGeneral").removeClass("animated slideInLeft");
    $("#DivKpis").removeClass('Hidden');
    $("#DivAllKpis").addClass('Hidden');
    $(".BtnRegresarKpis").addClass('Hidden');
    var TipoBtnFiltroKpi = $("#TipoBtnFiltroKpi").val()
    var MesesEvoLevantes = $("#MesesEvoLevantes").text()
    var RangoParaKPI = $("#RangoParaKPI").val();
    var RangoParaKPIComparar = $("#RangoParaKPIComparar").val();
    var DatosPeticion = {
        'PostMethod': 'KpisGenerales',
        'TipoBtnFiltroKpi': TipoBtnFiltroKpi,
        'RangoParaKPIComparar': RangoParaKPIComparar,
        'RangoParaKPI': RangoParaKPI,
        'MesesEvoLevantes': MesesEvoLevantes
    };
    $.ajax({
        url: "../../dist/php/controller.php?KpisGenerales",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        beforeSend: function () {
            $(".loaderKpi").show();
            $("#DatosKpiGeneral").html("");
        },
        success: function (data) {
            $(".loaderKpi").hide();
            $("#DatosKpiGeneral").html(data);
            $("#DatosKpiGeneral").addClass("animated slideInLeft");
            activateTooltip()
            OpenKPIDetails();
        }
    });
}

//Remove Function.
function OpenKPIDetails() {

    // $('#AplicarRangoKpi').on("click", function () {
    //     KpisGenerales();
    // });
}

$('#DashPrincipal').on('click', '#AplicarRangoKpi', function (event) {
    /// Evento valida existencia de clientes
    event.preventDefault();
    KpisGenerales();
});

$('#DashPrincipal').on('click', '.BtnFiltrarKpis', function (event) {
    /// Evento valida existencia de clientes
    $("#TipoBtnFiltroKpi").val($(this).attr('id'));
    $("#TextSelectKpi").text($(this).attr('id'));

    event.preventDefault();
    KpisGenerales();
});

$('#DashPrincipal').on('click', '.BtnDesplegarKPIUsers', function (event) {
    event.preventDefault();
    ClienteID = $(this).data('id');
    KpisUsuarios(ClienteID);
});



$('#DashPrincipal').on('click', '.BtnOpenModalKPI', function (event) {
    /// Evento valida existencia de clientes
    event.preventDefault();
    $(".BtnRegresarKpis").removeClass('Hidden');
    $("#DivKpis").addClass('Hidden');
    $("#DivAllKpis").removeClass('Hidden');
    var ElementoClonar = $(this).data('clon');
    clonar(ElementoClonar, 'HeaderAllKpi');
    $("#HeaderAllKpi").addClass("animated slideInUp");
    $(".RemoveCollapseKpi").addClass('Hidden');
    if ($('#DivAllKpis').is(":visible")) {
        GraficaKPI();
        ClienteID = $(this).data('id');
        $("#Idbusqueda").val(ClienteID);

        TipoList = $(this).data('tipolist');
        var TipoBtnFiltroKpi = $("#TipoBtnFiltroKpi").val()
        GetDetalleKpi(ClienteID, TipoBtnFiltroKpi);
        $("#DivDetallesKpi").addClass("animated slideInLeft");

        $('html, body').animate({
            'scrollTop': $('#DivTableroKpis').offset().top
        }, 0);


    }


});


$(".BtnDescargarExcelKPI").click(function (event) {
    event.preventDefault();


    // html2canvas(document.querySelector("#DivOperacion1")).then(canvas => {

    //     var img = canvas.toDataURL("image/png");
    //     document.write('<img src="' + img + '"/>');
    // });

    var RangoParaKPI = $("#RangoParaKPI").val();
    var TipoBusqueda = $("#TextSelectKpi").text();
    $("#Idbusqueda").val();
    var DatosPeticion = {
        'PostMethod': 'DescargarExcelKPI',
        'RangoParaKPI': RangoParaKPI,
        'TipoBusqueda': TipoBusqueda,
        'ClienteID': ClienteID
    };
    $.ajax({
        url: "../../dist/php/controller.php?DescargarExcelKPI",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        dataType: 'json',
        beforeSend: function () {

            $('#IdSpanButton').html('<p align="center" class="spinner-grow loader-sm"></p>');

        },
        success: function (data) {
            $('#IdSpanButton').html('<button title="Descargar en Excell" class="btn btn-dark BtnDescargarExcelKPI" id="ExcelKPI" type="button"><span class="ti-download"></span></button>');
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", data.filename);
            $a[0].click();
            $a.remove();
        }
    });
});

$(".BtnRegresarKpis").click(function (event) {
    $("#DivKpis").removeClass('Hidden');
    $("#DivAllKpis").addClass('Hidden');
    $(".BtnRegresarKpis").addClass('Hidden');
    $(".RemoveCollapseKpi").removeClass('Hidden');
});


$(".MesesEvoLevantes").click(function (event) {
    var MesesEvoLevantes = $(this).text();
    $("#MesesEvoLevantes").text(MesesEvoLevantes);

});




function printdiv(printdivname) {
    var headstr = "<html><head><title>Booking Details</title></head><body>";
    var footstr = "</body>";
    var newstr = document.getElementById(printdivname).innerHTML;
    var oldstr = document.body.innerHTML;
    document.body.innerHTML = headstr + newstr + footstr;
    window.print();
    document.body.innerHTML = oldstr;
    return false;
}
function KpisUsuarios(ValueID) {
    var TipoBtnFiltroKpi = $("#TipoBtnFiltroKpi").val()
    var RangoParaKPI = $("#RangoParaKPI").val();
    var RangoParaKPIComparar = $("#RangoParaKPIComparar").val();
    var DatosPeticion = {
        'PostMethod': 'KpisUsuarios',
        'CampoID': ValueID,
        'TipoBtnFiltroKpi': TipoBtnFiltroKpi,
        'RangoParaKPIComparar': RangoParaKPIComparar,
        'RangoParaKPI': RangoParaKPI,
    };
    $.ajax({
        url: "../../dist/php/controller.php?KpisUsuarios",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        beforeSend: function () {
            $('.card-bodyKpi' + ClienteID).html('<p align="center" class="spinner-grow loader-sm"></p>');
            $('.card-bodyKpi' + ClienteID).removeClass("animated slideInLeft");
        },
        success: function (data) {
            $('.card-bodyKpi' + ClienteID).addClass("animated slideInLeft");
            $('.card-bodyKpi' + ClienteID).html(data);
        }
    });
}

function GetDetalleKpi(ClienteID, TipoList) {
    var RangoParaKPI = $("#RangoParaKPI").val()
    var DatosPeticion = {
        'PostMethod': 'ListaDetalleKPI',
        'ClienteID': ClienteID,
        'TipoList': TipoList,
        'RangoParaKPI': RangoParaKPI,
    };
    $.ajax({
        url: "../../dist/php/controller.php?ListaDetalleKPI",
        method: "POST",
        data: DatosPeticion,
        dataType: 'json',
        cache: false,
        beforeSend: function () {
            $('#DetalleDOKPI').html('<p align="center" class="spinner-grow loader-sm"></p>');
        },
        success: function (data) {
            $('#DetalleDOKPI').html(data.table)
            SelectorMasivokpi();
            GetListaKpis();
            GetGraficaDetalles();
        }
    });
}


function GetListaKpis() {
    var ClienteID = $("#Idbusqueda").val();
    var DatosPeticion = {
        'PostMethod': 'GetListaKpis',
        'ClienteID': ClienteID
    };
    $.ajax({
        url: "../../dist/php/controller.php?GetListaKpis",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        success: function (data) {
            $('#ListaKpis').html(data)
        }
    });
}


function GetGraficaDetalles() {
    var ClienteID = $("#Idbusqueda").val();

    var RangoParaKPI = $("#RangoParaKPI").val()
    var DatosPeticion = {
        'PostMethod': 'GetGraficaDetalles',
        'ClienteID': ClienteID,
        'RangoParaKPI': RangoParaKPI,
    };
    $.ajax({
        url: "../../dist/php/controller.php?GetGraficaDetalles",
        method: "POST",
        data: DatosPeticion,
        dataType: 'json',
        cache: false,
        success: function (data) {
            GraficaKPIDetalles(data.nombres, data.ValoresCumple, data.ValoresNoCumple);
        }
    });
}



function GraficaKPIDetalles(nombres, ValoresCumple, ValoresNoCumple) {

    $('#GraficaKPI2').remove(); // this is my <canvas> element
    $('#ChartKPIDiv2').html('<div align="center" id="GraficaKPI2" class="" style="height:600px;"></div>');
    var GraficaKPI2 = echarts.init(document.getElementById('GraficaKPI2'));
    option = {
        color: ['#8DBF42', '#E7515A'],
        title: {
            text: 'NÚMERO DE OPERACIONES KPI'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        legend: {},
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'value',
            boundaryGap: [0, 0.01]
        },
        yAxis: {
            type: 'category',
            data: nombres
        },
        series: [
            {
                name: 'CUMPLE',
                type: 'bar',
                data: ValoresCumple
            },
            {
                name: 'INCUMPLE',
                type: 'bar',
                data: ValoresNoCumple
            }
        ]
    };

    GraficaKPI2.setOption(option);
}


function GraficaKPI() {
    // $('#GraficaKPI').remove(); // this is my <canvas> element
    // $('#ChartKPIDiv').html('<div id="GraficaKPI" class="" style="height:600px; "></div>');
    // var GraficaKPI = echarts.init(document.getElementById('GraficaKPI'));
    // option = {
    //     color: ['#163D6C', '#ec6a25'],
    //     title: {
    //         text: 'TOTAL OPERACIONES Y CUMPLIMIENTO KPI',
    //     },
    //     tooltip: {
    //         trigger: 'axis'
    //     },
    //     legend: {
    //         data: ['FACTURACION', 'NACIONALIZACION']
    //     },
    //     tooltip: {},
    //     toolbox: {
    //         show: true,
    //         feature: {

    //             magicType: {
    //                 show: true,
    //                 type: ['line', 'bar']
    //             },
    //             restore: {
    //                 show: true
    //             },
    //             saveAsImage: {
    //                 show: true
    //             }
    //         }
    //     },
    //     calculable: true,
    //     xAxis: [{
    //         type: 'category',
    //         data: ['KPI 1', 'KPI 2', 'KPI 3', 'KPI 4', 'KPI 5']
    //     }],
    //     yAxis: [{
    //         type: 'value'
    //     }],
    //     series: [{
    //         name: 'Total Operaciones',
    //         type: 'bar',
    //         data: [16, 25, 7.0, 135.6, 23.2, 25.6, 76.7],
    //         markPoint: {
    //             data: [{
    //                 type: 'max',
    //                 name: 'Meta KPI'
    //             }, {
    //                 type: 'min',
    //                 name: 'Meta KPI'
    //             }]
    //         },
    //         markLine: {
    //             data: [{
    //                 type: 'average',
    //                 name: 'Nacionalización'
    //             }]
    //         }
    //     }, {
    //         name: '',
    //         type: 'bar',
    //         data: [12, 1.5, 7.0, 78.6, 23.2, 25.6, 76.7],
    //         markPoint: {
    //             data: [{
    //                 name: '',
    //                 value: 182.2,
    //                 xAxis: 7,
    //                 yAxis: 183
    //             }, {
    //                 name: '',
    //                 value: 2.3,
    //                 xAxis: 11,
    //                 yAxis: 3
    //             }]
    //         },
    //         markLine: {
    //             data: [{
    //                 type: 'average',
    //                 name: 'Facturación'
    //             }]
    //         }
    //     }]
    // };
    // GraficaKPI.setOption(option);
}


function clonar(elemento, destino) {
    var elemento = document.getElementById(elemento);
    var clon = elemento.cloneNode(elemento);

    $("#" + destino).html(clon)


}
