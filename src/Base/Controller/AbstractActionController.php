<?php

namespace Base\Controller;

use Base\Email\PhpMailer;
use App\Module;
use Base\Route\RouterAction;
use Base\Controller\Render\Render;

abstract class AbstractActionController implements Controller
{

    protected $view;
    protected $action;
    protected $module;
    protected $render;

    public function __construct()
    {
        $this->onBootstrap();
        $this->helper = new \stdClass();
        $this->view = new \stdClass();
        $this->module = current(\Base\Mvc\Mvc::getModule());
        $this->render = new Render();
    }

    public function getRequest()
    {
        return new \Base\Request\Request();
    }

    public function getDoctrine()
    {
        return new Doctrine();
    }
    
    
    public function getController()
    {
        $class = get_class($this);
        $array = explode('\\', $class);
        return end($array);
    }
    
    public function generateUrl(array $array)
    {
        return (new Render())->generateUrl($array);
    }
    
    public function onBootstrap(){}
    
    public function render($action, array $vars = array(), $layout = true)
    {
        $this->render->render($this, $action, $this->module, $vars, $layout);
    }

    public function getModel($name)
    {
        return \Base\Di\Container::getClass($name);
    }
    
    public function getFromRoute($name)
    {
        return RouterAction::getFromRoute($name);
    }

    public function getFromRoutePosition($position)
    {
       return RouterAction::getFromRoutePosition($position);
    }

    public function redirect($url)
    {
        return RouterAction::redirect($url);
    }

    public function getContainer()
    {
        return new \Base\Di\Container();
    }
    
    public function getServiceLocator()
    {
        return new \Base\Di\Service($this);
    }
    
}
