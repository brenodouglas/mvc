<?php
namespace Base\RestFullController;

interface Rest {
	public function get($id);
	public function post($id);
	public function put($id);
	public function delete($id);
}