<?php

include_once ('Autoloader.php');

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
    
    public static $name = 'CadmusFramework';

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
     * Méthode permettant de définir les paramètres de configuration
     * pour la connexion à la base de données ainsi qu'à l'accès au dossier contenant
     * les vues
     * 
     * Ex : array('hostname' => ..., 'dbname' => ..., 'login' => ...,
     *            'password' => ..., 'layout' => ...)
     * 
     * @param array $tab tableau contenant les infos suivantes 
     */
    public function config(array $tab) {
        
        $params = array('hostname', 'dbname', 'login', 'password', 'layout');
        
        if(empty($tab)) {
            throw new Exception("Veuillez renseigner les paramètres de configuration");
        } else {
            foreach($params as $k => $v) {
                define(strtoupper($v), $tab[$v]);
            }
        }
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
