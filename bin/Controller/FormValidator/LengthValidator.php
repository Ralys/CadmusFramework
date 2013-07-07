<?php

/**
 * Description of LengthValidator
 *
 * Validateur de champ de formulaires en fonction de la longueur du contenu
 * 
 * @author Stéphane
 */
class LengthValidator extends FormValidator {
    
    private $min;       // Longueur minimale
    private $max;       // Longueur maximale
    
    /**
     * Constructeur du LengthValidator
     * @param int $min
     * @param int $max
     * @throws Exception
     */
    public function __construct($min, $max) {
        
        if(is_int($min) && is_int($max) && $min >= 0 && $min <= $max) {
            $this->min = $min;
            $this->max = $max;
            $this->setErrorMessage("La longueur de la chaîne doit être comprise entre ".
                                    $this->min . " et ". $this->max . ".");
        } else {
            throw new Exception("Le minimum doit être supérieur ou égal à 0
                                 et le maximum doit être supérieur ou égal au minimum.");
        }
    }
    
    /**
     * Permet d'obtenir la longueur minimale
     * @return int
     */
    public function getMin() {
        return $this->min;
    }

    /**
     * Permet d'obtenir la longueur maximale
     * @return int
     */
    public function getMax() {
        return $this->max;
    }
    
    /**
     * Retourne un booléen qui définit si oui ou non la valeur est valide
     * @return boolean
     */
    public function isValid() {
        return (strlen($this->getValue()) <= $this->getMax() && strlen($this->getValue()) >= $this->getMin());
    }

}

?>
