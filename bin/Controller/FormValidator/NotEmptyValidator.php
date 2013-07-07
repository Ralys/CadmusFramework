<?php

class NotEmptyValidator extends FormValidator {
    
    public function __construct() {
        $this->setErrorMessage("Ce champ ne peut être vide.");
    }

    public function isValid() {
        $value = $this->getValue();
        $value = trim($value);
        
        return !empty($value);
    }

}

?>
