<?php 
namespace Base\Di;

use Base\Controller\AbstractActionController as Controller;

class Service {
	
	private $controller;

	public function __construct(Controller $controller){
		$this->controller = $controller;
	}

	public function get($name){
		$service = \App\Module::getService();
		$e = $service[$name]($this->controller);

		if(! isset($e)){
			throw new \Exception("Service não encontrado em App\Module.php [getService()]");
		}
		return $e;
	}

}
