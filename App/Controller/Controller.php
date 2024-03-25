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
}