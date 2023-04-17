<div id="KpisConfig" class="Hidden layout-px-spacing">
    <div class="account-settings-container layout-top-spacing">
        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div id="work-platforms" class="section work-platforms">
                            <div class="info">
                                <h5 class="">KPIS CONFIGURADOS</h5>
                                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                    <div class="widget-content widget-content-area br-6">
                                        <div class="row float-right">
                                            <div class="container">
                                                <button data-id="AgregarKpi" class="BtnKpi btn btn-primary mb-2 mr-1">Agregar nuevo KPI <i class="ti-plus inline-block text-white  font-22"></i></button>
                                            </div>
                                        </div>
                                        <div class="table-responsive mb-4 mt-4">
                                            <table id="TableKpis" class="table table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Cliente</th>
                                                        <th>Fechas</th>
                                                        <th>Tipo Kpi</th>
                                                        <th>Tipo Transporte</th>
                                                         <th>Tipo Operación</th>
                                                         <th>Tipo cálculo</th>
                                                         <th>Tiempo Meta</th>
                                                         <th>Cumplimiento</th>
                                                         <th>Opciones</th>
                                                    </tr>
                                                </thead>
                                            </table>
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
    <div class="modal" id="ModalKpis" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Configuración de KPIS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x
                    </button>
                </div>
                <form class="Formulario_KPIS" novalidate action="javascript:void(0);">
                    <div class="modal-body">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                        <div class="col-xl-12 col-md-12 col-xs-12 ">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6>Nombre KPI</h6>
                                    <input required type="text" class="form-control" id="NombreKPI" placeholder="EJ: KPI del Cliente">
                                    <div class="invalid-feedback">
                                        Ingrese un nombre!.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Seleccione Cliente</h6>
                                    <select class="custom-select SelectorKpis" id="SelectorClientes" required>
                                    </select>
                                    <div class="invalid-feedback">
                                        Seleccione Cliente!.
                                    </div>
                                </div>
                            </div>
                            <div id="DivDatosKPI" class="Hidden col-xl-12 col-md-12 col-xs-12">
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-4">
                                        <h6>Seleccione Campo fecha inicial</h6>
                                        <select class="form-control SelectorKpis" id="FechaInicialKpi" required>
                                        </select>
                                        <div class="invalid-feedback">
                                            Seleccione campo fecha inicial!.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Seleccione Campo fecha final</h6>
                                        <select class="form-control SelectorKpis" id="FechaFinalKpi" required>
                                        </select>
                                        <div class="invalid-feedback">
                                            Seleccione campo fecha final!.
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <h6>Tipo  KPI?</h6>
                                        <select class="form-control" id="TipoKPI" required>
                                            <option selected value="">Seleccione</option>
                                            <option value="Nacionalizacion">Nacionalizacion</option>
                                            <option value="Facturación">Facturación</option>
                                           <option value="Otro">Otro</option>
                                        </select>
                                           <div class="invalid-feedback">
                                            Tipo KPI!.
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <h6>Instrucción de operación</h6>
                                        <select class="form-control" id="TipoInstruccion" required>
                                          
                                        </select>
                                        <div class="invalid-feedback">
                                            Seleccione Instrucción de operación!.
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <h6>Tipo transporte</h6>
                                        <select class="form-control" id="TipoTransporte" required>
                                            <option selected value="">Seleccione</option>
                                            <option value="Todos">Todos</option>
                                            <option value="Aéreo">Aéreo</option>
                                            <option value="Marítimo">Marítimo</option>
                                            <option value="Terrestre">Terrestre</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Tipo Transporte!.
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <h6>Tipo operación</h6>
                                        <select class="form-control" id="TipoOperacion" required>
                                            <option selected value="">Seleccione</option>
                                            <option value="Todos">Todos</option>
                                            <option value="Descargue Directo">Descargue Directo</option>
                                            <option value="Ordinaria">Ordinaria</option>
                                            <option value="Anticipada">Anticipada</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Tipo operación!.
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <h6>Días para cálculo</h6>
                                        <select class="form-control" id="DiasCalculo" required>
                                            <option value="">Seleccione</option>
                                            <option value="Diascorridos">Días corridos</option>
                                            <option value="DiasHabiles">Días Hábiles</option>
                                            <option value="DiasHabilesConSaba">Días Hábiles con sábados</option>
                                            <option value="HorasCorridas">Horas Corridas</option>
                                            <option value="HorasHabiles">Horas Hábiles</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Ingrese días cálculo!.
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6><span id="TipoCalculoText"></span> Meta</h6>
                                        <input class="form-control" type="number" id="TiempoMeta" step="0.01" min="0" max="100" required>
                                        <div class="invalid-feedback">
                                            Ingrese días!.
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>% cumple KPI</h6>
                                        <input min="0" max="100" class="form-control" type="number" id="PercKpi" required>
                                        <div class="invalid-feedback">
                                            Ingrese porcentaje!.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="DivPruebaKPI" class="Hidden col-xl-12 col-md-12 col-xs-12">
                                <div class="row mb-4">
                                   
                                    <div class="col-md-3">
                                        <h6>Fecha inicial cálculo Kpi</h6>
                                        <input id="RangoFechaInicialKpi" type="text" class="form-control form-control-sm DatePickerkPI">
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Fecha final cálculo Kpi</h6>
                                        <input id="RangoFechaFinalKpi" type="text" class="form-control form-control-sm DatePickerkPI" >
                                    </div>
                                    <div class="col-md-2">
                                        <h6>Limite datos</h6>
                                        <select class="form-control" id="LimiteDatos" required>
                                            <option value="">Seleccione</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>&nbsp;</h6>
                                        <button id="BtnPruebaKPI" type="submit"  class="btnSubmit btn btn-block btn-success mb-2"> PROBAR CONFIGURACIÓN <span class="ti-wand"></span> </button>
                                    </div>
                                </div>
                            </div>
                            <div id="DivResultadosPruebaKPI" class="Hidden col-xl-12 col-md-12 col-xs-12">
                                <div id="ResultadosPruebaDiv" class="row mb-4">

                                </div>
                            </div>

                            <input type="hidden" id="TypePost" value="AgregarKpi">
                            <input type="hidden" id="idKPI" value="NA">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div align="center" class="col-md-12">
                            <button id="BtnGuardarKPI" type="submit" class="btnSubmit btn btn-primary mb-2"> Guardar KPI <span class="ti-save"></span> </button>
                        </div>
                        <!-- <button id="BtnDownloadAnalitics" type="button" class="btn btn-primary"></button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
