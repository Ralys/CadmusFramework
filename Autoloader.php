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
                   if($file != '.' && $file != '..') {
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
    
    /**
     * Loader principale de classes 
     * @param string $class
     */
    public static function MainLoader($class) {  
        self::Loader($class);
    }
}

spl_autoload_register("Autoloader::MainLoader");

?>
