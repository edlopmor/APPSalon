<?php 

    namespace Classes;
    use PHPMailer\PHPMailer\PHPMailer;
class Email{
        public function __construct($email, $nombre, $token)        
        {
            $this->email = $email;
            $this->nombre = $nombre;
            $this->token = $token;
        }

        public function enviarConfirmacion(){
            //Crear el objeto de mail 
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'dfe69aedb966b2';
            $mail->Password = '0eeffed6ca8a3b';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            $mail->setFrom('cuentas@appSalon.com');
            $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
            $mail->Subject=("Confirma tu cuenta");

            
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $contenido="<html>";
            $contenido.= "<p><strong>Hola " .$this->nombre . "</strong> Has creado una cuenta en appsalon, debes confirmarla para poder utilizarla";
            $contenido.= "<p> Presiona aqui: <a href='http://localhost:3000/confirmarCuenta?token=". $this->token ."'>Confirmar cuenta</a> </p>";
            $contenido.= "<p> Si tu no solicitaste esta cuenta, puedes ignorar el mensaje </p>";
            $contenido.="<html>";

            $mail->Body = $contenido;

            $mail->AltBody = "Body alternativo sin html";
            
            //Enviar email;
            $resultado = $mail->send();
            return $resultado;
            

        }
    }