<?php 

namespace App\Controller;

use App\Db\Mysql;
use App\Repository\AdminRepository;

class Controller
{
    public function route():void
    {
        if (isset($_GET['controller'])){
            switch ($_GET['controller']){
                case 'front':
                    // afficher la page d'accueil du front
                    require_once _TEMPLATEPATH_.'/homeFront.php';
                    var_dump ("accueil Front");
                    break;
                case 'auth':
                    // aller au formulaire d'authentification
                    $controller = new AuthController();
                    $controller->route();
                    break;
                case 'back':
                    // afficher la page d'accueil du back
                    require_once _TEMPLATEPATH_.'/homeBack.php';
                    var_dump ("accueil Back");
                default :
                    //erreur
                    break;
            }
        }else {
            // charger la page d'accueil du front
            require_once _TEMPLATEPATH_.'/homeFront.php';
        }
    }

    protected function render(string $view, array $parameters = []): void
    {
        $viewPath = _TEMPLATEPATH_ . $view . '.php';

        try {
            if (!file_exists($viewPath)) {
                throw new \Exception("Ce fichier n'existe pas : " . $viewPath);
            }else {
                extract($parameters);
                require_once $viewPath;
            }
        }catch (\Exception $e) {
            $error = $e->getMessage();
            $this->render('/errors', [
                'error' => $error
            ]);
        }
    }
}