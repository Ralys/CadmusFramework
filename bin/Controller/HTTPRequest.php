<?php

/**
 * Description of HTTPRequest
 * 
 * Classe permettant de récupérer les données GET et POST
 *
 * @author Linuxien
 */
class HTTPRequest {
    
    /**
     * Permet d'obtenir les valeurs en GET
     * @param type $key
     * @return une valeur ou null
     */
    public function get($key = null) {
        if(!is_null($key)) {
            if(isset($_GET[$key])) {
                return $_GET[$key];
            } else {
                return null;
            }
        } else {
            return $_GET;
        }
    }
    
    /**
     * Permet d'obtenir les valeurs en GET
     * @param type $key
     * @return une valeur ou null
     */
    public function post($key = null) {
        if(!is_null($key)) {
            if(isset($_POST[$key])) {
                return $_POST[$key];
            } else {
                return null;
            }
        } else {
            return $_POST;
        }
    }
    
    /**
     * Permet de déterminer la méthode (GET ou POST)
     * @return GET|POST
     */
    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    /**
     * Méthode retournant l'URL courant
     * @return string
     */
    public function getRequest() {
        return $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Permet de savoir si la requête est en GET
     * @return boolean
     */
    public function isGet() {
        return (strcasecmp($this->getMethod(), "get") == 0);
    }
    
    /**
     * Permet de savoir si la requête est en POST
     * @return boolean
     */
    public function isPost() {
       return (strcasecmp($this->getMethod(), "post") == 0); 
    }
}

?>
