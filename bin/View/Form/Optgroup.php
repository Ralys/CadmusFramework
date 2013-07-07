<?php

/**
 * Description of OptGroup
 *
 * Classe représentant la balise Optgroup
 * 
 * @author Stéphane
 */
class Optgroup extends FormElement {
    
    private $disabled;  //booléen
    private $label;
    
    /**
     * Constructeur de la balise Optgroup
     * @param string $label
     * @param array $options des options
     */
    public function __construct($label, array $options = null) {
        $this->label = $label;
        $this->options = array();

        if($options !== null) {
            foreach($options as $option) {
                $this->options[$option->getValue()] = $option;
            }
        }
    }
    
    /**
     * Méthode de génération de la balise Optgroup
     * @return string
     */
    public function create() {
        $optGroup = parent::create();
        
        if(isset($this->label)) {
            $optGroup .= " label=" . $this->label;
        }
        
        if(isset($this->disabled) && $this->disabled) {
            $optGroup .= " disabled";
        }
        
        $optGroup .= ">";
        
        foreach($this->options as $option) {
            $optGroup .= "\n\t\t" . $option->create();
        }
        
        $optGroup .= "\n\t</optgroup>";
        
        return $optGroup;
    }
    
    /**
     * Méthode d'ajout d'options
     * @param Option $option
     * @return \Select
     */
    public function addOption(Option $option) {
        $this->options[$option->getValue()] = $option;
        return $this;
    }
    
    /**
     * Permet de savoir si le groupe d'options est desactivé
     * @return boolean
     */
    public function getDisabled() {
        return $this->disabled;
    }

    /**
     * Modifie le booléen qui définit si le groupe d'option est desactivé
     * @param boolean $disabled
     * @return \Optgroup
     */
    public function setDisabled($disabled) {
        $this->disabled = $disabled;
        return $this;
    }
    
    /**
     * Permet de récupérer le label
     * @return string
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * Modifie le label
     * @param string $label
     * @return \Optgroup
     */
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }
    
}

?>
