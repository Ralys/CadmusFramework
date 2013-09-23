<?php

/**
 * Description of ComboValidator
 *
 * @author Stéphane
 */
class ComboValidator extends FormValidator {
    
    private $validators = array();
    
    public function __construct(array $validators) {
        foreach($validators as $name => $params) {
            $valObj = ucfirst($name). "Validator";
            
            if(strcasecmp($valObj, "LengthValidator") == 0) {
                $this->validators[] = new $valObj(intval($params[0]), intval($params[1]));
            } else if(strcasecmp($valObj, "TypeValidator") == 0) {
                $this->validators[] = new $valObj($params);
            } else if(strcasecmp($valObj, "NotEmptyValidator") == 0) {
                $this->validators = new $valObj();
            } else {
                throw new Exception("Validateur inconnu !");
            }
        }
        
    }
    
    public function isValid() {
        foreach($this->validators as $validator) {
            $validator->setValue($this->getValue());
            
            if($validator->isValid() == false) {
                $this->setErrorMessage($validator->getErrorMessage());
                return false;
            }
        }
        
        return true;
    }    
}

?>
