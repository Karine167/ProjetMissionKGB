<?php

namespace App\Controller;

use App\Db\Mysql;
use App\Controller\Controller;


class BackController extends Controller
{
    public function route():void
    { $Category = ['Person','Target','Agent','Contact','Admin','Country','Speciality','Hideout','TypeHideout','Mission','Status','TypeMission'];
        try{
            if (isset($_GET['action'])){
                switch ($_GET['action']){
                    case 'home':
                        //page d'accueil du BackOffice
                        $this->home();
                        break;
                    case in_array($_GET['action'], $Category):
                        //appel du controller pour l'entité Person
                        $controller = new TodoController();
                        $controller->route();
                        break;
                    
                    default:
                        throw new \Exception("Cette action n'est pas prise en charge.");
                        break;
                }
            }else{
                throw new \Exception("Aucune action spécifiée");
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $this->render('/errors', [
                'error' => $error
            ]);
        }
    }

    protected function home()
    {
        $page=null;
        $this->render('/homeBack', [
            'page'=> $page,
        ]);
    }
}