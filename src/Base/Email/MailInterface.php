<?php
namespace Base\Email;

interface MailInterface {

	
	public function __construct($host,$port,$username,$password,$secure = '');
	public function setHost($host);
	public function setPort($port);
	public function setUserName($userName);
	public function setPassword($password);
	public function setSecured($sercure);
	public function setAttach($file);
	public function isAttach();
	public function isHtml($var);
	public function isSmtp($var);
	public function send($body, $subject,$email);

}