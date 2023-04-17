function DetalleDOSearch() {
   
}

$('body').on('keyup', '#InputDocImpoNoDO', function (event) {
    var count = $("#InputDocImpoNoDO").val().length;
    var InputDocImpoNoDO = $("#InputDocImpoNoDO").val();
    var rex = new RegExp($(this).val(), 'i');
    $('.Data .items').hide();
    $('.Data .items').filter(function() {
        return rex.test($(this).text());
    }).show();
});


function HabilitarSelectDO() {
    $("#AlertDivSelectDO").show();
    $("#InfoDivs").hide();
    $('.BtnSelectDO').on("click", function() {
        var ID = $(this).attr('id');
        PeticionDO(ID);
    });
}

function PeticionDO(ID, DoSelected = 'NO') {
    var DatosPeticion = {
        'PostMethod': 'SelectDO',
        'ID_DO': ID,
        'DoSelected': DoSelected
    };
    $.ajax({
        url: "../../dist/php/controller.php?SelectDO",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        dataType: 'json',
        beforeSend: function() {
            $("#Informativos").removeClass("animated pulse");
            $("#iconsAccordion").hide();
            BlankFields();
        },
        success: function(data) {
            var EstadoModal = $('#EstadoModal').val();
            $("#AlertDivSelectDO").hide();
            $("#InfoDivs").show();
            if (data.HideDiv == false) {
                BlockFields(data.EstadoCalculado, 1);
                $("#Informativos").show();
                $("#iconsAccordion").show();
                $("#Informativos").addClass("animated pulse");
                $('#DOTitulo').text(data.DocImpoNoDO);
                $('#DataHtml').html(data.DataHtml);
                $('#DocImpoNoDocTransp').val(data.DocImpoNoDocTransp);
                $('#DocImpoFechaETA').val(data.DocImpoFechaETA);
                $('#FechaManifiesto').val(data.FechaManifiesto);
                $('#FechaConsultaInventario').val(data.FechaConsultaInventario);
                $('#FechaDespacho').val(data.FechaDespacho);
                // $('#ObsSeguimiento').val(data.ObsSeguimiento);
                // $('#ObsCliente').val(data.ObsrvCliente);
                // $('#ObsBitacora').val(data.ObsrvBitacora);
                $('#DocImpoNoDO').html(data.DocImpoNoDO);
                $('#DocImpoNoDoCliente').html(data.DocImpoNoDoCliente);
                $('#NumeroManifiesto').val(data.NumeroManifiesto);
                $('#FechaEntregaDocumentosDespacho').val(data.FechaEntregaDocumentosDespacho);
                $('#FechaFormulario').val(data.FechaFormulario);
                $('#FechaEntregaApoyoOperativo').val(data.FechaEntregaApoyoOperativo);
                $('#FechaDevolucionFacturacion').val(data.FechaDevolucionFacturacion);
                $('#FechaEntregaDoDevolucionFacturacion').val(data.FechaEntregaDoDevolucionFacturacion);
                $('#FechaReciboDocs').val(data.FechaReciboDocs);
                $('#FechaSolicitudAnticipo').val(data.FechaSolicitudAnticipo);
                $('#FechaReciboAnticipo').val(data.FechaReciboAnticipo);
                $('#FechaReciboDocumentos').val(data.FechaReciboDocumentos);
                $('#FechaReciboDocsPuerto').val(data.FechaReciboDocsPuerto);
                SelectoresDepTerminal(data.DepositoZonaFranca, data.TerminalPortuario);
                $("#DocImpoNoDocTransp").attr('readonly', false);
                $("#NumeroManifiesto").attr('readonly', false);
            } else {
                BlockFields(EstadoModal, 2);
                SelectoresDepTerminal(null, null);
                $("#iconsAccordion").show();
                $("#Informativos").hide();
                $("#DocImpoNoDocTransp").attr('readonly', true);
                $("#NumeroManifiesto").attr('readonly', true);
                BlankFields();
            }
        }
    });
}
$("#BtnActualizarDatos").click(function() {
    var DocImpoNoDocTransp = $('#DocImpoNoDocTransp').val();
    var DocImpoFechaETA = $('#DocImpoFechaETA').val();
    var FechaManifiesto = $('#FechaManifiesto').val();
    var FechaConsultaInventario = $('#FechaConsultaInventario').val();
    var FechaDespacho = $('#FechaDespacho').val();
    var NumeroManifiesto = $('#NumeroManifiesto').val();
    var ParcialNumero = $('#ParcialNumero').val();
    var FechaEntregaDocumentosDespacho = $('#FechaEntregaDocumentosDespacho').val();
    var FechaFormulario = $('#FechaFormulario').val();
    var FechaEntregaApoyoOperativo = $('#FechaEntregaApoyoOperativo').val();
    var FechaDevolucionFacturacion = $('#FechaDevolucionFacturacion').val();
    var FechaEntregaDoDevolucionFacturacion = $('#FechaEntregaDoDevolucionFacturacion').val();
    var DepositoZonaFranca = $('#DepositoZonaFranca').val();
    var TerminalPortuario = $('#TerminalPortuario').val();
    var ObsSeguimiento = $('#ObsSeguimiento').val();
    var ObsCliente = $('#ObsCliente').val();
    var ObsBitacora = $('#ObsBitacora').val();
    var FechaReciboDocs = $('#FechaReciboDocs').val();
    var FechaSolicitudAnticipo = $('#FechaSolicitudAnticipo').val();
    var FechaReciboAnticipo = $('#FechaReciboAnticipo').val();
    var FechaReciboDocumentos = $('#FechaReciboDocumentos').val();
    var FechaReciboDocsPuerto = $('#FechaReciboDocsPuerto').val();
    var DatosPeticion = {
        'PostMethod': 'ActualizarDOS',
        'DocImpoNoDocTransp': DocImpoNoDocTransp,
        'DocImpoFechaETA': DocImpoFechaETA,
        'FechaManifiesto': FechaManifiesto,
        'FechaConsultaInventario': FechaConsultaInventario,
        'FechaDespacho': FechaDespacho,
        'NumeroManifiesto': NumeroManifiesto,
        'ParcialNumero': ParcialNumero,
        'FechaEntregaDocumentosDespacho': FechaEntregaDocumentosDespacho,
        'FechaFormulario': FechaFormulario,
        'FechaEntregaApoyoOperativo': FechaEntregaApoyoOperativo,
        'FechaDevolucionFacturacion': FechaDevolucionFacturacion,
        'FechaEntregaDoDevolucionFacturacion': FechaEntregaDoDevolucionFacturacion,
        'DepositoZonaFranca': DepositoZonaFranca,
        'TerminalPortuario': TerminalPortuario,
        'ObsSeguimiento': ObsSeguimiento,
        'ObsCliente': ObsCliente,
        'ObsBitacora': ObsBitacora,
        'FechaReciboDocs': FechaReciboDocs,
        'FechaSolicitudAnticipo': FechaSolicitudAnticipo,
        'FechaReciboAnticipo': FechaReciboAnticipo,
        'FechaReciboDocumentos': FechaReciboDocumentos,
        'FechaReciboDocsPuerto': FechaReciboDocsPuerto
    };
    swal({
        title: 'Esta seguro de guardar?',
        text: "Se actualizarán todos los DO seleccionados",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Actualizar',
        padding: '2em'
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: "../../dist/php/controller.php?ActualizarDOS",
                method: "POST",
                data: DatosPeticion,
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $("#BtnActualizarDatos").attr('disabled', false);
                    $('#BtnActualizarDatos').html(' <h4 class="text-white"><div class="spinner-border text-white align-self-center loader-sm "></div>Aplicando cambios...</h4>');
                },
                success: function(data) {
                    $('#BtnActualizarDatos').html('Guardar Cambios');
                    $("#BtnActualizarDatos").attr('disabled', false);
                    if (data.Success) {
                        if (data.Actualizados == 1) {
                            swal({
                                title: 'Actualizado correctamente',
                                type: 'success',
                                html: '<h6>Actualizó correctamente la Operación</h6>',
                                showCloseButton: true,
                                confirmButtonText: '<i class="flaticon-checked-1"></i> Aceptar!',
                                padding: '2em'
                            });
                            PeticionDO(data.FirstDO, 'yes');
                        } else {
                            swal({
                                title: 'Actualizados correctamente',
                                type: 'success',
                                html: '<h6>Actualizó correctamente: ' + data.Actualizados + ' Operaciones</h6>',
                                showCloseButton: true,
                                confirmButtonText: '<i class="flaticon-checked-1"></i> Aceptar!',
                                padding: '2em'
                            });
                        }
                    } else {
                        swal({
                            title: 'Existen Errores en la petición',
                            type: 'error',
                            html: data.Errores,
                            showCloseButton: true,
                            showCancelButton: true,
                            focusConfirm: false,
                            confirmButtonText: '<i class="flaticon-checked-1"></i> Aceptar!',
                            padding: '2em'
                        })
                    }
                }
            });
        }
    })
});
$('#BtnVerLista').on('click', (evt) => {
    var Campo = $('#CampoInput').val();
    var Valor = $('#ValorInput').val();
    var Estado = $('#EstadoInput').val();
    $(evt.currentTarget).toggleClass('btn-primary');
    OrdenarDivs(Campo, Valor, Estado);
});

function OrdenarDivs(Campo, Valor, Estado) {
    if ($('#BtnVerLista').hasClass('btn-primary')) {
        $('#ListaDO').removeClass('col-xl-5');
        $('#ListaDO').addClass('col-xl-12');
        $('#InfoDivs').hide();
        var Lista = 'SI';
    } else {
        $('#InfoDivs').removeClass('col-xl-12');
        $('#InfoDivs').addClass('col-xl-7');
        $('#ListaDO').removeClass('col-xl-12');
        $('#ListaDO').addClass('col-xl-5');
        $('#InfoDivs').show();
        var Lista = 'NO';
    }
    SelectDetalleDO(Campo, Valor, Estado, Lista);
}

function SelectDetalleDO(Campo, Valor, Estado, Lista, CampoSort = 'DocImpoID', TipoSort = 'ASC') {
    var GrupoOperacion = $('#GrupoOperacion').val();
    var DatosPeticion = {
        'PostMethod': 'DetalleDO',
        'Campo': Campo,
        'Valor': Valor,
        'Estado': Estado,
        'Lista': Lista,
        'GrupoOperacion': GrupoOperacion,
        'CampoSort': CampoSort,
        'TipoSort': TipoSort,
    };
    $.ajax({
        url: "../../dist/php/controller.php?DetalleDO",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        dataType: 'json',
        beforeSend: function() {
            $('#DetalleDO').html('<p align="center"  class="spinner-border spinner-border-reverse align-self-center loader-sm text-primary"></p>');
            $('#CantidadGenerico').html('-');
            $('#DataHtml').html('');
            $('#DataHtml').html('');
            $("#iconsAccordion").hide();
            $("#Informativos").hide();
            $('#ListaDO').show();
        },
        success: function(data) {
            $('#DetalleDO').html(data.html);
            $('#CantidadGenerico').html(data.Cantidad);
            DetalleDOSearch();
            SelectorMasivo();
            $("#BtnEnviar").html("");
            SortData(Campo, Valor, Estado, Lista);
            if (Lista == 'NO') {
                $('#ListaDOTable').removeClass('TableFixeada');
                $('#ListaDOTable').addClass('TableFixeadaSimple');
                $('#DetalleDOSearch').hide();
                $('#TituloBusqueda').hide();
                $('#TituloGenerico').show();
                $("#Informativos").hide();
                $("#AlertDivSelectDO").show();
                $("#InfoDivs").hide();
                HabilitarSelectDO();
                HabilitarSelectDOMail();
            } else {
                $('#ListaDOTable').removeClass('TableFixeadaSimple');
                $('#ListaDOTable').addClass('TableFixeada');
                HabilitarSelectDOMail();
            }
        }
    });
}
$('#BtnHablitarSeleccion').on("click", function() {
    SeleccionarDOSearch();
});

function SeleccionarDOSearch() {
    $('.BtnsItemSearchDO').on("click", function() {
        var ValueSeleccionado = $(this).attr('id');
        var DoSeleccionado = $(this).data('campo');
        PeticionDO(ValueSeleccionado, 'yes');
        $(".TituloModalPrincipal").text('Mostrando DO Seleccionado:')
        $("#CantidadGenerico").text(1)
        $(".TituloModalSecundario").text(DoSeleccionado)
        OpenModalDetalle();
        $('#ListaDO').hide();
        $('#InfoDivs').removeClass('col-xl-7');
        $('#InfoDivs').addClass('col-xl-12');
    });
}

function SortData(Campo, Valor, Estado, Lista) {
    $(".BtnSort").click(function(event) {
        event.preventDefault();
        CampoSort = $(this).attr('id');
        if ($('#' + CampoSort).hasClass('ASC')) {
            var TipoSort = 'ASC';
        } else {
            var TipoSort = 'DESC';
        }
        SelectDetalleDO(Campo, Valor, Estado, Lista, CampoSort, TipoSort);
    });
}
$(".BtnDescargarExcel").click(function(event) {
    var Campo = $('#CampoInput').val();
    var Valor = $('#ValorInput').val();
    var Estado = $('#EstadoInput').val();
    var BtnSelected = $('#BtnSelected').val();
    var GrupoOperacion = $('#GrupoOperacion').val();
    var GrupoPrincipal = $('.GrupoPrincipal').text();
    var ConsultaDownload = $('#ConsultaDownload').val();
    TipoBtn = $(this).attr('id');
    var DatosPeticion = {
        'PostMethod': 'ExportarFile',
        'Campo': Campo,
        'Valor': Valor,
        'Estado': Estado,
        'TipoBtn': TipoBtn,
        'BtnSelected': BtnSelected,
        'GrupoOperacion': GrupoOperacion,
    };
    $.ajax({
        url: "../../dist/php/controller.php?ExportarFile",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        dataType: 'json',
        beforeSend: function() {
            if (TipoBtn == 'AllData') {
                $('#' + TipoBtn).html(' <h4 class="text-primary"><div class="spinner-border text-primary align-self-center loader-sm "></div>Generando Archivo</h4>');
            } else {
                $('#' + TipoBtn).html('<div class="spinner-border text-white align-self-center loader-sm "></div>');
            }
        },
        success: function(data) {
            if (TipoBtn == 'AllData') {
                $('#' + TipoBtn).html(' <h4 class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> Descargar Excell</h4>');
            } else {
                $('#' + TipoBtn).html('<span class="ti-download"></span>');
            }
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", data.filename);
            $a[0].click();
            $a.remove();
        }
    });
});
$('#ModalDetalleProcesosDO').on('scroll', function() {
    var threshold = 60;
    if ($('#ModalDetalleProcesosDO').scrollTop() > threshold) {
        $('.fixed-headera').addClass('affixed');
    } else {
        $('.fixed-headera').removeClass('affixed');
    }
});
$('#ModalDetalleProcesosDO').on('hide.bs.modal', function(e) {
    $('.fixed-headera').removeClass('affixed');
});
$('.fixed-headera button').click(function() {
    $('#ModalDetalleProcesosDO').modal('hide');
});