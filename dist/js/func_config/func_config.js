var f3 = flatpickr(document.getElementById('FechaInformeAnalitics'), {
    minDate: '2020-01-01',
    minRange: 1,
    maxRange: 7,
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
    mode: "range",
    onChange: function(selectedDates, dateStr, instance) {
        if (selectedDates.length > 1) {
            var range = instance.formatDate(selectedDates[1], 'U') - instance.formatDate(selectedDates[0], 'U');
            range = range / 86400;
            if (range > 7) {
                const toast = swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });
                toast({
                    type: 'error',
                    title: 'Supera el límite de consulta para el rango',
                    padding: '2em',
                })
                instance.clear();
                $('#BtnDownloadAnalitics').attr('disabled', true);
            } else {
                $('#BtnDownloadAnalitics').attr('disabled', false);
            }
        }
    },
});
$('#BtnAnalitics').on("click", function() {
    UrlManage('Analitics', 'Open');
    OpenModalAnalitics();
});

function OpenModalAnalitics() {
    $('#ModalAnalitics').modal();
}
$('#BtnDownloadAnalitics').on("click", function() {
    var FechaInformeAnalitics = $('#FechaInformeAnalitics').val();
    if (FechaInformeAnalitics == '') {
        const toast = swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            padding: '2em'
        });
        toast({
            type: 'error',
            title: 'Ingrese fecha',
            padding: '2em',
        })
    } else {
        $('#BtnDownloadAnalitics').attr('disabled', true);
        $('.LoaderAnalitics').show();
        var DatosPeticion = {
            'PostMethod': 'DowloadAnalitics',
            'FechaInformeAnalitics': FechaInformeAnalitics,
        };
        $.ajax({
            url: "../../dist/php/controller.php?DowloadAnalitics",
            method: "POST",
            data: DatosPeticion,
            cache: false,
            dataType: 'json',
            success: function(data) {
                $('.LoaderAnalitics').hide();
                $('#BtnDownloadAnalitics').attr('disabled', false);
                var $a = $("<a>");
                $a.attr("href", data.file);
                $("body").append($a);
                $a.attr("download", data.filename);
                $a[0].click();
                $a.remove();
            }
        });
    }
});