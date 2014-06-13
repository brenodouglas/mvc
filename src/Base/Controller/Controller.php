<?php
namespace Base\Controller;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author bdouglas
 */
interface Controller {
    
    public function getFromRoute($name);
    public function getFromRoutePosition($position);
    public function getController();
    public function onBootStrap();
    public function getModel($name);
    public function redirect($url);
    public function getRequest();
    public function getContainer();
    public function getDoctrine();
    public function getServiceLocator();
    
}   

