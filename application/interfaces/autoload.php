<?php
/*
class Interface_autoloader {

    public function __construct() {
        $this->init_autoloader();
    }

    private function init_autoloader(){
        
        (function($classname){
            if( strpos($classname,'interface') !== false ){
                strtolower($classname);
                require('application/interfaces/'.$classname.'.php');
            }
        });
    }

}


if(!function_exists('autoload')){
    function autoload($class){
        $class=strtolower($class);
        $classFile=$_SERVER['DOCUMENT_ROOT'].'/include/class/'.$class.'.class.php';
        if(is_file($classFile)&&!class_exists($classFile)) include $classFile;
    }
}
spl_autoload_register('autoload');