<?php

/**
 * Description of Select
 *
 * Classe représentant la balise Select
 * 
 * @author Stéphane
 */
class Select extends FormElement {
    
    private $label;
    private $autofocus = false;     //booléen
    private $disabled  = false;     //booléen
    private $required  = false;     //booléen
    private $size;
    private $options;
    
    /**
     * Constructeur de la balise select
     * @param array $tab, les propriétés du select
     * @param array $options des objets Option ou Optgroup
     */
    public function __construct(array $tab, array $options = null) {
        
        foreach($tab as $prop => $val) {
            $this->$prop = $val;
        }
        
        $this->options = array();

        if(!is_null($options)) {
            foreach($options as $option) {
                if($option instanceof Option)
                    $this->options[$option->getValue()] = $option;
                else if ($option instanceof OptGroup) {
                    $this->options[] = $option;
                }
                    
            }
        }
    }
    
    /**
     * Méthode permettant de créer la balise select
     * @return string
     */
    public function create() {
        $select = parent::create();

        if(isset($this->label)) {
            $id = $this->getId();
            
            if(!isset($id))
                $this->setId($this->getName());
            
            $select = '<label style="display:inline-block;margin-right:5px;" for="'. $this->getId() . '">'. $this->getLabel() . '</label>' . $select;
        }
        
        if(isset($this->autofocus) && $this->autofocus) {
            $select .= " autofocus";
        }
        
        if (isset($this->disabled) && $this->disabled) {
            $select .= " disabled";
        }
        
        if(isset($this->required) && $this->required) {
            $select .= " required";
        }
        
        if(isset($this->size)) {
            $select .= ' size="' . $this->size . '"';
        }
        
        $select .= ">";
        
        foreach($this->options as $option) {
            $select .= "\n\t\t" . $option->create();
        }
        
        $select .= "\n\t</select>";
        
        return $select;
    }

    /**
     * Permet d'obtenir le label du select
     * @return string
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * Permet de modifier le label du select
     * @param string $label
     * @return \Select
     */
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }   
    
    /**
     * Permet de défnir si le select est en autofocus
     * @return boolean
     */
    public function getAutofocus() {
        return $this->autofocus;
    }

    /**
     * Permet de modifier le booléen autofocus de select
     * @param boolean $autofocus
     * @return \Select
     */
    public function setAutofocus($autofocus) {
        $this->autofocus = $autofocus;
        return $this;
    }

    /**
     * Permet de savoir si le select est désactivé ou non
     * @return boolean
     */
    public function getDisabled() {
        return $this->disabled;
    }

    /**
     * Permet de modifier le booléen disabled de select
     * @param boolean $disabled
     * @return \Select
     */
    public function setDisabled($disabled) {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Permet de savoir si le select est requis/obligatoire lors de la soumission du formulaire
     * @return boolean
     */
    public function getRequired() {
        return $this->required;
    }

    /**
     * Permet de modifier le booléen qui défnit si le select est requis/obligatoire lors de la soumission du formulaire
     * @param boolean $required
     * @return \Select
     */
    public function setRequired($required) {
        $this->required = $required;
        return $this;
    }

    /**
     * Permet d'obtenir la taille du select
     * @return int
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Permet de modifier la taille du select
     * @param int $size
     * @return \Select
     */
    public function setSize(int $size) {
        $this->size = $size;
        return $this;
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
     * Méthode d'ajout d'options
     * @param OptGroup $optGroup
     * @return \Select
     */
    public function addOptionGroup(OptGroup $optGroup) {
        $this->options[] = $optGroup;
        return $this;
    }
    
    /**
     * Surcharge de la méthode setValue pour cocher la valeur
     * souhaité après hydratation du formulaire
     * @param string $value
     */
    public function setValue($value) {
        parent::setValue($value);
        
        foreach($this->options as $value => $option) {
            if($this->getValue() == $value) {
                $option->setSelected(true);
            } else {
                $option->setSelected(false);
            }
        }
    }

}

?>
