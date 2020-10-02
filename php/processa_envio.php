<?php 

    require "../bibliotecas/phpmailer/Exception.php";
    require "../bibliotecas/phpmailer/OAuth.php";
    require "../bibliotecas/phpmailer/PHPMailer.php";
    require "../bibliotecas/phpmailer/POP3.php";
    require "../bibliotecas/phpmailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


    class Mensagem{
        private $para;
        private $assunto;
        private $mensagem;

        public function __get($atributo){
            return $this->$atributo;
        }
        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }
        public function mensagemValida(){
            //
            if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
                return false;
            }else {
                return true;
            }
        }
    }
    $mensagem = new Mensagem();
    $mensagem->para = $_POST['para'];
    $mensagem->assunto = $_POST['assunto'];
    $mensagem->mensagem = $_POST['mensagem'];

    echo '<pre>';
    print_r($mensagem);
    echo '</pre>';

    if(!($mensagem->mensagemValida())){
        echo 'mensagem invalida';
        die();
    }

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'testes.3b@gmail.com';                 // SMTP username
        $mail->Password = 'Abc123321.';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('testes.3b@gmail.com', 'flavio silva remetente');
        $mail->addAddress($mensagem->para, 'flavio silva destinatario');     // Add a recipient
       /*  $mail->addAddress('ellen@example.com');   */             // Name is optional
        $mail->addReplyTo('testes.3b@example.com', 'Information'); //email que sera mandado a mensagem caso o destinatario responda
        /* $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com'); */

        //Attachments
        /* $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');  */   // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $mensagem->assunto;
        $mail->Body    = $mensagem->mensagem;
        $mail->AltBody = $mensagem->mensagem;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Não foi possivel enviar este e-mail! Por favor tente novamente mais tarde';
        echo 'Detalhes do erro: ' . $mail->ErrorInfo;
    }



?>