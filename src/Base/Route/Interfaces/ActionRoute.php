<?php

namespace Base\Route\Interfaces;

/**
 *
 * @author bdouglas
 */
interface ActionRoute
{
    public static function getFromRoute($param);
    public static function getFromRoutePosition($position);
    public static function filterFromRoutePosition($position, $filter);
    public static function redirect($url);
}
