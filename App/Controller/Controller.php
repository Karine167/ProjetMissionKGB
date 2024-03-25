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
                    var_dump ("accueil Front");
                    break;
                case 'auth':
                    // aller au formulaire d'authentification
                    var_dump ("Authentification");
                    $adminRepository = new AdminRepository();
                    $admin = $adminRepository->findOneByEmail('john.doe@test.com');
                    var_dump($admin);
                    break;
                case 'back':
                    // afficher la page d'accueil du back
                    var_dump ("accueil Back");
                default :
                    //erreur
                    break;
            }
        }else {
            // charger la page d'accueil du front
        }
    }
}