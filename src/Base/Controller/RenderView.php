<?php 
namespace Base\Controller;

class RenderView 
{
	public function content($name)
	{   
		if(!file_exists($name))
			throw new \Exception("Não existe action para a view");
	}
}