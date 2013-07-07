<?php

Model::$PDO = Base::getConnection();

/**
 * Description of Model
 *
 * Classe abstraite de modèle
 * 
 * @author Stéphane
 */

abstract class Model {
    
    public static $PDO;
    
    /**
     * Constructeur du modèle
     * @param array $data, tableau associatif attributs-valeurs
     */
    public function __construct(array $data = null) {
        if(!is_null($data)) {
            foreach($data as $attr => $value) {
                $this->set($attr, $value);
            }
        }
    }
    
    /**
     * Getteur général
     * @param string $attribut
     * @return type 
     */
    public function get($attribut) {
        if(property_exists($this, $attribut)) {
            return $this->$attribut;
        }
        
        $emess = ": Attribut $attribut inconnu";
        throw new Exception($emess, 45);
    }
    
    /**
     * Setteur général
     * @param string $attribut
     * @param type $valeur
     * @return Model 
     */
    public function set($attribut, $valeur) {
         if(property_exists($this, $attribut)) {
            $this->$attribut = htmlspecialchars($valeur);
            return $this;
        }
        
//        $emess = ": Attribut $attribut inconnu";
//        throw new Exception($emess, 45);
    }
    
    /**
     * Méthode magique utilisée pour utiliser les getters et setteurs particuliers
     * @param string $methode
     * @param type $arguments
     * @return type getter ou setter
     */
    public function __call($methode, $args) {
        
        $length = strlen($methode);
        $prefix = substr($methode, 0, 3);
        $attribut = lcfirst(substr($methode, 3, $length));
        
        if($prefix == "get" && property_exists($this, $attribut)) {
            return $this->get($attribut);
        } else if($prefix == "set" && property_exists($this, $attribut)) {
            return $this->set($attribut, $args[0]);
        } else if(property_exists($this, $methode)) {
            return $this->get($methode);
        }
    }
    
    /**
     * Méthode magique utilisée pour utiliser les finders particuliers
     * @param string $methode
     * @param type $arguments
     * @return type finder
     */
    public static function __callStatic($methode, $args) {
        
        $length = strlen($methode);
        
        if(substr($methode, 0, 6) == "findBy" && $length > 6) {
            $attribut = strtolower(substr($methode, 6, $length));
            
            if(isset($args[1]))
                return self::findBy(array($attribut => $args[0]), $args[1]);
            else
                return self::findBy(array($attribut => $args[0]));
            
        } else if (substr($methode, 0, 9) == "findOneBy" && $length > 9) {
            
            $attribut = strtolower(substr($methode, 9, $length));
            $tab = self::findBy(array($attribut => $args[0]));
            
            if(is_null($tab) ||empty($tab)) return null;
            else return $tab[0];
            
        } else if (substr($methode, 0, 9) == "findOneBy" && $length == 9) {
            
            $tab = self::findBy($args[0]);
            
            if(is_null($tab) ||empty($tab)) return null;
            else return $tab[0];
            
        } else if(substr($methode, 0, 7) == "findAll") {
            if(isset($args[0]))
                $tab = self::findBy(array(), $args[0]);
            else
                $tab = self::findBy(array());
            
            return $tab;
        }
    }
    
    /**
     * Converti un objet en array
     * @return array
     */
    public function toArray() {
        return get_object_vars($this);
    }
    
    /**
     * Méthode d'hydratation
     * @param array $data 
     */
    public function hydrate(array $data) {   
        
        foreach($data as $champ => $valeur) {
            $this->set($champ, $valeur);
        }
        
        return $this;
    }
    
    /**
     * Méthode d'insertion en BDD
     */
    public function insert() {
        $tab = $this->toArray();
        $firstProperty = key($tab);
        unset($tab[$firstProperty]);
        
        $nbProperties = count($tab);
        
        $requete = "INSERT INTO ". get_class($this) ."(";
        
        $i = 0;
        foreach($tab as $property => $value) {
            $requete.= $property;
            
            if($i == $nbProperties - 1)
                $requete.= ") VALUES(";
            else
                $requete.= ", ";
            
            $i++;
        }
        
        $i = 0;
        foreach($tab as $property => $value) {
            $requete.= ":".$property;
            
            if($i == $nbProperties - 1)
                $requete.= ");";
            else
                $requete.= ", ";
            
            $i++;
        }
        
        $query = self::$PDO->prepare($requete);
        $query->execute($tab);
        
        $this->set($firstProperty, self::$PDO->LastInsertId());
        
    }    
    
    /**
     * Méthode de mise à jour en BDD
     */
    public function update() {
        $tab = $this->toArray();
        $firstProperty = key($tab);
        unset($tab[$firstProperty]);
        
        $nbProperties = count($tab);
        
        $requete = "UPDATE ". get_class($this) ." SET ";
        
        $i = 0;
        foreach($tab as $property => $value) {
            $requete.= $property . "= :" . $property;
            
            if($i != $nbProperties - 1)
                $requete.= ", ";                
            
            $i++;
        }
        
        $requete .= " WHERE " . $firstProperty . " = " . $this->$firstProperty;
        
        $query = self::$PDO->prepare($requete);
        $query->execute($tab);
    }
    
    /**
     * Méthode de sauvegarde de l'objet en BDD (soit une insertion, soit une mise-à-jour)
     * @return insert ou update
     */
    public function save() {
        $firstProperty = key($this->toArray());
        
        if (isset($this->$firstProperty)){
            return $this->update();
        } else {
            return $this->insert();
        }
    }
    
    /**
     * Méthode permettant la suppression en BDD en fonction de la première propriété
     */
    public function delete() {
        $firstProperty = key($this->toArray());
        
        $query = self::$PDO->prepare("DELETE FROM ". get_class($this) ." WHERE ". $firstProperty ." = :".$firstProperty);
	$query->bindParam(":".$firstProperty, $this->$firstProperty);
	$query->execute();
    }
    
    /**
     * Finder général
     * @param array $attribut
     * @return modele 
     */
    public static function findBy(array $attributs, $options = null) {
        
        $modele = get_called_class();
        $requete = "SELECT * FROM ". $modele;
        
        $nbAttr = count($attributs);
        
        if($nbAttr > 0) {
            $requete .= " WHERE ";
            $i = 0;
            foreach($attributs as $nom => $valeur) {
                $requete .= $nom . " = :".$nom;
                $i++;
                if($i != $nbAttr) $requete .= " AND ";
            }
        }
      
        $query = self::$PDO->prepare($requete." ".$options);
        $query->execute($attributs);
        
        $data = $query->fetchAll(PDO::PARAM_STR);
        $tab = array();
        
        if($data === false) {
            return $data;
        } else {
            foreach($data as $d) {
                $obj = new $modele();
                $obj->hydrate($d);
                $tab[] = $obj;
            }
            
            return $tab;
        }
    }
    
    /**
     * Destructeur de l'objet
     */
    public function __destruct() {
        $data = $this->toArray();
        
        foreach($data as $champ => $valeur) {
            unset($this->$champ);
        }
    }
}

?>
