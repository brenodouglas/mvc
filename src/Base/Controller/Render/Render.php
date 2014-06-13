<?php

namespace Base\Controller\Render;

use Base\Controller\Render\Interfaces\Render as RenderInterface;
/**
 * Description of Render
 *
 * @author bdouglas
 */
class Render implements RenderInterface
{
    use \Base\Controller\Render\Traits\ViewHelper;
    
    private $scriptsCollection;
    private $stylesCollection;
    private $content;
    private $html;
    private $controller;
    private $module;
    
    public function __construct()
    {
        $this->scriptsCollection = new \ArrayIterator();
        $this->stylesCollection = new \ArrayIterator();
        $this->registerHelpers();
    }
    
    public function __call($name, $arguments)
    {
        if(isset($this->$name)){
            $object = clone $this->$name;
            return $object();
        }
    }
    
    public function appendScript($path)
    {
        $this->scriptsCollection->append($path);
    }

    public function appendStyle($path)
    {
        $this->stylesCollection->append($path);
    }

    public function content()
    {
        return $this->content;
    }

    public function getScripts()
    {
        $html = "";
        while ($this->scriptsCollection->valid()) :
            $html .= "<script type='text/javascript' src='" . $this->scriptsCollection->current() . "'></script>\n";
            $this->scriptsCollection->next();
        endwhile;

        return $html;
    }

    public function getStyles()
    {
        $html = "";
        while ($this->stylesCollection->valid()) :
            $html .= "<link rel='stylesheet' type='text/css' href='" . $this->stylesCollection->current() . "' />\n";
            $this->stylesCollection->next();
        endwhile;

        return $html;
    }

    public function render($controller, $action, $module, array $vars = array(), $layout = true)
    {   
        $this->controller = $controller;
        $this->module = $module;
        $this->extractVar($vars);
        $this->createContent($action);
        
        $fileLayout = __APP__."/".$this->module."/views/layout.phtml";
        
        if ($layout == true && file_exists($fileLayout)) {
            ob_start();
                require_once $fileLayout;
            $this->html = ob_get_clean();
            echo $this->html;
        } else {
            echo $this->content();
        }
        
    }
    
    private function extractVar(array $var)
    {
        foreach ($var as $key => $value):
            $this->$key = $value;
        endforeach;
    }
    
    public function createContent($action)
    {
        $class = get_class($this->controller);
        $SingleNameController = strtolower(str_replace("App\\" . $this->module . "\\Controllers\\", "", $class));
        $SingleNameClass = str_replace("controller", "", $SingleNameController);
        
        $file = __APP__.'/'. $this->module . '/views/' . $SingleNameClass . '/' . $action . '.phtml';
        
        if(file_exists($file)) {
            ob_start();
                require_once $file;
            $this->content = ob_get_clean();
        } else {
            throw new \Exception("View file no exists for action");
        }
    }
}
