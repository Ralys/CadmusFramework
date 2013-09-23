<?php

/**
 * Description of Input
 *
 * Classe représentant la balise Input
 * 
 * @author Stéphane
 */
class Input extends FormElement {
    
    private $label;
    private $type;
    private $size;
    private $placeholder;
    private $pattern;
    private $height;
    private $width;
    private $min;
    private $max;
    private $accept;
    private $readonly;      //booléen
    private $required;      //booléen
    private $disabled;      //booléen
    private $checked;       //booléen
    private $autofocus;     //booléen
    private $autocomplete;  //booléen
    
    /* Tous les types possible */
    private static $allTypes = null;
    
    /* Les attributs qui n'ont pas besoin d'être réécrits */
    private static $alreadyWritten = null;
            
    /* Tous les attributs booléens */
    private static $booleans = null;
            
    /**
     * Constructeur de la balise Input
     * @param tab array, les propriétés de l'input
     */
    public function __construct(array $tab) {
        
        if(is_null(self::$allTypes)) {
            self::$allTypes = array('button', 'checkbox', 'color', 
                                    'date', 'datetime', 'datetime-local',
                                    'email', 'file', 'hidden', 'image',
                                    'month', 'number', 'password', 'radio',
                                    'range', 'reset', 'search', 'submit', 'tel',
                                    'text', 'time', 'url', 'week');
        }
        
        if(is_null(self::$booleans)) {
            self::$booleans = array('readonly','required', 'disabled', 
                                    'checked', 'autofocus', 'autocomplete');
        }
        
        if(is_null(self::$alreadyWritten)) {
            self::$alreadyWritten = array('name', 'class', 'id', 'style', 'value');
        }
        
        
        foreach($tab as $prop => $val) {
            $this->$prop = $val;
        }
    }
    
    /**
     * Méthode permettant de créer la balise input
     * @return string
     * @throws Exception
     */
    public function create() {
        if(!in_array($this->type, self::$allTypes)) {
            throw new Exception("Type de l'input incorrect");
        }
        
        $input = parent::create();
        
        $tab = get_object_vars($this);
        
        if(isset($this->label)) {
            $id = $this->getId();
            
            if(!isset($id))
                throw new Exception("Un id doit être déclaré pour l'input " . $this->getName());
            else
                $input = '<label for="'. $this->getId() . '">'. $this->getLabel() . '</label>' . $input;
        }
        
        if(!is_null($this->getValue())) {
            $input .= ' value="'.$this->getValue().'"';
        }
        
        foreach($tab as $attribut => $valeur) {
            
            if(!in_array($attribut, self::$alreadyWritten)) {
                
                if(in_array($attribut, self::$booleans)) {
                    if(isset($this->$attribut) && $this->$attribut)
                        $input .= " " . $attribut;
                } else {
                    if(isset($this->$attribut))
                        $input .= " " . $attribut . '="' . $valeur . '"';
                }
            }
        }
        
        $input .= " />";
        
        return $input;
    }

    /**
     * Permet d'obtenir le type de l'input
     * @return string
     */
    public function getType() {
        return $this->type;
    }
    
    /**
     * Permet de modifier le type de l'input
     * @param string $type
     * @return \Input
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Permet de récupérer la taille de l'input
     * @return int
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Permet de modifier la taille de l'input
     * @param int $size
     * @return \Input
     */
    public function setSize($size) {
        $this->size = $size;
        return $this;
    }
    
    /**
     * Permet d'obtenir le placeholder de l'input
     * @return string
     */
    public function getPlaceholder() {
        return $this->placeholder;
    }

    /**
     * Permet de modifier le placeholder de l'input
     * @param string $placeholder
     * @return \Input
     */
    public function setPlaceholder($placeholder) {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * Permet d'obtenir le pattern de l'input (un patten est une expression régulière)
     * @return string (regexp)
     */
    public function getPattern() {
        return $this->pattern;
    }

    /**
     * Permet de modifier le pattern de l'input (un patten est une expression régulière)
     * @param string $pattern
     * @return \Input
     */
    public function setPattern($pattern) {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Permet de savoir si oui ou non l'input est en readonly
     * @return boolean
     */
    public function getReadonly() {
        return $this->readonly;
    }

    /**
     * Permet de modifier le boolean qui définit si l'input est en readonly
     * @param boolean $readonly
     * @return \Input
     */
    public function setReadonly($readonly) {
        $this->readonly = $readonly;
        return $this;
    }

    /**
     * Permet d'obtenir la hauteur de l'input
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Permet de modifier la hauteur de l'input
     * @param int $height
     * @return \Input
     */
    public function setHeight(int $height) {
        $this->height = $height;
        return $this;
    }

    /**
     * Permet d'obtenir la largeur de l'input
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Permet de modifier la largeur de l'input
     * @param int $width
     * @return \Input
     */
    public function setWidth(int $width) {
        $this->width = $width;
        return $this;
    }
    
    /**
     * Si l'input est de type "range", retourne le minimum
     * @return int
     */
    public function getMin() {
        return $this->min;
    }

    /**
     * Si l'input est de type "range", modifie le min
     * @param int $min
     * @return \Input
     */
    public function setMin(int $min) {
        $this->min = $min;
        return $this;
    }

    /**
     * Si l'input est de type "range", retourne le maximum
     * @return int
     */
    public function getMax() {
        return $this->max;
    }

    /**
     * Si l'input est de type "range", modifie le maximum
     * @param int $max
     * @return \Input
     */
    public function setMax(int $max) {
        $this->max = $max;
        return $this;
    }

    /**
     * Permet de savoir si l'input est désactivé
     * @return boolean
     */
    public function getDisabled() {
        return $this->disabled;
    }

    /**
     * Permet de rendre l'input inactif
     * @param boolean $disabled
     * @return \Input
     */
    public function setDisabled($disabled) {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Permet de savoir si l'input est "checked"
     * @return boolean
     */
    public function getChecked() {
        return $this->checked;
    }

    /**
     * Permet de modifier le booléen "checked" de l'input
     * @param boolean $checked
     * @return \Input
     */
    public function setChecked($checked) {
        $this->checked = $checked;
        return $this;
    }

    /**
     * Permet de savoir si l'input est en autofocus
     * (curseur positionné dans l'input dès le chargement de la page)
     * @return boolean
     */
    public function getAutofocus() {
        return $this->autofocus;
    }

    /**
     * Permet de modifier le booléen autofocus de l'input
     * (curseur positionné dans l'input dès le chargement de la page)
     * @param boolean $autofocus
     * @return \Input
     */
    public function setAutofocus($autofocus) {
        $this->autofocus = $autofocus;
        return $this;
    }

    /**
     * Permet de savoir si l'input est en autocomplete
     * @return boolean
     */
    public function getAutocomplete() {
        return $this->autocomplete;
    }

    /**
     * Permet de modifier le booléen autocomplete de l'input
     * @param boolean $autocomplete
     * @return \Input
     */
    public function setAutocomplete($autocomplete) {
        $this->autocomplete = $autocomplete;
        return $this;
    }

    /**
     * Permet d'obtenir l'accept (pour l'upload de fichier)
     * @return string
     */
    public function getAccept() {
        return $this->accept;
    }

    /**
     * Permet de modifier l'accept (pour l'upload de fichier)
     * @param string $accept
     * @return \Input
     */
    public function setAccept($accept) {
        $this->accept = $accept;
        return $this;
    }
    
    /**
     * Permet de savoir si l'input est requis/oblogatoire lors de la soumission du formulaire
     * @return boolean
     */
    public function getRequired() {
        return $this->required;
    }

    /**
     * Permet de modifier le booléen qui définit si l'input est requis/oblogatoire lors de la soumission du formulaire
     * @param boolean $required
     * @return \Input
     */
    public function setRequired($required) {
        $this->required = $required;
        return $this;
    }
    
    /**
     * Permet d'obtenir le label de l'input
     * @return string
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * Permet de modifier le label de l'input
     * @param string $label
     * @return \Input
     */
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }
    
}

?>
