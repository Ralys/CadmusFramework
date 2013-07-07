<?php

/**
 * Description of Controller
 *
 * Classe abstraite du Controller
 * 
 * @author Stéphane
 */
abstract class Controller {
    
    protected $persist = array();   // Tableau contenant tous les modèles que l'on souhaite persister
    protected $params;               // Paramètre de l'url
    protected $request;             // HTTPRequest (get, post)
    protected $twig;                // Moteur de template twig
    
    /**
     * Constructeur prenant en paramètre l'éventuel paramètre que l'on peut
     * retrouver dans l'URL.
     * Initialise les paramètres, l'objet HTTPRequest et l'objet Twig
     * @param string $param
     */
    public function __construct($params = null) {
        $this->params = $params;
        $this->request = new HTTPRequest();
        $this->twig = Twig::getTwig();
    }
    
    /**
     * Action par défaut du contrôleur
     */
    public abstract function defaultAction();
    
    /**
     * Accesseur de données enregistrées dans la variable globale $_SESSION
     * @param string $data
     * @return type 
     */
    public function get($data) {
        if(isset($_SESSION[$data])) {
            $value =  $_SESSION[$data];
            unset($_SESSION[$data]);
            
            return $value;
        } else
            return null;
    }
    
    /**
     * Mutateur de données enregistrées dans la variable globale $_SESSION
     * @param string $data
     * @param type $value 
     */
    public function set($data, $value) {
        $_SESSION[$data] = $value;
    }
    
    /**
     * Méthode permettant de mettre un message dit "flash" (message de durée de vie éphémère)
     * @param string $status
     * @param string $message 
     */
    public function flash($status, $message) {
        $_SESSION['flash'] = array('status' => $status, 
                                   'message' => $message);
    }
        
    /**
     * Fonction statique permettant de génerer une URL
     * @param string $route
     * @param array $params
     * @return string url
     */
    public static function generateURL($route, array $params = null) {
        $t_route = explode("#", $route);
        $url = $t_route[0] . "/" . $t_route[1] . "/";
        
        if($params != null) {
            if(count($params) == 1) {
                $url.= $params[key($params)];
            } else {
                $separator = '-';
                $url .= implode($separator, $params);
            }
        }
        
        return DOMAIN . "/" . $url;
    }
    
    /**
     * Méthode de redirection permettant de rediriger vers un lien
     * @param string $route de la forme "controleur#action" ou directement l'URL généré par le router
     * @param array $params Les paramètres peuvent contenir l'id et d'autres éléments qui seront
     * séparés par un "-" dans l'URL
     */
    public function redirect($route, $params = null) {
        $url = self::generateURL($route, $params);
        header('Location: ' . $url);
        return;
    }
    
    /**
     * Méthode permettant d'afficher du contenu à partir d'une page twig
     * et d'un tableau de valeurs
     * @param string $pageTwig
     * @param array $params tableau de valeurs
     */
    public function render($pageTwig, array $params = array()) {
        $params['appname'] = APPNAME;
        $params['flash'] = $this->get("flash");
        echo $this->twig->render($pageTwig, $params);
    }
    
    /**
     * Méthode permettant d'ajouter un modèle que l'on souhaite persister/sauvegarder
     * @param Model model
     */
    public function persist(Model $model) {
        $this->persist[] = $model;
    }

    /**
    * Méthode permettant d'enregistrer en BDD tous les modèles enregistrés dans le tableau persist
    */
    public function flush() {
        foreach($this->persist as $model) {
            $model->save();
        }
    }
    
    /**
     * Méthode permettant d'obtenir le nom sans "Controller" du contrôleur
     * @return string
     */
    public function getName() {
       $class = get_class($this);
       $pos = strpos($class, "Controller");
       
       $name = lcfirst(substr($class, 0, $pos));
       
       return $name;
    }
    
    public function checkToken() {
        $name = "";
        $time = 600;
        $check = false;

        // Pour chaque valeur dans la session
        foreach($_SESSION as $key => $value) {
            if(strcasecmp(substr($key, 0, 5), "token") == 0) {
                
                if(isset($_POST[$key])) {
                    $name = $key;
                    break;
                }
            }
        }
        
        if($name == "") return false;

        if(isset($_SESSION[$name]) && isset($_SESSION[$name]['date'])) { 
                if($_SESSION[$name]['_token'] == $_POST[$name]) {
                        if ($_SESSION[$name]['date'] >= (time() - $time)) {
                                $check = true;
                        }
                }
        }

	return $check;
    }
    
    public function checkForm(Form $form) {
        $form->hydrate($this->request->post());
        return $form->isValid() && $this->checkToken();
    }
}

?>
