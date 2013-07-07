<?php

/**
 * Description of Textarea
 *
 * Classe représentant la balise Textarea
 * 
 * @author Stéphane
 */
class Textarea extends FormElement {
    
    private $rows;      // Nombre de lignes
    private $cols;      // Nombre de colonnes
    
    /**
     * Constructeur de la balise Textarea
     * @param string $name
     * @param int $cols Nombre de colonnes
     * @param int $rows Nombre de lignes
     * @param string $value
     */
    public function __construct($name, $cols, $rows, $value = null) {
        
        parent::__construct($name);
        
        $this->cols = $cols;
        $this->rows = $rows;
        
        if($value !== null)
            $this->setValue($value);
    }
    
    /**
     * Méthode permettant de créer la balise textarea
     * @return string
     */
    public function create() {
        $textarea = parent::create();
        
        if(isset($this->rows)) {
            $textarea .= ' rows="' . $this->rows . '"';
        }
        
        if(isset($this->cols)) {
            $textarea .= ' cols="' . $this->cols . '"';
        }
        
        $textarea .= ">";
        
        if(!is_null($this->getValue())) {
            $textarea .= $this->getValue();
        }
        
        $textarea .= "</textarea>";
        
        return $textarea;
    }
    
    /**
     * Permet d'obtenir le nombre de lignes
     * @return int
     */
    public function getRows() {
        return $this->rows;
    }

    /**
     * Permet de modifier le nombre de lignes
     * @param int $rows
     */
    public function setRows(int $rows) {
        $this->rows = $rows;
    }

    /**
     * Permet d'obtenir le nombre de colonnes
     * @return int
     */
    public function getCols() {
        return $this->cols;
    }

    /**
     * Permet de modifier le nombre de colonnes
     * @param int $cols
     */
    public function setCols(int $cols) {
        $this->cols = $cols;
    }
}

?>
