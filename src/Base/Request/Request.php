<?php

namespace Base\Request;

class Request implements RequestInterface
{

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == "POST" ? true : false;
    }

    public function getPost()
    {
        return $_POST;
    }

    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] == "GET" ? true : false;
    }

    public function getPostFromName($name)
    {
        return $_POST[$name];
    }

    public function paramFromGet($name)
    {
        return isset($_GET[$name]) ? $_GET[$name] : false;
    }

    public function getFiles()
    {
        return $_FILES;
    }

    public function isFiles($name)
    {
        return $_FILES[$name]['tmp_name'] != "" ? true : false;
    }

    public function getFile($name)
    {
        return $_FILES[$name];
    }

}
