<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <ul class="navbar-nav theme-brand flex-row text-center">
            <!--   <li class="nav-item theme-logo">
                <a href="index.html">
                    <img src="assets/img/globogrande.png" class="navbar-logo" alt="logo">
                </a>
            </li> -->
            <li class="nav-item theme-text">
                <a class="nav-link" href="index.html">
                    ABC REPECEV
                </a>
            </li>
        </ul>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu active">
                <a aria-expanded="true" class="dropdown-toggle" data-toggle="collapse" href="#dashboard">
                    <div class="">
                        <svg class="feather feather-home" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z">
                            </path>
                            <polyline points="9 22 9 12 15 12 15 22">
                            </polyline>
                        </svg>
                        <span>
                            Dashboard
                        </span>
                    </div>
                    <div>
                        <svg class="feather feather-chevron-right" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <polyline points="9 18 15 12 9 6">
                            </polyline>
                        </svg>
                    </div>
                </a>

                <ul class="collapse submenu recent-submenu mini-recent-submenu list-unstyled show" data-parent="#accordionExample" id="dashboard">
                    <li>
                        <a href="javascript:void(0);" class="BtnMenu" id="BtnInicio">
                            Importaciones
                        </a>
                    </li>


                    <li>
                    <?php if ($_SESSION['RolID'] == 1 || $_SESSION['RolID'] == 9410) {?>
                        <a href="javascript:void(0);" class="BtnMenu" id="BtnConfKpi">
                            Configurar KPI'S
                        </a>
                    </li>
                    <?php }?>
                    <!--   <li>
                        <a href="index2.html">
                            EXPORTACIONES
                        </a>
                    </li> -->
                </ul>

            </li>
         
        

            <li class="menu active">
                <a aria-expanded="false" class="dropdown-toggle" href="https://app.powerbi.com/view?r=eyJrIjoiMzM5ZWNkN2UtOGNlOS00OTE2LWI1NmQtNjhlMjFlOTY1NDI1IiwidCI6ImFiZTdiOTZmLWJhNTUtNDdmNS05NzgwLWI3ODViOWE1ZWZkNyIsImMiOjR9" target="blank_">
                    <div class="">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                    <span>
                    Estadística Importaciones
                    </span>
                </div>
            </a>
        </li>

            <li class="menu active">
                <a aria-expanded="false" class="dropdown-toggle" href="https://app.powerbi.com/view?r=eyJrIjoiYWFiNWY0MDktM2RiOS00ZjM4LWFlNjAtOTA2ZWIyNjk2Nzk2IiwidCI6ImFiZTdiOTZmLWJhNTUtNDdmNS05NzgwLWI3ODViOWE1ZWZkNyIsImMiOjR9" target="blank_">
                    <div class="">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                    <span>
                    Estadística Exportaciones
                    </span>
                </div>
            </a>
        </li>
        <li class="menu active">
                <a aria-expanded="false" class="dropdown-toggle" href="https://app.powerbi.com/view?r=eyJrIjoiNWE0ZmY2ODgtZmJkMC00NThjLTk5ZmItZmM3MGVlNTczOTMxIiwidCI6ImFiZTdiOTZmLWJhNTUtNDdmNS05NzgwLWI3ODViOWE1ZWZkNyIsImMiOjR9&pageName=ReportSection" target="blank_">
                    <div class="">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                    <span>
                    Estadística Visado
                    </span>
                </div>
            </a>
        </li>
        <li class="menu active">
                <a aria-expanded="false" class="dropdown-toggle" href="https://abcstorage.sharepoint.com/sites/DEPT/OPER/Seguimiento%20Operativo/Forms/AllItems.aspx" target="blank_">
                    <div class="">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                    <span>
                    Seguimiento Operativo - Todos los items
                    </span>
                </div>
            </a>
        </li>
        
         

            <!--    <li class="menu">
                <a aria-expanded="false" class="dropdown-toggle" href="apps_scrumboard.html">
                    <div class="">
                        <svg class="feather feather-bell" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                            </path>
                            <polyline points="14 2 14 8 20 8">
                            </polyline>
                            <line x1="12" x2="12" y1="18" y2="12">
                            </line>
                            <line x1="9" x2="15" y1="15" y2="15">
                            </line>
                        </svg>
                        <span>
                            ALARMAS
                        </span>
                    </div>
                </a>
            </li>
           
        <li class="menu">
            <a aria-expanded="false" class="dropdown-toggle" href="apps_todoList.html">
                <div class="">
                    <svg class="feather feather-edit" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                        </path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                        </path>
                    </svg>
                    <span>
                        CHECK LIST TAREAS
                    </span>
                </div>
            </a>
        </li>
        <li class="menu">
            <a aria-expanded="false" class="dropdown-toggle" href="apps_calendar.html">
                <div class="">
                    <svg class="feather feather-calendar" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <rect height="18" rx="2" ry="2" width="18" x="3" y="4">
                        </rect>
                        <line x1="16" x2="16" y1="2" y2="6">
                        </line>
                        <line x1="8" x2="8" y1="2" y2="6">
                        </line>
                        <line x1="3" x2="21" y1="10" y2="10">
                        </line>
                    </svg>
                    <span>
                        CALENDARIO
                    </span>
                </div>
            </a>
        </li> -->
        <?php if ($_SESSION['RolID'] == 1 || $_SESSION['RolID'] == 9410) {?>
        <li class="menu">
            <a aria-expanded="true" class="dropdown-toggle" data-toggle="collapse" href="#BtnAdministrador">
                <div class="">
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span>
                        Administrador
                    </span>
                </div>
                <div>
                    <svg class="feather feather-chevron-right" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <polyline points="9 18 15 12 9 6">
                        </polyline>
                    </svg>
                </div>
            </a>
            <ul class="collapse submenu recent-submenu mini-recent-submenu list-unstyled show" data-parent="#accordionExample" id="BtnAdministrador">
                <li class="menu">
                    <a id="BtnAnalitics" aria-expanded="false" class="dropdown-toggle" href="javascript:void(0);">
                        <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        <span>
                            Analítica de accesos
                        </span>
                    </div>
                </a>
            </li>

 <?php }?>
            <!--   <li>
                <a href="index2.html">
                    EXPORTACIONES
                </a>
            </li> -->
        </ul>
    </li>
    <!-- <li class="menu">
        <a aria-expanded="false" class="dropdown-toggle" href="apps_chat.html">
            <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <span>
                MI GRUPO
            </span>
        </div>
    </a>
</li> -->
<!--  <li class="menu">
    <a aria-expanded="false" class="dropdown-toggle" href="apps_chat.html">
        <div class="">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        <span>
            CONFIGURACIONES
        </span>
    </div>
</a>
</li>  -->
</ul>
</nav>
</div>