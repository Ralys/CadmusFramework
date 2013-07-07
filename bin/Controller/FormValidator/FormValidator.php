<?php

/**
 * Description of FormValidator
 *
 * Classe abstraite permettant de valider des champs de formulaires
 * 
 * @author Stéphane
 */
abstract class FormValidator {
    
    protected $errorMessage;    // Message d'erreur
    protected $value;           // La valeur à vérifier
    
    /**
     * Modifie le message d'erreur
     * @param string $message
     */
    public function setErrorMessage($message) {
        $this->errorMessage = $message;
    }
    
    /**
     * Retourne le message d'erreur
     * @return string
     */
    public function getErrorMessage() {
        return $this->errorMessage;
    }
    
    /**
     * Permet d'obtenir la valeur à valider
     * @return type
     */
    public function getValue() {
        return $this->value;
    }
    
    /**
     * Permet de modifier la valeur à valider
     * @param type $value
     */
    public function setValue($value) {
        $this->value = $value;
    }
    
    /**
     * Méthode permettant de savoir si un formulaire est valide.
     */
    public abstract function isValid();

}

?>
