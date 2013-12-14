<?php
namespace Base\Request;

interface RequestInterface {

	public function isPost();
	public function getPost();
	public function isGet();
	public function getPostFromName($name);
	public function paramFromGet($name);
        public function getFiles();
        public function getFile($name);
}