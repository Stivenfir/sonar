<div class="modal" id="ModalAnalitics" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Descargar Analitics</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x
                </button>
            </div>
            <div class="modal-body">
                <div class="widget-content widget-content-area">
                    <p class="">Fecha de informe</p>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg></span>
                        </div>
                        <input id="FechaInformeAnalitics" type="text" class="form-control" placeholder="Fecha" aria-label="notification" aria-describedby="basic-addon1">
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <p align="center" style="display: none" class="LoaderAnalitics spinner-grow loader-sm"></p>
                <button id="BtnDownloadAnalitics" type="button" class="btn btn-primary">Descargar Archivo</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="ModalDetalleProcesos" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="breadcrumb-four">
                    <ul class="breadcrumb">
                        <li class="active"><a href="javscript:void(0);">
                                <h4 class="text-primary TituloModalPrincipal"></h4>
                            </a>
                        </li>
                        <li class=""><a href="#" class="text-primary  BtnDescargarExcel" id="AllData">
                                <h4 class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary feather feather-download">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg> Descargar Excell</h4>
                            </a>
                        </li>
                        <input type="hidden" id="BtnSelected">
                        <!-- <li><a href="javscript:void(0);"><svg> ... </svg> UI Kit</a></li> -->
                    </ul>
                </div>
                <h6 class="modal-title" id="TituloModal"></h6>
                <input type="hidden" id="EstadoModal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x
                </button>
            </div>
            <div style="display: none" id="MenuZonaFranca">
                <ul class="nav nav-tabs mt-3" id="border-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="border-home-tab" data-toggle="tab" href="#TablaZonaFranca" role="tab" aria-controls="TablaZonaFranca" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive">
                                <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                <rect x="1" y="3" width="22" height="5"></rect>
                                <line x1="10" y1="12" x2="14" y2="12"></line>
                            </svg> Zona Franca</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="border-profile-tab" data-toggle="tab" href="#TablaZFFueraTiempo" role="tab" aria-controls="TablaZFFueraTiempo" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-danger">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg> Fuera de Tiempo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="border-contact-tab" data-toggle="tab" href="#TablaZFATiempo" role="tab" aria-controls="TablaZFATiempo" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-warning">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg> A Tiempo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="border-contact-tab" data-toggle="tab" href="#TablaZFSinArribar" role="tab" aria-controls="TablaZFSinArribar" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg> Sin Arribar</a>
                    </li>
                </ul>
                <div class="tab-content mb-4" id="border-tabsContent">
                    <div class="tab-pane fade show active" id="TablaZonaFranca" role="tabpanel" aria-labelledby="border-home-tab">
                    </div>
                    <div class="tab-pane fade" id="TablaZFFueraTiempo" role="tabpanel" aria-labelledby="border-profile-tab">
                    </div>
                    <div class="tab-pane fade" id="TablaZFATiempo" role="tabpanel" aria-labelledby="border-contact-tab">
                    </div>
                    <div class="tab-pane fade" id="TablaZFSinArribar" role="tabpanel" aria-labelledby="border-contact-tab">
                    </div>
                </div>
            </div>
            <div style="display: none" id="TablaEstados" class="modal-body">
            </div>
            <!--   <div align="center" class="modal-footer">
        <button class="text-center btn btn-rounded btn-primary">Ver Todos</button>
    </div>
-->
        </div>
    </div>
</div>
<!-- MODALES -->
<div class="fixed-headera">
    <div class="modal-header">
        <div class="breadcrumb-four">
            <ul class="breadcrumb">
                <li><a href="javscript:void(0);">
                        <h4 class="TituloModalPrincipal"></h4>
                    </a>
                </li>
                <li class="active"><a href="javscript:void(0);">
                        <h4 class="text-primary TituloModalSecundario"></h4>
                    </a></li>
            </ul>
            <p><small id="TituloGenerico">Mostrando <mark class="CantidadGenerico">-</mark> operaciones</small> </p>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x
        </button>
    </div>
</div>
<div class="modal  fade" id="ModalDetalleProcesosDO" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog fullscreen-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="breadcrumb-four">
                    <ul class="breadcrumb">
                        <li><a href="javscript:void(0);">
                                <h4 class="TituloModalPrincipal"></h4>
                            </a>
                        </li>
                        <li class="active"><a href="javscript:void(0);">
                                <h4 class="text-primary TituloModalSecundario"></h4>
                            </a></li>
                    </ul>
                    <p><small id="TituloGenerico">Mostrando <mark id="CantidadGenerico">-</mark> operaciones</small> </p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x
                </button>
            </div>
            <div class="modal-body">
                <div class="row layout-top-spacing">
                    <div id="ListaDO" align="center" class="col-xl-5 card">
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <button title="Cambiar Lista" id="BtnVerLista" class="btn " type="button"><span class="ti-list"></span></button>
                                <button title="Seleccionar Todo" id="BtnSelectAllDo" class="btn btn-success" type="button"><span class="ti-check-box"></span></button>
                                <button title="Descargar en Excell" class="btn btn-dark BtnDescargarExcel" id="DataFiltro" type="button"><span class="ti-download"></span></button>
                            </div>
                            <input type="text" id="InputDocImpoNoDO" placeholder="Buscar en esta Tabla" autocomplete="off" class="form-control form-control-sm" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            <div class="input-group-append" id="BtnEnviar">
                            </div>
                        </div>
                        <input type="hidden" id="RolID">
                        <input type="hidden" id="CampoInput">
                        <input type="hidden" id="ValorInput">
                        <input type="hidden" id="EstadoInput">
                        <input type="hidden" id="GrupoOperacion">
                        <div id="DetalleDO">
                        </div>
                    </div>
                    <!--      <div id="AlertDivSelectDO"  style="display: none;"  class="col-xl-10 ">
        <div class="alert alert-outline-warning mb-4 " role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">X</button>
        <strong><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="titila text-warning feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Seleccione DO</strong> para actualizar o consultar.
    </div>
</div> -->
                    <div id="InfoDivs" style="display: none;" class="accordion-icons col-xl-7 ">
                        <div id="Informativos" style="display: none;" class="card">
                            <div class="card-header" id="headingTwo3">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="collapsed" data-toggle="collapse" data-target="#AcordionInformacion" aria-expanded="true" aria-controls="AcordionInformacion">
                                        <div class="accordion-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                                <polyline points="10 9 9 9 8 9"></polyline>
                                            </svg></div>
                                        INFORMACIÓN DE LA OPERACIÓN <span id="DOTitulo"></span>
                                        <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg></div>
                                    </div>
                                </section>
                            </div>
                            <div id="AcordionInformacion" class="collapse show" aria-labelledby="headingTwo3" data-parent="#InfoDivs">
                                <div class="card-body">
                                    <div id="DataHtml" class="form-row">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="iconsAccordion" style="display: none;" class="accordion-icons">
                            <div class="card">
                                <div class="card-header" id="headingTwo3">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="collapsed" data-toggle="collapse" data-target="#iconAccordionTwo" aria-expanded="false" aria-controls="iconAccordionTwo">
                                            <div class="accordion-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                </svg></div>
                                            ACTUALIZAR INFORMACIÓN <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg></div>
                                        </div>
                                    </section>
                                </div>
                                <div id="iconAccordionTwo" class="collapse" aria-labelledby="headingTwo3" data-parent="#iconsAccordion">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-6">
                                                <h6 for="TerminalPortuario">Depósito</h6>
                                                <select id="TerminalPortuario" class="selectpicker form-control" data-live-search="true">
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <h6 for="DepositoZonaFranca">Deposito Zona Franca</h6>
                                                <select class="selectpicker form-control" id="DepositoZonaFranca" data-live-search="true">
                                                </select>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <span>&nbsp;</span>
                                            </div>
                                            <div class="col-4 DocImpoNoDocTransp">
                                                <h6 for="DocImpoNoDocTransp">Doc Transporte</h6>
                                                <input id="DocImpoNoDocTransp" type="text" class="form-control form-control-sm" placeholder="Doc Transporte">
                                            </div>
                                            <div class="col-4 DocImpoFechaETA">
                                                <h6 for="DocImpoFechaETA">Fecha ETA</h6>
                                                <input id="DocImpoFechaETA" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 NumeroManifiesto">
                                                <h6 for="NumeroManifiesto">Número Manifiesto</h6>
                                                <input id="NumeroManifiesto" type="text" class="form-control form-control-sm" placeholder="Número Manifiesto">
                                            </div>
                                            <div class="col-4 FechaManifiesto">
                                                <h6 for="FechaManifiesto">Fecha Manifiesto</h6>
                                                <input id="FechaManifiesto" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaConsultaInventario">
                                                <h6 for="FechaConsultaInventario">Fecha Consulta Inventario</h6>
                                                <input id="FechaConsultaInventario" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaReciboDocumentos">
                                                <h6 for="FechaReciboDocumentos">Fecha recibo Docs DO</h6>
                                                <input id="FechaReciboDocumentos" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaReciboDocs">
                                                <h6 for="FechaReciboDocs">Fecha recibo Docs Nac</h6>
                                                <input id="FechaReciboDocs" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaReciboDocsPuerto">
                                                <h6 for="FechaReciboDocsPuerto">Fecha recibo Docs Puerto</h6>
                                                <input id="FechaReciboDocsPuerto" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaSolicitudAnticipo">
                                                <h6 for="FechaSolicitudAnticipo">Fecha Solicitud Anticipo</h6>
                                                <input id="FechaSolicitudAnticipo" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaReciboAnticipo">
                                                <h6 for="FechaReciboAnticipo">Fecha Recibo Anticipo</h6>
                                                <input id="FechaReciboAnticipo" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaFormulario">
                                                <h6 for="FechaFormulario">Fecha Formulario (FFMM) </h6>
                                                <input id="FechaFormulario" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaEntregaDocumentosDespacho">
                                                <h6 for="FechaEntregaDocumentosDespacho">F Entrega Docs Despacho</h6>
                                                <input id="FechaEntregaDocumentosDespacho" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaDespacho">
                                                <h6 for="FechaDespacho">Fecha Despacho</h6>
                                                <input id="FechaDespacho" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaEntregaApoyoOperativo">
                                                <h6 for="FechaEntregaApoyoOperativo"><small>Fecha Entrega Apoyo Operativo</small></h6>
                                                <input id="FechaEntregaApoyoOperativo" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaDevolucionFacturacion">
                                                <h6 for="FechaDevolucionFacturacion"><small>Fecha Devolución Contabilidad</small></h6>
                                                <input id="FechaDevolucionFacturacion" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-4 FechaEntregaDoDevolucionFacturacion">
                                                <h6 for="FechaEntregaDoDevolucionFacturacion"><small>Fecha Devolución a Facturación</small></h6>
                                                <input id="FechaEntregaDoDevolucionFacturacion" type="text" class="form-control form-control-sm DatePicker">
                                            </div>
                                            <div class="col-12 ObsSeguimiento ">
                                                <h6 for="ObsSeguimiento">Observaciones Seguimiento operativo</h6>
                                                <textarea id="ObsSeguimiento" rows="5" class="form-control form-control-sm" aria-label="With textarea" placeholder="Observaciones"></textarea>
                                            </div>
                                            <div class="col-6 ObsSeguimiento">
                                                <h6 for="ObsSeguimiento">Observaciones Cliente</h6>
                                                <textarea id="ObsCliente" rows="5" class="form-control form-control-sm" aria-label="With textarea" placeholder="Observaciones Cliente"></textarea>
                                            </div>
                                            <div class="col-6 ObsSeguimiento   mb-4">
                                                <h6 for="ObsSeguimiento">Observaciones Bitacora</h6>
                                                <textarea id="ObsBitacora" rows="5" class="form-control form-control-sm" aria-label="With textarea" placeholder="Observaciones Bitacora"></textarea>
                                            </div>
                                            <div align="center" class="col-12">
                                                <div class="col-xl-6" align="center">
                                                    <div class="row">
                                                        <div class="col text-center">
                                                            <button id="BtnActualizarDatos" class="btn btn-block btn-primary"><span id="TexBtnGuardar">Guardar Cambios<span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo3">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="collapsed" data-toggle="collapse" data-target="#iconAccordionTrhee" aria-expanded="false" aria-controls="iconAccordionTrhee">
                                            <div class="accordion-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="12" y1="18" x2="12" y2="12"></line>
                                                    <line x1="9" y1="15" x2="15" y2="15"></line>
                                                </svg></div>
                                            TAREAS DEL DO <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg></div>
                                        </div>
                                    </section>
                                </div>
                                <div id="iconAccordionTrhee" class="collapse" aria-labelledby="headingTwo3" data-parent="#iconsAccordion">
                                    <div class="card-body">
                                        <div class="form-row">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal  fade" id="ModalCrearCorreo" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Envio de notificaciones</h5>
                    <button type="button" class="close CancelCorreo">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="widget-content">
                        <p class="">Asunto Notificación:</p>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                    </svg></span>
                            </div>
                            <input id="Asunto" type="text" class="form-control" placeholder="Asunto Notificación:" aria-label="notification" aria-describedby="basic-addon1">
                        </div>
                        <p class="">Mensaje de la Notificación:  </p>
                        <textarea id="Mensaje" name="Mensaje" class="form-control"></textarea>
                        <button id="ClearTextArea" class="btn btn-dark btn-sm">Limpiar cuadro de mensaje</button>
                        <p class="">Personal a Notificar:</p>
                        <div class="row layout-top-spacing m-2">
                            <div class="n-chk">
                                <label class="new-control new-checkbox checkbox-success text-primary">
                                    <input id="DirectoresCheck" type="checkbox" class="new-control-input" checked>
                                    <span class="new-control-indicator"></span>Directores
                                </label>
                            </div>
                            <div class="n-chk">
                                <label class="new-control new-checkbox checkbox-primary text-primary">
                                    <input id="JefesCheck" type="checkbox" class="new-control-input" checked>
                                    <span class="new-control-indicator"></span>Jefes de Cuenta
                                </label>
                            </div>
                            <div class="n-chk">
                                <label class="new-control new-checkbox checkbox-info text-primary">
                                    <input id="CoordinadoresCheck" type="checkbox" class="new-control-input" checked>
                                    <span class="new-control-indicator"></span>Coordinadores
                                </label>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button id="BtnSendNotifysDO" type="button" class="btn btn-primary">Enviar Alertas</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalCrearCierre" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Compromiso de cierre diario</h5>
                    <button type="button" class="close CancelCierre">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="widget-content">
                    <p class="">Fecha compromiso  </p>
                    <input id="FechaCompromiso" type="text" class="form-control form-control-sm DatePickeCierre flatpickr-input active" readonly="readonly">
                    <p class="">Estado al que se compromete  </p>
                        <select id="EstadoCalculadoFuturo"  class="form-control">
                        </select>
                        <p class="">Observación del compromiso de  cierre:  </p>
                        <textarea id="ComentarioCierre" name="Mensaje" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="BtnGeneraCierreDiario" type="button" class="btn btn-primary">Generar cierre diario</button>
                </div>
            </div>
        </div>
    </div>
