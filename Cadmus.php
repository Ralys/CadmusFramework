<?php

include_once ('Autoloader.php');
include_once('config.php');

/**
 * Description of Cadmus
 *
 * Instance de l'application
 * 
 * @author stephane
 */
class Cadmus {
    
    private $appname;
    private $default;

    /**
     * Constructeur permettant d'intialiser l'application
     * @param string $appname
     * @param string $default
     */
    public function __construct($appname, $default) {
        $this->appname = $appname;
        $this->default = $default;
    }

    /**
     * Méthode lançant l'application
     */
    public function run() {
        session_start();
        
        $fc = new FrontController($this->appname, $this->default);
        $fc->dispatch();
    }
}

?>
