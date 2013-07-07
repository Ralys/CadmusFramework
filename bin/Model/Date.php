<?php

Date::$timezone = new DateTimeZone('Europe/Paris');

/**
 * Description of Date
 *
 * Classe permettant de gérer les dates plus facilement
 * 
 * @author Stéphane
 */

class Date {
    
    public static $timezone;    // Timezone
    private $date_format_en;    // DateTime
    private $date_format_fr;    // string
    
    /**
     * Constructeur qui permet d'obtenir le format américain et le format français
     * @param DateTime|string $date
     */
    public function __construct($date = null) {
        
        if($date == null) {
            $current_date = new DateTime();
            $current_date->setTimezone(self::$timezone);
            
            $this->date_format_en = $current_date;
            $this->date_format_fr = self::ENToFR($this->date_format_en);
        } else {
            if($date instanceof DateTime) {
                $date->setTimezone(self::$timezone);
                $this->date_format_en = $date;
                $this->date_format_fr = self::ENToFR($this->date_format_en);
            } else if (is_string($date) && strstr($date, '-')) {
                $this->date_format_en = new DateTime($date);
                $this->date_format_fr = self::ENToFR($this->date_format_en);
            } else if (is_string($date) && strstr($date, '/')) {
                $this->date_format_en = self::FRToEN($date);
                $this->date_format_fr = $date;
            }
        }
    }
    
    /**
     * Méthode permettant d'obtenir le format enregistré en base de données
     * @return string
     */
    public function englishFormat() {
        return $this->date_format_en->format('Y-m-d H:i:s');;
    }
    
    /**
     * Méthode permettant d'obtenir le format français de la date
     * @return string
     */
    public function frenchFormat() {
        return $this->date_format_fr;
    }
    
    /**
     * Méthode statique permettant de convertir une date du format anglais au format français
     * @param DateTime $date
     * @return string
     */
    public static function ENToFR(DateTime $date) {
        return $date->format('d/m/Y');
    }
    
    /**
     * Méthode statique permettant de convertir une date du format français au format anglais
     * @param string $date
     * @return \DateTime
     */
    public static function FrToEN($date) {
        $date_tab = explode("/", $date);
        $date = $date_tab[2] . "-" . $date_tab[1] . "-" . $date_tab[0];
        
        return new DateTime($date);
    }
    
}

?>
