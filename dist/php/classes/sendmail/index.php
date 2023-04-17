<?php
require("PHPMailer/class.phpmailer.php");
require("PHPMailer/class.smtp.php");

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPDebug  = 2;
$mail->SMTPSecure = "ssl";
$mail->Host = "mail.americantravel.com.co";
$mail->Port = 465;
$mail->Username = "facturacion@americantravel.com.co";
$mail->Password = "nabo94nabo94";

$mail->From = "villabryan12@gmail.com";
	$mail->FromName = "Tu Nombre";
	$mail->Subject = "Enviar Mail con PHPMailer";
	$mail->AltBody = "";
	$mail->MsgHTML("<h1>Hola Mundo!</h1>");
$mail->AddAttachment("adjunto.txt");

$mail->AddAddress("villabryan12@gmail.com", "Nombre Destinatario");
$mail->IsHTML(true);
$mail->Send();

 if($mail->Send()){
	echo "Enviado";
} else {
	echo "Error no se envio";
}


?>
