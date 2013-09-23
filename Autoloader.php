<?php

/**
 * Description of Autoloader
 * 
 * Classe permettant de charger automatiquement toutes les classes selon le modèle MVC
 * 
 * @author Stéphane
 */
class Autoloader {

    /**
     * Méthode récursive de recherche de classe
     * @param string $class
     * @param string $dir
     */
    public static function Loader($class, $dir = null) {
        if($dir == null) {
            $dir = ".";
        }
        
        if(is_dir($dir)) {
           if($od = opendir($dir)) {
               while(($file = readdir($od)) !== false) {
                   
                   if($file != '.' && $file != '..' && $file != Cadmus::$name) {
                       $complete = $dir.'/'.$file;
                       
                       if(is_file($complete) && $file == $class.'.php') {
                           include_once($complete);
                           return;
                       } else if(is_dir($complete)) {
                           self::Loader($class, $complete);
                       }
                       
                   }
               } 
           }
            
        }
        
    }
    
    public static function ControllerLoader($class) {
        $path = Cadmus::$name . DIRECTORY_SEPARATOR . "bin" . DIRECTORY_SEPARATOR . 
                "Controller" . DIRECTORY_SEPARATOR . $class . ".php";
        
        if(file_exists($path)) include_once($path);
        else {
            
            $path = Cadmus::$name . DIRECTORY_SEPARATOR . "bin" . DIRECTORY_SEPARATOR . 
                "Controller" . DIRECTORY_SEPARATOR . 'FormValidator' . DIRECTORY_SEPARATOR . $class . ".php";
            
            if(file_exists($path)) include_once($path);
        }
    }
    
    public static function ModelLoader($class) {
        $path = Cadmus::$name . DIRECTORY_SEPARATOR . "bin" . DIRECTORY_SEPARATOR . 
                "Model" . DIRECTORY_SEPARATOR . $class . ".php";
        
        if(file_exists($path)) include_once($path);
    }
    
    public static function ViewLoader($class) {
        
        $path = Cadmus::$name . DIRECTORY_SEPARATOR . "bin" . DIRECTORY_SEPARATOR . 
                "View" . DIRECTORY_SEPARATOR . $class . ".php";
        
        
        if(file_exists($path)) include_once($path);
        else {
            
            $path = Cadmus::$name . DIRECTORY_SEPARATOR . "bin" . DIRECTORY_SEPARATOR . 
                "View" . DIRECTORY_SEPARATOR . 'Form' . DIRECTORY_SEPARATOR . $class . ".php";
        
            if(file_exists($path)) include_once($path);
        }
        
    }
    
    /**
     * Loader principale de classes 
     * @param string $class
     */
    public static function MainLoader($class) {  
        self::Loader($class);
    }
}

/* Loading classes from bin */
spl_autoload_register("Autoloader::ControllerLoader");
spl_autoload_register("Autoloader::ModelLoader");
spl_autoload_register("Autoloader::ViewLoader");

/* Loading user classes */
spl_autoload_register("Autoloader::MainLoader");

?>
