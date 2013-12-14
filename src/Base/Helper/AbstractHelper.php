<?php
namespace Base\Helper;

abstract class AbstractHelper {

    public function getModel($name){
        return \Base\Di\Container::getClass($name);
    }

}