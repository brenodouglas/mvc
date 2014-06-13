<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Base\Controller\Render\Interfaces;

/**
 *
 * @author bdouglas
 */
interface Render
{
    
    public function content();
    public function render($controller, $action, $module, array $vars = array(), $layout = true);
    public function appendScript($path);
    public function appendStyle($path);
    public function getStyles();
    public function getScripts();
    public function createContent($action);
}
