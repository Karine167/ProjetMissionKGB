<?php

namespace App\Controller;

use App\Db\Mysql;
use App\Controller\Controller;
use App\Repository;
use App\Repository\PersonRepository;
use App\Repository\TargetRepository;

class TodoController extends BackController
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
                        $this->deleteElement();
                        break;
                    case 'create':
                        //ajout d'un élément
                        $this->createElement();
                        break;
                    case 'edit':
                        //ajout d'un élément
                        $this->editElement();
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
        $entity = $_GET['action'];
        $page='/partials/'.$entity.'/'.'Home.php';
        $errors = [];
        $entityMethod = 'findAll'.$entity.'s';
        switch ($entity){
            case 'Person':
                $repository = new PersonRepository();
                break;
            case 'Target': 
                $repository = new TargetRepository();
                break;
            default:
                    throw new \Exception("Ce repository n'est pas prise en charge :" .$entity);
                    break;
            }
        $allElements = $repository->$entityMethod();
        if (!$allElements) {
            $errors[]='Aucun élément à afficher';
        }
        $this->render('/homeBack', [
            'page'=> $page,
            'allElements' => $allElements,
            'errors' => $errors
        ]);
    }
    protected function deleteElement()
    {
      
    }

    protected function createElement()
    {
       
    }
    protected function editElement()
    {
   
    }
}