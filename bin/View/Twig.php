<?php

include_once('twig/lib/Twig/Autoloader.php');

/**
 * Description of Twig
 *
 * Instance de Twig
 * 
 * @author stephane
 */
class Twig {
    
    private static $twig = null;   // Environnement de twig
    
    public static function getTwig() {
        
        if(self::$twig == null) {
            Twig_Autoloader::register();
            $loader = new Twig_Loader_Filesystem(LAYOUT_DIR); // Dossier contenant les templates
        
            self::$twig = new Twig_Environment($loader, array('cache' => false));
            
            $vardump = new Twig_SimpleFunction('dump', function($obj) {
                var_dump($obj);
            });
            
            $path = new Twig_SimpleFunction('path', function($route, $params = null) {
                return Controller::generateURL($route, $params);
            });
            
            self::$twig->addFunction($vardump);
            self::$twig->addFunction($path);
        } 
        
        return self::$twig;   
    }
    
}

?>
