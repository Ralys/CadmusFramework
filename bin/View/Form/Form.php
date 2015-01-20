<?php

/**
 * Description of Form
 *
 * Classe permettant de gérer des formulaires
 * 
 * @author Stéphane
 */
class Form {
    
    // Pour le CSS et JavaScript
    private $class;
    private $id;
    private $style;
    
    // Pour la balise en elle-même
    private $method;
    private $action;
    
    // Pour le contenu
    private $fieldset; // booléen
    private $legend;
    
    private $separator;
    
    private $champs;                // Les champs (input, select, option, ...)
    private $validators = array();  // Les validateurs (length, ...)
    private $errorsList = array();  // Liste des erreurs après appel de la méthode isValid()
    
    private static $nb_form = 0;
    
    /**
     * Constructeur initialisant la méthode et l'action
     * @param string $methode
     * @param string $action
     */
    public function __construct($methode, $action) {
        $this->method = $methode;
        $this->action = $action;
        $this->champs = array();
        $this->separator = "";
    }
    
    /**
     * Permet d'ajouter au formulaire un élement (input, select) ainsi qu'un possible validateur
     * @param FormElement $element
     * @param FormValidator $validator
     * @return \Form
     */
    public function add(FormElement $element, FormValidator $validator = null) {
        $this->champs[$element->getName()] = $element;
        
        if($validator !== null)
            $this->validators[$element->getName()] = $validator;
        
        return $this;
    }
    
    /**
     * Méthode retournant un élément du formulaire
     * @param string $name
     * @return \FormElement|null
     */
    public function getElementByName($name) {
        if(isset($this->champs[$name])) {
            return $this->champs[$name];
        } else {
            return null;
        }
    }
    
    /**
     * Permet de retourner tous les champs d'un formulaire
     * @return array composé de \FormElement
     */
    public function getAllElements() {
        return $this->champs;
    }
    
    /**
     * Méthode permettant de créer le formulaire
     * @return string
     * @throws Exception
     */
    public function create() {
        if((strcasecmp($this->method, "get") != 0) && (strcasecmp($this->method, "post") != 0))
            throw new Exception("Méthode du formulaire incorrecte");
        
        $form = '<form ';
        
        if(isset($this->id))
            $form .= 'id="'.$this->id.'" ';
        
        if(isset($this->class))
            $form .= 'class="'.$this->class.'" ';
        
        if(isset($this->style))
            $form .= 'style="'.$this->style.'" ';
                
                
        $form .= 'method="'.$this->method.'" action="'. $this->action . '">';
        
        if($this->fieldset)
            $form .= "\n<fieldset>";
        
        if(isset($this->legend))
            $form .= "\n<legend>".$this->legend."</legend>";
        
        foreach($this->champs as $champ) {
            $form .= "\n\t" . $champ->create() . "\n\t" . $this->separator;
        }
        
        $token = new Input(array("name" => "token". ++self::$nb_form, "type" => "hidden"));
        $token->setValue($this->generateToken($token->getName()));
        $form .= $token->create();
        
        if($this->fieldset)
            $form .= "\n</fieldset>";
        
        $form .= "\n</form>\n";
        
        return $form;
    }
    
    public function generateToken($name) {
        $token = uniqid(rand(), true);

    	$_SESSION[$name] = array("_token" => $token,
                                     "date" => time());
    	return $token;
    }
    
    public function __toString() {
        return $this->create();
    }
    
    /**
     * Permet d'obtenir la classe
     * @return string
     */
    public function getClass() {
        return $this->class;
    }
    
    /**
     * Permet de modifier la classe
     * @param string $class
     * @return \Form
     */
    public function setClass($class) {
        $this->class = $class;
        return $this;
    }
    
    /**
     * Permet d'obtenir l'id
     * @return string
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Permet de modifier l'id
     * @param string $id
     * @return \Form
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Permet d'obtenir la méthode
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Permet de modifier la méthode
     * @param string $methode
     * @return \Form
     */
    public function setMethod($methode) {
        $this->method = $methode;
        return $this;
    }

    /**
     * Permet d'obtenir l'action
     * @return string
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Permet de modifier l'action
     * @param string $action
     * @return \Form
     */
    public function setAction($action) {
        $this->action = $action;
        return $this;
    }
    
    /**
     * Permet de définir si oui ou non le fieldset est activé
     * @return boolean
     */
    public function getFieldset() {
        return $this->fieldset;
    }

    /**
     * Permet de modifier le booléen fieldset
     * @param boolean $fieldset
     * @return \Form
     */
    public function setFieldset($fieldset) {
        $this->fieldset = $fieldset;
        return $this;
    }
    
    /**
     * Permet d'obtenir la légende
     * @return string
     */
    public function getLegend() {
        return $this->legend;
    }

    /**
     * Permet de modifier la légende
     * @param string $legend
     * @return \Form
     */
    public function setLegend($legend) {
        $this->legend = $legend;
        return $this;
    }
    
    /**
     * Permet d'obtenir le style
     * @return string
     */
    public function getStyle() {
        return $this->style;
    }

    /**
     * Permet de modifier le style
     * @param string $style
     * @return \Form
     */
    public function setStyle($style) {
        $this->style = $style;
        return $this;
    }
    
    /**
     * Permet d'obtenir le séparateur entre les champs
     * @return string
     */
    public function getSeparator() {
        return $this->separator;
    }
    
    /**
     * Permet de modifier les séparateurs entre les champs
     * @param string $separator
     * @return \Form
     */
    public function setSeparator($separator) {
        $this->separator = $separator;
        return $this;
    }
    
    /**
     * Retourne la liste des erreurs après l'appel de la méthode isValid
     * @return array
     */
    public function getErrorsList() {
        return $this->errorsList;
    }
    
    public function hydrate($data) {
        foreach($data as $name => $value) {
            $element = $this->getElementByName($name);
            
            if(!is_null($element)) {
                if($element instanceof Input && $element->getType() == "checkbox") {
                    $element->setChecked(($value != "0"));
                } else {
                    $element->setValue($value);
                }
            }
        }
    }

    public function toArray() {
        $data = array();
        $elements = $this->getAllElements();

        foreach($elements as $name => $element) {
            if(!($element instanceof Input && $element->getType() == "submit")) {
                $value = $element->getValue();
                
                if($element instanceof Input && $element->getType() == "checkbox") {
                    $value = $element->getChecked();
                }
                
                $data[$name] = $value;
            }
        }

        return $data;
    }
        
    /**
     * Méthode de validation d'un formulaire
     * @return boolean
     */
    public function isValid() {
        
        foreach($this->validators as $key => $validator) {
            if(($element = $this->getElementByName($key)) !== null) {
                $validator->setValue($element->getValue());

                if($validator->isValid() === false) {
                    $this->errorsList[$element->getName()] = $validator->getErrorMessage();
                    return false;
                }
            }
        }
        
        return true;
    }

}

?>
