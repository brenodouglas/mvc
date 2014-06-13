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
		if (! array_key_exists($name, $service)) {
			throw new \Exception("Key invalid - Service não encontrado em App\Module.php [getService()]");
		}

		$e = $service[$name]($this->controller);

		if(! isset($e)){
			throw new \Exception("Service não encontrado em App\Module.php [getService()]");
		}
		return $e;
	}

}
