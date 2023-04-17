 $(document).ready(function() {
     var IDLE_TIMEOUT = 100; //seconds
     var _idleSecondsCounter = 0;
     document.onclick = function() {
         _idleSecondsCounter = 0;
     };
     document.onmousemove = function() {
         _idleSecondsCounter = 0;
     };
     document.onkeypress = function() {
         _idleSecondsCounter = 0;
     };
     window.setInterval(CheckIdleTime, 10000);

     function CheckIdleTime() {
         _idleSecondsCounter++;
      
         var oPanel = document.getElementById("SecondsUntilExpire");
         if (oPanel) oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
         if (_idleSecondsCounter >= IDLE_TIMEOUT) {
             swal({
                 title: 'Su sesión ha caducado',
                 text: 'por seguridad e inactividad en el sistema se ha cerrado la sesión',
                 type: 'info',
                 allowOutsideClick: false,
                 showCancelButton: false,
                 confirmButtonText: 'Volver a ingresar',
                 padding: '2em'
             }).then(function(result) {
                 if (result.value) {
                     document.location.href = "../login/salir.php";
                 }
             })
         }
     }
  
 });