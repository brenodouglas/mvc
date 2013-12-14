<?php 
namespace Base\Email;

class Mailer implements MailInterface {

		/**
	* Endereço do host para smtp
	* @var host String
	*/
	private $host;

	/**
	* Numero da porta para se conectar via SMTP
	* @var port int
	*
	*/
	private $port;

	/**
	* Nome de usuário para envio de email
	* @var username String
	*
	*/
	private $username;

	/**
	* Senha de usuário para envio de email
	* @var password String
	*
	*/
	private $password;
	
	/**
	* Nome de certificado para autenticação - SSL, TSL
	* @var certificado String
	*
	*/
	private $sercure;
	
	/**
	* Endereço de arquivo que vai em anexo
	* @var file String
	*
	*/
	private $file;

	/**
	* @var smtp boolean
	*/
	private $smtp;
	
	/**
	* Corpo da mensagem
	* @var html String
	*
	*/
	private $html;
	
	/**
	* Header para email
	* @var header String
	*/
	private $header = 'Content-type: text/html; charset=utf-8';

	/**
	* Objeto phpMailer
	* @var mailer PhpMailer
	*
	*/
	private $phpMailer;

	public function __construct($host,$port,$username,$password,$secure = ''){
		$this->host = $host;
		$this->port = $port;
		$this->username = $username;
		$this->password = $password;
		$this->secure = $secure;
		$this->phpMailer = new PhpMailer(true);
	}

	public function setHost($host){
		$this->host = $host;
		return $this;
	}

	public function setPort($port){
		$this->port = $port;
		return $this;
	}

	public function setUsername($userName){
		$this->username = $userName;
		return $this;
	}

	public function setPassword($password){
		$this->password = $password;
		return $this;
	}

	public function setSecured($secure){
		$this->sercure = $secure;
		return $this;
	}

	public function setAttach($file){
		$this->file = $file;
		return $this;
	}

	public function isAttach(){
		return $this->file != "" ? true : false ;
	}

	public function isHtml($var){
		$this->phpMailer->IsHTML($var);
		return $this;
	}

	public function isSmtp($var){
		$this->smtp = $var;
		if($var)
			$this->phpMailer->IsSMTP();

		$this->phpMailer->SMTPAuth = $var;
		return $this;
	}


	public function send($body, $subject, $email) {
		if($this->smtp){
			$this->phpMailer->SMTPSecure = $this->secure;  

	        $this->phpMailer->Port  = $this->port; 
	        //Configuração de HOST do SMTP
	        $this->phpMailer->Host       =  $this->host; //Verifique qual o SMTP do seu domínio
	        //Usuário para autênticação do SMTP
	        $this->phpMailer->Username =   $this->username;
	        //Senha para autênticação do SMTP
	        $this->phpMailer->Password =   $this->password; //Sua senha
	        //Titulo do e-mail que será enviado
	        $this->phpMailer->Subject  =   $subject;
	        $this->phpMailer->From = $this->username;
	        $this->phpMailer->FromName = $this->username;
	        
	        if($this->isAttach()){
	        	$this->phpMailer->AddAttachment($this->file);
	        }

	        $this->phpMailer->From = $this->username;
	        $this->phpMailer->AddAddress($email); 
	        $this->phpMailer->Body = $body;
	        $this->phpMailer->AltBody = $this->phpMailer->Body;   
	        //Dispara Email
	        $enviado = $this->phpMailer->Send();

        } else {
        	mail($email, $subject, $body, $this->header);	
        }

	}	


}