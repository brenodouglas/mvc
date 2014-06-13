<?php
namespace Base\Di;

use Base\Mvc\Mvc;
use Base\Email\Mailer;

class Container {
	
	public static function getClass($name){
        $strClass = "App\\{$name}";
		$class = new $strClass(\Base\Mvc\Mvc::getDb());
		return $class;
	}

	public static function getPagination()
	{
		return new \App\Principal\Helper\Pagination(\Base\Mvc\Mvc::getDb());
	}

	public function getEmail($name) {
		$array = \App\Module::getEmails();
		$mailer = new Mailer($array[$name]['host'],$array[$name]['port'],$array[$name]['username'],$array[$name]['password'],$array[$name]['secure']);
		$mailer->isSmtp($array[$name]['transport_smtp']);
		return $mailer;
	}
}
