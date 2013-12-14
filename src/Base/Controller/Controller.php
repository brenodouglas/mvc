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
    public function getController();
    public function onBootStrap();
    public function content();
    public function getModel($name);
    public function generateUrl(array $array);
    public function generateUrlPath($dados);
    public function asset($name);
    public function assetPath($name);
    public function redirect($url);
    public function addSession($key, $value);
    public function existeSession($name);
    public function getSession();
    public function getRequest();
    public function getContainer();
    public function addFlashMessage($name,$message);
    public function getFlashMessage($name);
    public function getDoctrine();
}   

