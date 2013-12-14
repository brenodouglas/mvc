<?php
namespace Base\Mvc;

use Base\Init\Bootstrap;
use App\Module;

class Mvc extends Bootstrap {

	private static $con;

	protected function initRoute() {
		
	}


	protected function getModules() {
		return Module::getModules();
	}

	protected function initRoutesRestFull(){
		$this->routesRest = array(
			'index' => array(
				'_controller' => "Rest",
				'_route' 	  => '/index/:token/:id'
			),
			'post'  => array(
				'_controller' => 'Post',
				'_route'	  => '/post/:token/:dataImage'
			),
		);
	}

	public static function getDb(){
		$database = Module::dbConfig();
		try{
		if(!isset(self::$con)){
			foreach ($database as $param) {
				self::$con = new \PDO($param['driver'].":host=".$param['host'].";dbname=".$param['dbname'] , $param['user'] , $param['password']);
			}
		}
		return self::$con;
		} catch(\PDOException $e){
			echo $e->getMessage();
		}
	}
}