<?php
namespace Base\Controller;

use App\Module;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Doctrine {
    
    private static $entityManager;
    
    public function getEntityManager() {
        $conn = $this->getConn();
        $config = $this->getConfig();
        try {
            if(isset(self::$entityManager)){
                return self::$entityManager;          
            } else {
                self::$entityManager = EntityManager::create($conn, $config);
            }
        } catch(\Exception $e){
            echo $e->getMessage();die;
        }
        return self::$entityManager;
        
    }
    
    public function getConn(){
        
        $conn = Module::dbConfig();
        
        return $conn;
    }
    
    public function getConfig(){
        $modules = Module::getModules();
        $array = array();
        foreach($modules as $key=>$value){
            $array[] = __DIR__."/../../../App/".$value."/Entity";
        }
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration($array, $isDevMode);
        
        return $config;
    }
}

