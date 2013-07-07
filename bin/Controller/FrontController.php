<?php

/**
 * Description of FrontController
 *
 * Classe du FrontController permettant de faire le lien entre l'URL saisi
 * dans le naviageteur et le contrôleur et l'action souhaités
 * 
 * @author Stéphane
 */

class FrontController {
    
    private $appname;    // Nom de l'application
    private $default;   // Route par défaut
    
    /**
     * Constructeur du FrontController
     * @param string $appname
     * @param string $default 
     */
    public function __construct($appname, $default) {
        $this->appname = $appname;
        $this->default = $default;
        
        define('APPNAME', $appname);
    }
    
    /**
     * Dispatcher du FrontController
     */
    public function dispatch() {
        $url = explode("/", $_SERVER['REQUEST_URI']);
        
        $split = 1;
        $domain = "";
        foreach($url as $part) {
            $split++;
            $domain .= $part . "/";
             
            if($part == $this->appname) {
                define('DOMAIN', $domain.'index.php');
                break;
            }
        }
        
        $params = null;
        
        if(isset($url[$split+2])) {
            $params = $url[$split+2];

            if(strpos($params, "-") != -1) {
                $params = explode("-", $params);
            }
        }
        
        if(isset($url[$split]) && isset($url[$split+1])) {
            $c = ucfirst($url[$split]).'Controller';
            $controleur = new $c($params);
            
            $m = $url[$split+1];
            $methode =  $m . "Action";                
                     
            if(method_exists($controleur, $methode)) {
                // Si la méthode existe alors on l'appelle
                $controleur->$methode();
            } else {
                $controleur->redirect($controleur->getName() . "#default");
            }
                
        } else {
            $path = DOMAIN.'/'.$this->default."/";
            header('Location: '. $path);
        }
    }
    
}

?>
