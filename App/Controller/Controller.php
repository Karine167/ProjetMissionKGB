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
                    if (empty($_GET['action'])){
                        $_GET['action']='home';
                    }
                    $homeController = new MissionController();
                    $homeController->route();
                    break;
                case 'auth':
                    // aller au formulaire d'authentification
                    $controller = new AuthController();
                    $controller->route();
                    break;
                case 'back':
                    // afficher la page d'accueil du back
                    $controller = new BackController();
                    $controller->route();
                default :
                    //erreur
                    break;
            }
        }else {
            // charger la page d'accueil du front
            $_GET['action']='home';
                    $homeController = new MissionController();
                    $homeController->route();
        }
    }

    public function render(string $view, array $parameters = []): void
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