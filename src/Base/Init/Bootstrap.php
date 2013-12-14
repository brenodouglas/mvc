<?php
namespace Base\Init;

use App\Module;

abstract class Bootstrap {
	
    private $routes;
    public static $param;
    private $modules;
	private $request;
    public $routesRest;

    public function __construct(){
        $this->modules = $this->getModules();
        $this->initRoute();
        $this->initRoutesRestFull();
        $this->run($this->getUrl());
        $this->request = $this->getRequest();

    }

    public static function url(){
        return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
    }

    public static function getModule(){
        $modules = Module::getModules();
        $url = explode('/', self::url());
        foreach($modules as $key=>$value){
            $keys = str_replace('/',"",$key);
            if($keys == $url[1]){
                return array($key=>ucfirst($value));
            }
        }
        return array("/"=>ucfirst($modules['/']));
    }

    abstract protected function initRoute();
    abstract protected function getModules();
    abstract protected function initRoutesRestFull();

    public function rest($url){
        $array = explode("/", $url);
        
    }

    protected function run($url){
        try{

        //chama o metodo statico de pegar o modulo
        $module = self::getModule();
        //Divide a url em um array
        $info = explode("/", $url);
        $x = 0;
        $urlAtual = "/".$info[1];
        if(array_key_exists($urlAtual,$module) && empty($info[2])){
            $class = 'App\\'.$module[$urlAtual].'\\Controllers\\IndexController';
        } else {
                        //variavel utilizada para caso o modulo seja o admin ele incrementar e aumentar a posição que irá procurar no array

            if(array_key_exists("/",$module)){
                $class = 'App\\'.$module["/"].'\\Controllers\\'.ucfirst($info[1]).'Controller';
            } else {
                $x++;
                $class = 'App\\'.$module[$urlAtual].'\\Controllers\\'.ucfirst($info[2]).'Controller';
            }
        }
        //verifica se a classe existe
        if(class_exists($class)):
            $controller = new $class;

            //verifica se tem dados na url na posição do array que foi formado pelo explode
            if(isset($info[2+$x]) && method_exists($controller, $info[2+$x])):
                $controller->$info[2+$x]();
            elseif(method_exists($controller, 'index')):
                $controller->index();
            else:
                throw new \Exception("Rota incorreta, verifique o endereço da url");
            endif;

        else:
                throw new \Exception("Rota incorreta, verifique o endereço da url");
        endif;
        } catch (\Exception $e){
                require_once '../App/Principal/views/error/404.phtml';
        }
    }
	
	protected function setRoutes(array $routes){
		$this->routes = $routes;
	}
	
	protected function getUrl(){
		return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
	}

    public function getRequest(){
        return new \Base\Controller\Request();
    }
}
