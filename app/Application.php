<?php

// Pour composer "oQuiz" correspond au répertoire "app"
namespace oQuiz; 

// J'importe les classes qui sont dans un autre namespace
use AltoRouter; // => importe \AltoRouter

// créer la classe qui joue le rôle de FrontController : Application
class Application {
    // Je crée la propriété $router afin que le router soit dispo dans toute ma classe
    private $router;
    // Je crée la propriété $config afin que la config soit dispo dans toute ma classe (et aisni indirectement dans les views (voir CoreController))
    private $config;
    
    // à l'instanciation de la classe Application (dans son constructeur, donc)
    public function __construct() {
        // Récupération des données de la config
        $this->config = parse_ini_file(__DIR__ . '/config.conf');
        
        // instancier le routeur
        $this->router = new AltoRouter();
        
        // configurer le routeur instancié
        $this->router->setBasePath($this->getConfig('BASE_PATH'));
        
        // Appel à la méthode s'occupant de mapper toutes les routes
        $this->defineRoutes();
    }
    
    // Méthode s'occupant de mapper toutes les routes
    public function defineRoutes() {

        // Home
        $this->router->map('GET', '/', 'MainController#indexAction', 'main_home');
        // Page du compte utilisateur
        $this->router->map('GET', '/user/[i:id]', 'QuizController#myAccount', 'user_account');
        // Page d'un quiz
        $this->router->map('GET|POST', '/quiz/[i:id]', 'QuizController#quizDetail', 'quiz_quizdetail');
        // Connexion
        $this->router->map('GET', '/login', 'UserController#login', 'user_login');
        // Connexion en Ajax
        $this->router->map('POST', '/ajax/login', 'UserController#ajaxLogin', 'user_ajaxlogin');
        // Inscription
        $this->router->map('GET', '/signup', 'UserController#signup', 'user_signup');
        // Inscription en Ajax
        $this->router->map('POST', '/ajax/signup', 'UserController#ajaxSignup', 'user_ajaxsignup');
        // Deconnexion
        $this->router->map('POST', '/logout', 'UserController#logout', 'user_logout');

    }

    
    // créer la méthode run qui doit afficher un message (peu importe) qui permet de vérifier qu'elle est bien éxécutée
    public function run() {
        // le routeur doit faire le "match"
        $match = $this->router->match();
        
        // -- DISPATCH --
        
        // Si on trouve une route
        if ($match !== false) {
            // Je récupère les informations sur le controller et la méthode
            $dispatcherInfos = $match['target'];
            //print_r($dispatcherInfos); // debug
            
            // Je sépare les 2 parties se trouvant dans "target" ('MainController#home')
            $controllerAndMethod = explode('#', $dispatcherInfos);
            //print_r($controllerAndMethod); // debug
            
            // Je stocke les noms dans des variables
            $controllerName = $controllerAndMethod[0];
            //echo '<br>$controllerName='.$controllerName.'<br>';
            $methodName = $controllerAndMethod[1];
            //echo '$methodName='.$methodName.'<br>';
            
            // J'ajoute le namespace des Controllers afin d'avoir un FQCN (fully qualified class name)
            $controllerName = 'oQuiz\Controllers\\'.$controllerName; 
            // résultat par exemple : oQuiz\Controllers\MainController
            
            // J'instancie le controller
            // PHP va remplacer la variable $controllerName par sa valeur
            // puis va instancier la bonne classe "new MainController()" par exemple
            // Avec les namespaces, on est obligé de spécifier le FQCN lors d'une instanciation dynamique d'une classe
            // Je passe l'objet Application courant en argument du constructeur
            $controller = new $controllerName($this);
            // J'appelle la méthode correspond à la route
            // PHP va remplacer la variable $methodName par sa valeur
            // puis va appeler la bonne méthode "->home()" par exemple
            $controller->$methodName($match['params']);
        }
        // Si aucun route ne correspond à l'URL courante
        else {
            // J'envoie une header pour spécifier le statut 404 HTTP
            \oQuiz\Controllers\CoreController::sendHttpError(404, '<h2>ERROR 404 - PLEASE LEARN TO CODE</h2>'); // sans utiliser de "use" - TODO changer namespace
        }
    }
    
    // GETTERS
    // Si le type n'est pas le bon => Fatal Error !
    public function getRouter() : AltoRouter {
        return $this->router;
    }
    
    // Retourne une configuration du fichier de config
    public function getConfig(string $param) {
        // Je vérifie que la clé existe dans le tableau
        // ainsi, je suis certain de ne pas générer d'erreur de type NOTICE
        if (array_key_exists($param, $this->config)) {
            return $this->config[$param];
        }
        return false;
    }
}
