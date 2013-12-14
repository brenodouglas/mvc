<?php
namespace Base\Controller;

class Request implements RequestInterface {

	public function isPost(){
		return $_SERVER['REQUEST_METHOD'] == "POST" ? true : false;
	}
	
	public function getPost(){
		return $_POST;
	}
	
	public function isGet(){
		return $_SERVER['REQUEST_METHOD'] == "GET" ? true : false;
	}
	
	public function getPostFromName($name){
		return $_POST[$name];
	}

	public function getHttpMethod()
	{
		return strtolower($_SERVER["REQUEST_METHOD"]);
	}

}