<!-- END MAIN CONTAINER -->
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<?php define('version', md5(time())); ?>
<script src="../../dist/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="../../dist/bootstrap/js/popper.min.js"></script>
<script src="../../dist/bootstrap/js/bootstrap.min.js"></script>
<script src="../../dist/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../../dist/assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
    var ValidateCK = document.getElementById("Mensaje");
    if (ValidateCK) {
        CKEDITOR.replace('Mensaje', {
            language: 'es',
        });
        CKEDITOR.filter.disallow( 'img{*}' );
    }

   
</script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="../../dist/assets/js/custom.js"></script>
<script src="../../dist/assets/js/loader.js"></script>
<script src="../../dist/assets/js/dashboard/dash_1.js"></script>
<script src="../../dist/assets/js/dashboard/dash_2.js"></script>
<script src="../../dist/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="../../dist/assets/js/scrollspyNav.js"></script>
<script src="../../dist/plugins/counter/jquery.countTo.js"></script>
<script src="../../dist/plugins/highlight/highlight.pack.js"></script>
<script src="../../dist/plugins/flatpickr/flatpickr.js"></script>
<script src="../../dist/plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="../../dist/plugins/chartjs/Chart.bundle.js"></script>
<script src="../../dist/assets/js/components/custom-counter.js"></script>
<script src="../../dist/assets/js/html2canvas/html2canvas.js"></script>
<script src="../../dist/plugins/table/datatable/datatables.js"></script>
<script src="../../dist/plugins/table/datatable/custom_miscellaneous.js"></script>
<script src="../../dist/assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>
<script src="../../dist/plugins/googleCharts/loader.js"></script>
<script src="../../dist/plugins/chartjs/Chart.bundle.js"></script>
<script src="../../dist/plugins/echarts/echarts-en.min.js"></script>
<script src="../../dist/plugins/select2/select2.min.js"></script>
<script src="../../dist/plugins/select2/custom-select2.js"></script>
<!-- <script src="../../dist/js/func_dashboard/func_dashboard.js?NoCache=<?php //echo rand(0, 9999); 
                                                                            ?>"></script> -->
<!-- BEGIN PAGE LEVEL DEVELOP SCRIPTS -->
<script src="../../dist/js/main/define_func.js?v=<?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/func_filtro/func_filtro.js?v=<?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/func_dashboard/a_dashboard.js?v=<?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/func_dashboard/b_estado_procesos.js?v=<?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/func_dashboard/c_detalle_operaciones.js?v=<?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/func_dashboard/d_kpis.js?v=<?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/func_dashboard/d_kpis_conf.js?v=<?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/func_dashboard/e_historico.js?v=<?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/func_dashboard/f_mails.js?v=<?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/func_config/func_config.js?v=<?php echo version; ?><?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/func_session/func_session.js?v=<?php echo version; ?>" defer="defer"></script>
<script src="../../dist/js/main/main.js?v=<?php echo version; ?>" defer="defer"></script>