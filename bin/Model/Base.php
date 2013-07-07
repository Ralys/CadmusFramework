<?php

/**
 * Description of Base
 *
 * Classe contenant le singleton permettant de se connecter à la base de données
 * 
 * @author Stéphane
 */
class Base {
    
    private static $bdd = null;     // La base de données
    
    public function __construct() {}
   
    /**
     * Méthode statique qui effectue la connexion une seule fois
     */
    private static function connect() {
        try {
            self::$bdd = new PDO('mysql:host='.HOSTNAME.';dbname='.DBNAME, LOGIN, PWD);
            self::$bdd->exec("SET CHARACTER SET utf8");
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    
    /**
     * Méthode statique qui renvoie la base
     * @return PDO
     */
    public static function getConnection() {
        
        if(self::$bdd == null) {
            self::connect();
        }
        
        return self::$bdd;
    }
}

?>
