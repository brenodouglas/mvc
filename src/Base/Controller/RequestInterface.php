<?php
namespace Base\Controller;

interface RequestInterface {

	public function isPost();
	public function getPost();
	public function isGet();
	public function getPostFromName($name);	
	public function getHttpMethod();
}