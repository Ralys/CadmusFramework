<?php

/**
 * Description of FormElement
 *
 * Classe permettant de créer des éléments de formulaires (input, option, select, textarea)
 * 
 * @author Stéphane
 */
class FormElement {    
    
    private $name;
    /* Pour le CSS et le JavaScript */
    private $class;
    private $id;
    private $style;
    private $value;
    
    /**
     * Constructeur intialisant le nom
     * @param string $name
     */
    public function __construct($name) {
        $this->name = $name;
    }
    
    /**
     * Méthode créant la balise représentant l'élément
     * @return string
     */
    public function create() {
        $formElement = "<" . strtolower(get_class($this));
        
        if(isset($this->name)) {
            $formElement .= ' name="'.$this->name.'"';
        }
        
        if(isset($this->id)) {
            $formElement .= ' id="'.$this->id.'"';
        }
        
        if(isset($this->class)) {
            $formElement .= ' class="'. $this->class.'"';
        }
        
        if(isset($this->style)) {
            $formElement .= ' style="'.$this->style.'"';
        }
                
        return $formElement;
        
    }
    
    public function __toString() {
        return $this->create();
    }
    
    /**
     * Permet d'obtenir le nom de l'élément
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Permet de modifier le nom de l'élément
     * @param string $name
     * @return \FormElement
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Permet d'obtenir la classe de l'élément
     * @return string
     */
    public function getClass() {
        return $this->class;
    }

    /**
     * Permet de modifier la classe de l'élément
     * @param string $class
     * @return \FormElement
     */
    public function setClass($class) {
        $this->class = $class;
        return $this;
    }
    
    /**
     * Permet d'obtenir l'id de l'élément
     * @return string
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Permet de modifier l'id de l'élément
     * @param string $id
     * @return \FormElement
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Permet d'obtenir le style de l'élément
     * @return string
     */
    public function getStyle() {
        return $this->style;
    }

    /**
     * Permet de modifier le style de l'élément
     * @param string $style
     * @return \FormElement
     */
    public function setStyle($style) {
        $this->style = $style;
        return $this;
    }

    /**
     * Permet d'obtenir la valeur de l'élément
     * @return type
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Permet de modifier la valeur de l'élément
     * @param type $value
     */
    public function setValue($value) {
        $this->value = $value;
    }


}

?>
