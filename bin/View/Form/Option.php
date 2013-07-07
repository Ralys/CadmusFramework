<?php

/**
 * Description of Option
 *
 * Classe représentant la balise Option
 * 
 * @author Stéphane
 */
class Option extends FormElement {
    
    private $label;
    private $disabled;  //booléen
    private $selected;  //booléen
    
    /**
     * Constructeur de la balise Option
     * @param string $value
     * @param boolean $selected Sélectionné par défaut ou non
     */
    public function __construct($value, $selected = false) {
        $this->setValue($value);
        $this->selected = $selected;
    }
    
    /**
     * Méthode permettant de créer la balise option
     * @return string
     */
    public function create() {
        $option = parent::create();
        
        if(isset($this->disabled) && $this->disabled) {
            $option .= " disabled";
        }
        
        if(isset($label)) {
            $option .= " label=" . $this->label;
        }
        
        if(isset($this->selected) && $this->selected) {
            $option .= " selected";
        }
        
        if(!is_null($this->getValue())) {
            $option .= '> ' . $this->getValue();
        }
        
        $option .= " </option>";
        
        return $option;
    }
    
    /**
     * Permet de savoir si l'option est désactivée
     * @return boolean
     */
    public function getDisabled() {
        return $this->disabled;
    }

    /**
     * Permet de modifier le booléen disabled qui définit si l'option est activée ou non
     * @param boolean $disabled
     * @return \Option
     */
    public function setDisabled($disabled) {
        $this->disabled = $disabled;
        return $this;
    }
    
    /**
     * Permet d'obtenir le label de l'option
     * @return string
     */
    public function getLabel() {
        return $this->label;
    }
    
    /**
     * Permet de modifier le label de l'option
     * @param string $label
     * @return \Option
     */
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    /**
     * Permet de savoir si l'option est sélectionnée par défaut
     * @return boolean
     */
    public function getSelected() {
        return $this->selected;
    }

    /**
     * Permet de modifier le booléen selected qui définit si l'option est sélectionnée par défaut ou non
     * @param boolean $selected
     * @return \Option
     */
    public function setSelected($selected) {
        $this->selected = $selected;
        return $this;
    }

}

?>
