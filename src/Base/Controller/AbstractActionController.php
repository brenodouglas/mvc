<?php
namespace Base\Controller;

use Base\Email\PhpMailer;
use App\Module;

abstract class AbstractActionController implements Controller {
	
    protected $view;
    protected $action;
    protected $module;
    protected $layout;
    protected $helper;
    
    public function __construct(){
        
        $this->helper = new \stdClass();
        $this->onBootstrap();
        $this->view = new \stdClass();
        
        $modules = \Base\Mvc\Mvc::getModule();
        
        $this->module = current($modules);
        
        $array = \App\Module::getHelpers();
        
        foreach($array as $var=>$class):
            $this->$var = $class;
        endforeach;
        $this->layout = "layout";
    }

    public function getRequest(){
        return new \Base\Request\Request();
    }
    
    public function getDoctrine() {
        return new Doctrine();
    }
    public function generateUrl(array $string){
        list($module,$controller,$action) = explode(":", current($string));
        $modules = Module::getModules();
        foreach($modules as $key=>$value):
            $url = $value == $module ? $key : '';
        endforeach;
        
        $url .= "/".strtolower($controller)."/".strtolower($action);
        $params = end($string);
        if(is_array($params)){
            foreach ($params as $key=>$value){
                $url .= "/".$key."/".$value;
            }
        }
        return $url;
    }

    public function generateUrlPath($dados){
        list($module,$controller,$action) = explode(":", $dados);
        $modules = Module::getModules();
        $url = "http://".$_SERVER['HTTP_HOST'];

        foreach($modules as $key=>$value):
            $url .= $value == $module ? $key : '';
        endforeach;

        $url .= "/".strtolower($controller)."/".strtolower($action);
        return $url;
    }

    public function asset($name){
        $url = "/".$name;
        return $url;
    }

    public function assetPath($name){
        $url = "http://".$_SERVER['HTTP_HOST'];
        $url .= "/".$name;
        return $url;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function getController() {
        $class = get_class($this);
        $array = explode('\\',$class);
        return end($array);
    }

    public function onBootstrap(){}

    /** 
    * Pegar html do email
    * @param $name String, $varialbes Array
    * @return html renderizado
    */
    public function getBodyEmail($name,array $variables){
        extract($variables);
        ob_start();
            require_once '../App/'.$this->module.'/views/mail/'.$name.'.phtml';
        $file = ob_get_clean();
        
        return $file;
    }

    public function renderMail($action, array $variables){
        $var = (object) $variables;
        
        if(file_exists("../App/".$this->module."/views/layout.phtml")){
            require_once '../App/'.$this->module.'/views/mail/'.$action.'.phtml';
        } else {
            throw new \Exception("Pagina não encontrada em App/{$this->module}/views/mail/{$action}.phtml");
        }      
    }


    
    public function render($action, $layout=true){

        $this->action = $action;
        if($layout == true && file_exists("../App/".$this->module."/views/layout.phtml")){
                require_once '../App/'.$this->module.'/views/'.$this->layout.'.phtml';
        } else {
                $this->content();
        }
    }

    public function content(){

        $class = get_class($this);
        $SingleNameController = strtolower(str_replace("App\\".$this->module."\\Controllers\\","", $class));
        $SingleNameClass = str_replace("controller", "", $SingleNameController);
        $name = '../App/'.$this->module.'/views/'.$SingleNameClass.'/'.$this->action.'.phtml';
        try {
            $view = new RenderView;
            $view->content($name);
            require_once '../App/'.$this->module.'/views/'.$SingleNameClass.'/'.$this->action.'.phtml';
        } catch (Exception $e) {
            require_once '../App/'.$this->module.'/views/error/404.phtml';
        }

    }

    public function getModel($name){
        return \Base\Di\Container::getClass($name);
    }

    public function getFromRoute($name){
        $url = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
        $info = explode("/", $url);
        $verify = false;
        foreach($info as $dados):
            if($verify){
                return $dados;
            }
            if($dados == $name){
                $verify = true;
            }
        endforeach;
        return false;

    }

    public function redirect($url) {
            header("Location:$url");
    }

    public function redirectPath($string){
        list($module,$controller,$action) = explode(":", $string);
        $modules = Module::getModules();
        foreach($modules as $key=>$value):
            $url = $value == $module ? $key : '';
        endforeach;
        $url .= "/".strtolower($controller)."/".strtolower($action);
        header("Location:$url");
    }

    public function addSession($key, $value){
            if(!isset($_SESSION))
                $this->getSession();

            $_SESSION[$key] = $value;
    }

    public function getSession(){
            if(!isset($_SESSION))
                session_start();
            
            return $this;
    }
    
    public function getValueSession($name){
        if(!isset($_SESSION))
                $this->getSession();
        
        return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    }

    public function existeSession($name){
        
            $this->getSession();

        if(isset($_SESSION[$name])){
            return true;
        } else {
            return false;
        }
    }

    public function getContainer(){
        return new \Base\Di\Container();
    }

    
    public function addFlashMessage($name,$message){
        $this->getSession();
        $this->addSession($name,$message);
    }
    public function getFlashMessage($name){
        $this->getSession();
        if(isset($_SESSION[$name])){
            $value = $_SESSION[$name];
            unset($_SESSION[$name]);
        } else {
            return null;
        }
        return $value;
    }
}

