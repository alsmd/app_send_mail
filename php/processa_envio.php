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
        public $status = ['codigo_status' => null,'descricao_status' => ''];
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


    if(!($mensagem->mensagemValida())){
        echo 'mensagem invalida';
        header('Location: ../index.php');
    }

    $mail = new PHPMailer(true);
    try {
        //set linguage
        $mail->setLanguage('pt');
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        //Server settings
        $mail->SMTPDebug = false;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'testes.3b@gmail.com';                 // SMTP username
        $mail->Password = 'Abc123321.';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
       
        //Recipients
        $mail->setFrom('testes.3b@gmail.com', 'flavio silva remetente');
        $mail->addAddress($mensagem->para);     // Add a recipient
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
        $mail->AltBody = 'É necessario utilizar um client que suporte HTML para ter acesso total ao conteudo dessa mensagem';
        $mail->send();
        $mensagem->status['codigo_status'] = 1;
        $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso';
        echo '';
    } catch (Exception $e) {

        $mensagem->status['codigo_status'] = 2;
        $mensagem->status['descricao_status'] = 'Não foi possivel enviar este e-mail! Por favor tente novamente mais tarde. Detalhes do erro:  '.$mail->ErrorInfo ;

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Mail Send</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-2" src="../imgs/logo.png" alt="" width="72" height="72">
            <h2>Send Mail</h2>
            <p class="lead">Seu app de envio de e-mails particular!</p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php if($mensagem->status['codigo_status'] == 1){ ?>
                    <div class="container">
                        <h1 class="display-4 text-success">Sucesso</h1>
                        <p><?= $mensagem->status['descricao_status']; ?></p>
                        <a href="../index.php" class="btn btn-success btn-lh mt-5 text-white">Voltar</a>
                    </div>

                <?php }?>

                <?php if($mensagem->status['codigo_status'] == 2){ ?>
                    <div class="container">
                        <h1 class="display-4 text-danger">Ops!</h1>
                        <p><?= $mensagem->status['descricao_status']; ?></p>
                        <a href="../index.php" class="btn btn-success btn-lh mt-5 text-white">Voltar</a>
                    </div>

                <?php }?>
            </div>
        
        
        </div>


    </div>

    
</body>
</html>