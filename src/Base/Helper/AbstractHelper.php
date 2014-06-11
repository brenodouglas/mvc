<?php
namespace Base\Helper;

use Base\Controller\Doctrine;

abstract class AbstractHelper {

    public function getModel($name){
        return \Base\Di\Container::getClass($name);
    }

    public function getDoctrine()
    {
        return new Doctrine();
    }
    
}