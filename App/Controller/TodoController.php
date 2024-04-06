<?php

namespace App\Controller;

use App\Db\Mysql;
use App\Controller\Controller;
use App\Repository;
use App\Repository\AdminRepository;
use App\Repository\AgentRepository;
use App\Repository\ContactRepository;
use App\Repository\CountryRepository;
use App\Repository\HideoutRepository;
use App\Repository\MissionRepository;
use App\Repository\PersonRepository;
use App\Repository\SpecialityRepository;
use App\Repository\StatusRepository;
use App\Repository\TargetRepository;
use App\Repository\TypeHideoutRepository;
use App\Repository\TypeMissionRepository;

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
        $repository = $this->newRepository($entity);
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
        $entity = $_GET['action'];
        $page='/partials/'.$entity.'/'.'Form.php';
        $errors = [];
        if (isset($_POST[$entity])){
            $entityMethod = $entity.'Validate';
            $repository = $this->newRepository($entity);
            $responseValidate = $repository->$entityMethod();
            if ($responseValidate['result']==false){
                foreach ($responseValidate as $key => $value ){
                    $errors[$key]=$value;
                }
            }else{
                $entitySave = $entity.'SaveToDataBase';
                $responseSave = $repository->$entitySave($responseValidate['object']);
                if ($responseSave['result']==false){
                    foreach ($responseSave as $key => $value ){
                        $errors[$key]=$value;
                    }
                } else { 
                $errors['save']= 'L\'enregistrement a été correctement effecué';
                }
            }
        }
        $this->render('/homeBack', [
            'page'=> $page,
            'errors' => $errors,
            
        ]); 
    }
    protected function editElement()
    {
   
    }

    public function newRepository($entity)
    {
        switch ($entity){
            case 'Person':
                $repository = new PersonRepository();
                break;
            case 'Target': 
                $repository = new TargetRepository();
                break;
            case 'Agent': 
                $repository = new AgentRepository();
                break;
            case 'Contact': 
                $repository = new ContactRepository();
                break;
            case 'Admin': 
                $repository = new AdminRepository();
                break;
            case 'Country': 
                $repository = new CountryRepository();
                break;
            case 'Speciality': 
                $repository = new SpecialityRepository();
                break;
            case 'Hideout': 
                $repository = new HideoutRepository();
                break;
            case 'TypeHideout': 
                $repository = new TypeHideoutRepository();
                break;
            case 'Mission': 
                $repository = new MissionRepository();
                break;
            case 'Status': 
                $repository = new StatusRepository();
                break;
            case 'TypeMission': 
                $repository = new TypeMissionRepository();
                break;
            default:
                    throw new \Exception("Ce repository n'est pas pris en charge :" .$entity);
                    break;
            }
            return $repository;
    }
}