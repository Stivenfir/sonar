<div id="DashPrincipal" class="Hidden layout-px-spacing">
    <input type="hidden" id="BtnHablitarSeleccion">
    <div class="row layout-top-spacing">
        <div class="col-xl-6">
            <div class="col-xl-12 layout-spacing">
                <div class="widget widget-chart-three">
                    <div class="widget-heading">
                        <div class="">
                            <h5 class="TituloFiltro">Filtro</h5>
                        </div>
                        <div class="dropdown  custom-dropdown">
                            <a class="inline-block mr-15" data-toggle="collapse" href="#DivFiltro" aria-expanded="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol id="SeleccionUsuarios" class="breadcrumb">
                            <li class="breadcrumb-item"><a title="BorrarFiltro" href="javascript:void(0);">
                                </a><a href="javascript:void(0);">Tablero Actualizado a</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span id="FechaTablero"></span></li>
                            <li class="breadcrumb-item"><a title="BorrarFiltro" href="javascript:void(0);">
                                </a><a href="javascript:void(0);">Usuario Conectado:</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php echo $_SESSION['UsuarioLogueado']; ?></li>
                        </ol>
                    </nav>
                    <div id="">&nbsp;</div>
                    <p align="center" class="loaderDonaEstados spinner-grow loader-sm"></p>
                    <div id="DivResultadosBusqueda" style="display: none" class="col-xl-12">
                        <div class="searchable-container">
                            <div class="row">
                                <div id="ItemsResultados" class="col-md-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="DivFiltro" style="display: none" class="collapse show row">
                        <div align="center" class="col-xl-7 widget-content">
                            <h4>Seleccione Grupo</h4>
                            <div id="">
                                <div id="" class="avatar--group">
                                    <div id="GrupoDirectores" class="avatar avatar-lg  translateX-axis">
                                        <!--  <img alt="avatar" src="../../dist/assets/img/director.png" id="DirectoresBtn" class="BtnsMenuCircular avatar-title ColorDefault rounded-circle  bs-tooltip" data-original-title="DIRECTORES"> -->
                                        <span id="DirectoresBtn"
                                            class="BtnsMenuCircular avatar-title ColorDefault rounded-circle  bs-tooltip"
                                            data-original-title="DIRECTORES">D</span>
                                        <!-- <img alt="avatar" src="../../dist/assets/img/director.png" class="rounded-circle bs-tooltip" data-original-title="DIRECTORES"/> -->
                                    </div>
                                    <div id="GrupoJefes" class="avatar avatar-lg translateX-axis">
                                        <span id="JefesBtn"
                                            class="BtnsMenuCircular avatar-title ColorDefault rounded-circle  bs-tooltip"
                                            data-original-title="JEFES DE CUENTA">JC</span>
                                        <!-- <img alt="avatar" src="../../dist/assets/img/jefecuenta.png" class="rounded-circle bs-tooltip" data-original-title="JEFES DE CUENTA"/> -->
                                    </div>
                                    <div id="GrupoCoordinadores" class="avatar avatar-lg translateX-axis">
                                        <span id="CoordinadoresBtn"
                                            class="BtnsMenuCircular avatar-title ColorDefault rounded-circle  bs-tooltip"
                                            data-original-title="COORDINADOR DE CUENTA">CC</span>
                                        <!-- <img alt="avatar" src="../../dist/assets/img/coordinador.png" class="rounded-circle bs-tooltip" data-original-title="COORDINADOR DE CUENTA"/> -->
                                    </div>
                                    <div id="GrupoClientes" class="avatar avatar-lg translateX-axis">
                                        <span id="ClientesBtn"
                                            class="BtnsMenuCircular avatar-title ColorDefault rounded-circle  bs-tooltip"
                                            data-original-title="CLIENTES">C</span>
                                        <!-- <img alt="avatar" src="../../dist/assets/img/coordinador.png" class="rounded-circle bs-tooltip" data-original-title="COORDINADOR DE CUENTA"/> -->
                                    </div>
                                </div>
                            </div>
                            <div id="FiltrosSeleccionados">
                            </div>
                        </div>
                        <div class="col-xl-5 widget-content">
                            <h4>Usuarios Seleccionados</h4>
                            <div id="DirectoresSelected"></div>
                            <div id="JefesSelected"></div>
                            <div id="CoordinadorSelected"></div>
                            <div id="ClientesSelected"></div>
                            <div id="DivAplicarFiltro" style="display: none;bottom:0;left:0;">
                                <div id="">&nbsp;</div>
                                <button title="Borrar Filtro"
                                    class="BtnBorrarFiltro btn btn-danger mb-2 mr-2 rounded-circle"> <svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-x-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg></button>
                                <button title="Aplicar Filtro" id="BtnAplicarFiltro"
                                    class=" btn btn-primary mb-2 mr-2 rounded-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-check-circle">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </button>
                                <input type="hidden" id="MostrarSeleccion"
                                    class=" btn btn-primary mb-2 mr-2 rounded-circle">
                            </div>
                        </div>
                        <div class="col-xl-12 widget-content">
                            <hr>
                            <ul class="nav nav-tabs mt-3" id="border-tabs" role="tablist">
                                <li class="nav-item">
                                    <a id="LinkUsuariosPie" class="nav-link active" id="border-home-tab"
                                        data-toggle="tab" href="#PieUsuarios" role="tab" aria-controls="PieUsuarios"
                                        aria-selected="true"><span class="ti-user"> </span>Procesos X Usuarios </a>
                                </li>
                                <li class="nav-item PieCliente">
                                    <a id="LinkClientesPie" class="nav-link " id="border-profile-tab" data-toggle="tab"
                                        href="#PieClientes" role="tab" aria-controls="PieClientes"
                                        aria-selected="false"><span class="ti-truck"> </span>Procesos X Clientes</a>
                                </li>
                            </ul>
                            <div class="tab-content mb-4" id="border-tabsContent">
                                <div class="tab-pane" id="PieUsuarios" role="tabpanel"
                                    aria-labelledby="border-home-tab">
                                    <div class="row">
                                        <div id="PieUsuariosAll" class="col-xl-12">
                                        </div>
                                        <div id="PieUsuariosSinZF" class="col-xl-6">
                                        </div>
                                        <div id="PieUsuariosConZF" class="col-xl-6">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="PieClientes" role="tabpanel"
                                    aria-labelledby="border-profile-tab">
                                    <div id="CargaClientes" class="" style="height:280px;"></div>
                                    <div class="row">
                                        <div class="col text-center">
                                            <div class="n-chk">
                                                <label class="new-control new-checkbox checkbox-warning text-warning">
                                                    <input id="ZonaFrancaCheckC" type="checkbox"
                                                        class="new-control-input">
                                                    <span class="new-control-indicator"></span>ZONA FRANCA
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 widget-content">
                            <div class="widget-heading">
                                <h5 class="">Cierre diario</h5>
                            </div>
                            <div class="row p-4">
                                <div class="col-xl-6 ">
                                    <div class="widget-three text-center">
                                        <div class="widget-five">
                                            <div class="w-content ">
                                                <h5>Operaciones en compromiso</h5>
                                                <div class="">
                                                    <a href="javascript:void(0);" id="TotalProcesos"
                                                        class="BtnVerDetalle task-Compromiso">0</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 ">
                                    <div class="widget-three text-center">
                                        <div class="widget-five">
                                            <div class="w-content ">
                                                <h5>Operaciones Incumplidas</h5>
                                                <div class="">
                                                    <a href="javascript:void(0);" id="TotalProcesos"
                                                        class="BtnVerDetalle task-Incumplidas">0</a>
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

        </div>
        <div class="col-xl-6">
            <div class="col-xl-12 layout-spacing">
                <div class="widget widget-chart-three">
                    <div class="widget-heading">
                        <div class="">
                            <h5 class="">Estado de procesos</h5>
                        </div>
                        <a class="inline-block mr-15" data-toggle="collapse" href="#DivEstadosCompleto"
                            aria-expanded="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                    </div>
                    <p align="center" class="loaderDonaEstados spinner-grow loader-sm"></p>
                    <div id="CantidadTiempos" class="row">
                        <div class="col-xl-6">
                            <div class="widget-three text-center">
                                <div class="widget-five">
                                    <div class="w-content ">
                                        <h5>Total Procesos</h5>
                                        <div class="">
                                            <a href="javascript:void(0);" id="TotalProcesos"
                                                class="BtnVerDetalle task-TotalProcesos">0</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="widget-three text-center">
                                <div class="widget-five">
                                    <div class="w-content ">
                                        <h5>Sin Estado</h5>
                                        <div class="">
                                            <a href="javascript:void(0);" id="SinEstado"
                                                class="BtnVerDetalle task-SinEstado">0</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 mt-2">
                            <div class="widget-three text-center">
                                <div class="widget-five">
                                    <div class="w-content ">
                                        <h5>Fuera de Tiempo Aduana</h5>
                                        <div class="">
                                            <a href="javascript:void(0);" id="FueraTiempo"
                                                class="BtnVerDetalle task-FueraTiempo">0</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 mt-2">
                            <div class="widget-three text-center">
                                <div class="widget-five">
                                    <div class="w-content ">
                                        <h5>Fuera de Tiempo Facturación</h5>
                                        <div class="">
                                            <a href="javascript:void(0);" id="FueraTiempoFact"
                                                class="BtnVerDetalle task-FueraTiempoFact">0</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 mt-2">
                            <div class="widget-three text-center">
                                <div class="widget-five">
                                    <div class="w-content">
                                        <h5>A Tiempo</h5>
                                        <div class="">
                                            <a href="javascript:void(0);" id="ATiempo"
                                                class="BtnVerDetalle task-ATiempo">0</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 mt-2">
                            <div class="widget-three text-center">
                                <div class="widget-five">
                                    <div class="w-content">
                                        <h5>Sin Arribar</h5>
                                        <div class="">
                                            <a href="javascript:void(0);" id="SinArribar"
                                                class="BtnVerDetalle task-SinArribar">0</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 mt-2">
                            <div class="widget-three text-center">
                                <div class="widget-five">
                                    <div class="w-content">
                                        <h5>Zona Franca</h5>
                                        <div class="">
                                            <a href="javascript:void(0);" id="ZonaFranca"
                                                class="BtnVerDetalle task-ZonaFranca">0</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="DivEstadosCompleto" class="collapse show widget-content">
                        <div class="col-xl-12" align="center">
                            <div class="row">
                                <div class="col text-center m-4">
                                    <button disabled="disable" id="AllDetalle" type="button"
                                        class="BtnVerDetalle btn btn-primary btn-rounded mb-2">Ver Detalle</button>
                                </div>
                            </div>
                        </div>
                        <div id="DivEstados" class="row">
                            <div style="display: none" id="ChartEstados" class="col-xl-6"></div>
                            <div style="display: none" id="ChartEstadosZF" class="col-xl-6"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-xl-12">
            <div class="col-xl-12 layout-spacing">
                <div class="widget widget-chart-three">
                    <div class="widget-heading">
                        <div class="">
                            <h5 class="">Evolución de la operación <span id="MesActual"></span></h5>
                        </div>
                        <a class="inline-block mr-15" data-toggle="collapse" href="#DivPrincipalHistorico"
                            aria-expanded="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                    </div>

                    <div style="display: none" class="mt-4 table-responsive" id="table-Totales">

                        <h4 align="center" class="text-primary">Total procesos</h4>
                        <table id="TablaHistorico" class="table table-bordered mb-4" style="width:100%">
                            <tr id="hmtlFechas">
                            </tr>
                            <tr id="hmtlTotalProcesos">
                            </tr>
                        </table>
                        <h4 align="center" class="text-primary">Promedio <b><span id="PromedioHistorico"></span> <span
                                    class="ti-bar-chart"></span></b></h4>
                    </div>
                    <div id="DivPrincipalHistorico" class="collapse show widget-content">
                        <div id="DivHistorico">
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="DivTableroKpis" class="col-xl-12 layout-spacing">
            <div class="widget widget-chart-three">
                <div class="widget-heading">
                    <input type="hidden" id="BtnHiddenKpi" name="">

                    <h5 class="">Tablero de Kpi's</h5>
                    <a class="inline-block mr-15" data-toggle="collapse" href="#DivKpis" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <input type="hidden" id="TipoBtnFiltroKpi" value="Clientes">
                </div>
                <div class="col-xl-12 mt-3 ">
                    <div class="row">
                        <div class="col-xl-3">
                            <div id="" class="mb-4">
                                <input id="RangoParaKPI" class="RangosKpi form-control flatpickr flatpickr-input active"
                                    type="text" placeholder="Selecccione Rango consultar..." readonly="readonly">
                                <div class="input-group-append">

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div id="" class="mb-4">
                                <input id="RangoParaKPIComparar"
                                    class="RangosKpi form-control flatpickr flatpickr-input active" type="text"
                                    placeholder="Selecccione Rango para comparar.." readonly="readonly">
                            </div>
                        </div>


                        <div class="col-xl-2">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ver por: <span id="TextSelectKpi">Clientes</span> <svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-chevron-down">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask"
                                    style="will-change: transform;">
                                    <a class="dropdown-item BtnFiltrarKpis" id="Clientes">Clientes</a>
                                    <a class="dropdown-item BtnFiltrarKpis" id="Usuarios">Usuarios</a>

                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Meses evolucion levantes: <span id="MesesEvoLevantes">3</span> <svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-chevron-down">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask"
                                    style="will-change: transform;">
                                    <a class="dropdown-item BtnFiltrarKpis MesesEvoLevantes">3</a>
                                    <a class="dropdown-item BtnFiltrarKpis MesesEvoLevantes">4</a>
                                    <a class="dropdown-item BtnFiltrarKpis MesesEvoLevantes">6</a>
                                    <a class="dropdown-item BtnFiltrarKpis MesesEvoLevantes">8</a>
                                    <a class="dropdown-item BtnFiltrarKpis MesesEvoLevantes">10</a>
                                    <a class="dropdown-item BtnFiltrarKpis MesesEvoLevantes">12</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-4">
                                <button class="btn btn-primary" id="AplicarRangoKpi" type="button">Aplicar
                                    filtro</button>
                                <button class="btn btn-danger BtnBorrarFiltro" type="button">Borrar filtro</button>
                                <button class="btn btn-warning BtnRegresarKpis Hidden" type="button">Regresar</button>

                            </div>

                        </div>

                    </div>
                </div>
                <div id="DivKpis" class="collapse show widget-content">
                    <p align="center" class="loaderKpi spinner-grow loader-sm"></p>
                    <div id="DatosKpiGeneral" class="table-responsive">
                    </div>
                </div>


                <div id="DivAllKpis" class="Hidden widget-content">
                    <p align="center" class="loaderKpi spinner-grow loader-sm"></p>
                    <div id="HeaderAllKpi" class="table-responsive">
                    </div>
                    <div id="DivDetallesKpi" class="col-xl-12 layout-spacing">
                        <div class="row">
                            <div class="col-xl-6">

                                <div class="row layout-top-spacing">
                                    <div id="ChartKPIDiv2" class="col-xl-12">
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-6">
                                <input type="hidden" id="Idbusqueda">
                                <div id="ListaDOKPI" class="widget-content">
                                    <div class="input-group mb-1">
                                        <select id="ListaKpis" class="form-control"></select>
                                        <div class="input-group-prepend">
                                            <button title="Seleccionar Todos" id="BtnSelectAll" class="btn"
                                                type="button"><span class="ti-check"></span></button>
                                        </div>
                                        <div class="input-group-prepend">
                                            <div id="IdSpanButton"><button title="Descargar en Excell"
                                                    class="btn btn-dark BtnDescargarExcelKPI" id="ExcelKPI"
                                                    type="button"><span class="ti-download"></span></button></div>
                                        </div>
                                    </div>
                                    <!-- <input type="text" id="InputDocImpoNoDOKPI" placeholder="Buscar operaciones" autocomplete="off" class="form-control form-control-sm" aria-label="Small" aria-describedby="inputGroup-sizing-sm"> -->
                                    <div class="input-group-append" id="BtnEnviarKPI">
                                    </div>
                                    <div id="DetalleDOKPI" class="anyClass">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">

                                <div class="row layout-top-spacing">

                                    <div id="ChartKPIDiv" class="col-xl-12">
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