 $(document).ready(function() {
     var togglePassword = document.getElementById("toggle-password");
     var formContent = document.getElementsByClassName('form-content')[0];
     var getFormContentHeight = formContent.clientHeight;
     var formImage = document.getElementsByClassName('form-image')[0];
     if (formImage) {
         var setFormImageHeight = formImage.style.height = getFormContentHeight + 'px';
     }
     if (togglePassword) {
         togglePassword.addEventListener('click', function() {
             var x = document.getElementById("password");
             if (x.type === "password") {
                 x.type = "text";
             } else {
                 x.type = "password";
             }
         });
     }
     $("#LoginBTN").click(function() {
         var username = $("#username").val();
         var password = $("#password").val();
         var DatosPeticion = {
             'PostMethod': 'LoginFunc',
             'username': username,
             'password': password,
         };
         $.ajax({
             url: "../../dist/php/controller.php?LoginForm",
             method: "POST",
             data: DatosPeticion,
             cache: false,
             dataType: 'json',
             beforeSend: function() {
                 $('.spinner-grow').show();
                 $('#LoginBTN').prop('disabled', true);
                 $('#TitleButton').html('VALIDANDO CREDENCIALES');
             },
             success: function(data) {
                
                 $('.spinner-grow').hide();
                 
                 if (data.Success) {
                    $('#TitleButton').html('INGRESANDO...');
                 	document.location.href = '../';
                 } else {
                    $('#TitleButton').html('INGRESAR');
                     $('#LoginBTN').prop('disabled', false);
                     swal({
                         title: 'Error en los datos de acceso',
                         type: 'error',
                         html: data.Error,
                         showCloseButton: true,
                         confirmButtonText: '<i class="flaticon-checked-1"></i> Aceptar!',
                         padding: '2em'
                     })
                 }
             }
         });
     })
 });