CadmusFramework
===

CadmusFramework est un framework PHP léger et facile d'utilisation.
Il permet de développer très rapidement une application web. Basé sur le design pattern Model View Controller, 
CadmusFramework offre une bonne gestion des modèles et contrôleurs.
Quant à la vue, le moteur de template Twig est utilisé.

#### Comment l'utiliser ? 
	Il suffit de placer le dossier CadmusFramework dans le dossier de votre projet.

Exemple de point d'entrée :
---

```php
    // index.php
  
    require 'CadmusFramework/Cadmus.php';
	
	$app = new Cadmus("nom_du_projet", "action_par_defaut");
	
	// Configuration via un tableau
	$app->config(array('hostname' => '...',
					   'dbname' => '...',
					   'login' => '...',
					   'password' => '...',
					   // layout est ici le nom du dossier contenant l'ensemble des fichier .twig
					   'layout' => '...'));
	
	$app->run();
  
```


Exemple de modèle :
---

* Tous les attributs de tous vos modèles doivent être définis en temps que "protected" afin que la classe mère
puisse accéder à ceux-ci.
* Le premier attribut doit correspondre à la clé définie dans la table associée à l'entité
* Le nom de la classe et le nom de la table doivent être les mêmes 

```php
	
	class MonModele extends Model {
		
		protected $attribut1;
		protected $attribut2;
		protected $attribut3;
		
	}
	
```

Les accesseurs et mutateurs sont gérés automatiquement par la classe Model, aucun besoin de les définir soit-même.
De plus, des méthodes find, findBy, findAll ... sont à disposition afin de récupérer les objets souhaités étant des
instances de ce modèle.

Exemple de contrôleur :
---

* Tous les noms de contrôleurs doivent se terminer par "Controller" 
* Toutes les méthodes étant utiles en temps qu'action doivent se terminer par "Action"
 
Exemple : L'url "index.php/monController/uneAction" sera le résultat de l'exécution de la méthode uneActionAction 
du contrôleur MonControleurController

```php

  class MonControleurController extends Controller {
  
  	// méthode héritée depuis la classe Controller, c'est l'action par défaut
  	public function defaultAction() {
  		...
  		$this->render("mapagetwig.html.twig", array(...));
  	}
  	
  	public function uneActionAction() {
  		...
  		$this->redirect("monController#default");
    }
    
  }

```
