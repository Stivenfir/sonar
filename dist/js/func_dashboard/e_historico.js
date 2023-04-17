function HistoricoChart() {
    var DatosPeticion = {
        'PostMethod': 'HistoricoChart',
    };
    $('#HistoricoChart').remove(); // this is my <canvas> element
    $('#DivHistorico').html('<div id="HistoricoChart" class="" style="height:600px; "></div>');
    var ctx = $('#HistoricoChart').attr('id');
    $.ajax({
        url: "../../dist/php/controller.php?HistoricoChart",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        dataType: "json",
        success: function (data) {
            $("#table-Totales").show();
            $('#MesActual').html(data.MesActual);
            $('#RangoKPI').html(data.RangoKPI);
            $('#PromedioHistorico').html(data.Promedio);
            $('#hmtlFechas').html(data.hmtlFechas);
            $('#hmtlTotalProcesos').html(data.hmtlTotalProcesos);
            var Graficahistorico = echarts.init(document.getElementById('HistoricoChart'));
            const colors = ["#163D6C","#1B55E2", "#2196F3", "#E7515A", "#E2A03F", "#2EC218", "#E95F2B", "#C2D5FF"];
            const labelOption = {
                show: true,
                position: 'insideBottom',
                distance: 15,
                align: 'left',
                verticalAlign: 'middle',
                rotate: 90,
                formatter: '{c} {name|{a}}',
                fontSize: 15,
                rich: {
                    name: {}
                }
            };
            option = {
                color: colors,
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    data: ['TOTAL','EN ADUANA', 'EN DESPACHO', 'EN FACTURACIÓN', 'ZONA FRANCA', 'POR ARRIBAR', 'OTROS PROCESOS', 'LEVANTES'],
                    bottom: 0
                },
                toolbox: {
                    show: true,
                    orient: 'vertical',
                    left: 'right',
                    top: 'center',
                    feature: {
                        mark: { show: true },
                        //  dataView: { show: true, readOnly: false },
                        magicType: { show: true, type: ['stack'] },
                        // restore: { show: true },
                        saveAsImage: { show: true }
                    }
                },
                xAxis: [
                    {
                        type: 'category',
                        axisTick: { show: false },
                        data: data.labels
                    }
                ],
                yAxis: [
                    {
                        type: 'value'
                    }
                ],
                series: [

                    {
                        name: 'TOTAL',
                        type: 'bar',
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },
                        markLine: {
                            lineStyle: {
                                type: 'line'
                            },
                            data: [{
                                type: "average"
                            }],
                        },
                        data: data.TotalProcesos
                    },
                    {
                        name: 'EN ADUANA',
                        type: 'bar',
                        barGap: 0,
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },
                        data: data.EnADauana    
                    },
                    {
                        name: 'EN DESPACHO',
                        type: 'bar',
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },
                        data: data.EnDespacho
                    },
                    {
                        name: 'EN FACTURACIÓN',
                        type: 'bar',
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },markLine: {
                            lineStyle: {
                                type: 'line'
                            },
                            data: [{
                                type: "average"
                            }],
                        },
                        data: data.EnFactura
                    },
                    {
                        name: 'ZONA FRANCA',
                        type: 'bar',
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },
                        data: data.ZonaFranca
                    },
                    {
                        name: 'POR ARRIBAR',
                        type: 'bar',
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        }, 
                        data: data.PorArribar
                    },
                    {
                        name: 'OTROS PROCESOS',
                        type: 'bar',
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },
                        data: data.OtrosProcesos
                    },
                    {
                        name: 'LEVANTES',
                        type: 'bar',
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },
                        data: data.TotalLevantes
                    },
                    

                ]
            };





            Graficahistorico.setOption(option)


        },
        failure: function (response) {
            alert('Error en los datos del historico')
        }
    });




}