<?php

namespace App\Controller;

use App\Db\Mysql;
use App\Controller\Controller;
use App\Repository\PersonRepository;

class PersonController extends BackController
{
    public function route():void
    {
        try{
            if (isset($_GET['todo'])){
                switch ($_GET['todo']){
                    case 'home':
                        //page d'accueil du BackOffice de l'entité
                        $this->home();
                        break;
                    case 'delete':
                        // suppression d'un élément
                        $this->deletePerson();
                        break;
                    case 'create':
                        //ajout d'un élément
                        $this->createPerson();
                        break;
                    case 'edit':
                        //ajout d'un élément
                        $this->editPerson();
                        break;
                    default:
                        throw new \Exception("Cette tâche n'est pas prise en charge.");
                        break;
                }
            }else{
                throw new \Exception("Aucune tâche spécifiée");
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
        $page='/partials/person/personHome.php';
        $errors = [];
        $personRepository = new PersonRepository();
        $allPersons = $personRepository->findAllPersons();
        if (!$allPersons) {
            $errors[]='Aucune personne à afficher';
        }
        $this->render('/homeBack', [
            'page'=> $page,
            'allPersons' => $allPersons,
            'errors' => $errors
        ]);
    }
    protected function deletePerson()
    {
      
    }

    protected function createPerson()
    {
       
    }
    protected function editPerson()
    {
   
    }
}