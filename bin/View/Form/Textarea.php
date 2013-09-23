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
     * @param array $tab, les propriétés de Textarea
     */
    public function __construct(array $tab) {
        
        foreach($tab as $prop => $val) {
            $this->$prop = $val;
        }
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
