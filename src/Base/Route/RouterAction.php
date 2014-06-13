<?php

namespace Base\Route;

use Base\Route\Interfaces\ActionRoute;

/**
 * Description of RouterAction
 *
 * @author bdouglas
 */
class RouterAction implements ActionRoute
{

    public static function filterFromRoutePosition($position, $filter)
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $info = explode("/", $url);
        if (!isset($info[$position])){
            return false;
        }
        
        return filter_var($info[$position], $filter);
    }

    public static function getFromRoute($name)
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $info = explode("/", $url);
        $verify = false;
        foreach ($info as $dados):
            if ($verify) {
                return $dados;
            }
            if ($dados == $name) {
                $verify = true;
            }
        endforeach;
        
        return false;
    }

    public static function getFromRoutePosition($position)
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $info = explode("/", $url);
        if (!isset($info[$position])){
            return false;
        }

        return $info[$position];
    }

    public static function redirect($url)
    {
        header("Location:$url");
    }

}
