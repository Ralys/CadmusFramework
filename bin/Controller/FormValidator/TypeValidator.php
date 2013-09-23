<?php

/**
 * Description of TypeValidator
 *
 * Validateur de champ de formulaires en fonction du type du contenu
 * 
 * @author stephane
 */
class TypeValidator extends FormValidator {
    
    private $type;
    private $allTypes;
    
    /**
     * Constructeur du validateur de type
     * @param string $type
     */
    public function __construct($type = null) {
        $this->allTypes = array("int", "double", "float", "boolean", "string");
        
        if($type == null ||in_array($type, $this->allTypes) === false) {
            $this->type = "string";
        } else {
            $this->type = $type;
        }
        
        $this->setErrorMessage("La valeur saisie n'est pas de type " . $this->type . "!");
    }
    
    /**
     * Retourne un booléen si le type de la valeur correspond au type défni
     * @return boolean
     */
    public function isValid() {
        $val = $this->getValue();
        $bool = false;
        
        switch($this->type) {
            case "int":
                if(is_numeric($val)) {
                    $bool = is_int(intval($val)) && ((string)(int) $val) === ((string) $val);
                } else $bool = false;
                break;
            case "double":
                if(is_numeric($val)) {
                    $bool = is_double(doubleval($val)) && ((string)(double) $val) === ((string) $val);
                } else $bool = false;
                break;
            case "float":
                if(is_numeric($val)) {
                    $bool = is_float(floatvalval($val)) && ((string)(float) $val) === ((float) $val);
                } else $bool = false;
                break;
            case "boolean":
                $bool = (strcasecmp("true", $val) === 0) || (strcasecmp("false", $val) === 0);
                break;
        }
        
        return $bool;
        
    }    
}

?>
