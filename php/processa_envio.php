<?php 
    class Mensagem{
        private $para;
        private $assunto;
        private $mensagem;

        public function __construct($para,$assunto,$mensagem){
            $this->para = $para;
            $this->assunto = $assunto;
            $this->mensagem = $mensagem;
        }

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
    $mensagem = new Mensagem($_POST['email'],$_POST['assunto'],$_POST['mensagem']);
    echo '<pre>';
    print_r($mensagem);
    echo '</pre>';

    if($mensagem->mensagemValida()){
        echo 'mensagem valida';
    }else {
        echo 'mensagem invalida';

    }



?>