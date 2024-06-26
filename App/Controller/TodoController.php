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
                        //édition d'un élément
                        $this->editElement();
                        break;
                    case 'complete':
                        //complétion d’une mission avec les planques, contacts, cibles et agents
                        $this->completeMission();
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
        $entity = $_GET['action'];
        $page='/partials/'.$entity.'/'.'Home.php';
        $errors = "";
        $entityMethod = 'findAll'.$entity.'s';
        $repository = $this->newRepository($entity);
        $allElements = $repository->$entityMethod();
        if (!$allElements) {
            $errors='Aucun élément à afficher';
        }
        $entity = $_GET['action'];
        $page='/partials/'.$entity.'/'.'Home.php';
        $errors = [];
        if (isset($_GET['rep']) && $_GET['rep'] == 'oui'){
            $entityMethod = $entity.'Delete';
            $repository = $this->newRepository($entity);
            $repository->$entityMethod($_GET['id']);
            $this->home();
        }
        $this->render('/homeBack', [
            'page'=> $page,
            'errors' => $errors,
            'allElements' => $allElements,
        ]); 
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
                $entityUpdate = $entity.'UpdateToDataBase';
                $responseUpdate = $repository->$entityUpdate($responseValidate['object']);
                if ($responseUpdate['result']==false){
                    foreach ($responseUpdate as $key => $value ){
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

    protected function completeMission()
    {
        $errors = [];
        $page='/partials/Mission/FormComplete.php';
        try{
            if (isset($_GET['id'])){
                $idMission = $_GET['id'];
                $personRepository = new PersonRepository();
                //recherche de la mission
                $missionRepository = new MissionRepository();
                $mission = $missionRepository->findOneMissionById($idMission);
                if (!$mission){
                    $errors['mission']='Cette mission n\'existe pas.';    
                }else {
                    
                    $response = $missionRepository->findAllInformationsOnOneMissionByID($idMission);
                    $targets = $response['targets'];
                    $contacts = $response['contacts'];
                    $agents = $response['agents'];
                    $status = $response['status'];
                    $typeMission = $response['typeMission'];
                    $country = $response['country'];
                    $speciality = $response['speciality'];
                    $hideoutsMission = $response['hideouts'];
                    //Ajout et suppression des planques
                    $hideoutRepository = new HideoutRepository();
                    $idHideoutsArray = $hideoutRepository->findAllIdHideoutsByMissionId($idMission);
                    $hideoutsDB = $hideoutRepository->findAllHideouts();
                    //Ajout et suppression des contacts
                    $contactRepository = new ContactRepository();
                    $idContactsArray = $contactRepository->findAllIdContactsByMissionId($idMission);
                    $contactsDB = $contactRepository->findAllContacts();
                    //Ajout et suppression des cibles
                    $targetRepository = new TargetRepository();
                    $idTargetsArray = $targetRepository->findAllIdTargetsByMissionId($idMission);
                    $targetsDB = $targetRepository->findAllTargets();
                    //Ajout et suppression des Agents ayant la spécialité requise
                    $agentRepository = new AgentRepository();
                    $idSpeciality = $mission->getIdSpeciality();
                    $idAgentsSpecialityArray = $agentRepository->findAllIdAgentsByIdSpeciality($idSpeciality);
                    $agentsDB = $agentRepository->findAllAgents();
                    $idAgentsArray = $agentRepository->findAllIdAgentsByMissionId($idMission);
                    if (isset($_POST['completeMission'])){
                        //tableau des nouvelles cibles
                        if (isset($_POST['targets']) && !is_null($_POST['targets'])){
                            $newTargets = $_POST['targets'];
                        } else {
                            $newTargets = null;
                        }
                        //tableau des nouveaux agents
                        if (isset($_POST['agentsSpeciality'])){
                            if (isset($_POST['agentsNoSpeciality'])) {
                                $newAgents = array_merge($_POST['agentsSpeciality'], $_POST['agentsNoSpeciality']);
                            } else {
                                $newAgents = $_POST['agentsSpeciality'];
                            }
                        }else{
                            if (isset($_POST['agentsNoSpeciality'])) {
                                $newAgents = $_POST['agentsNoSpeciality'];
                            } else {
                                $newAgents = null;
                            }
                        }
                        // Vérification des nationalités agents-cibles
                        if (!is_null($newAgents)  && !is_null($newTargets)){
                            foreach ($newAgents as $newAgent){
                                if (!is_null($newAgent)){
                                    foreach ($newTargets as $newTarget) {
                                        if (!is_null($newTarget)){
                                            $idsCountryTarget = $personRepository->findAllIdCountryByIdPerson($newTarget);
                                            $idsCountryAgent = $personRepository->findAllIdCountryByIdPerson($newAgent);
                                            if ($idsCountryTarget && $idsCountryAgent){
                                                $intersect = array_intersect($idsCountryTarget, $idsCountryAgent);
                                                if (!empty($intersect)){
                                                    $agentNoCorrect = $personRepository->findOnePersonById($newAgent);
                                                    $errors['agents']="Vous ne pouvez pas choisir l'agent : " . $agentNoCorrect->getLastName() . " " . $agentNoCorrect->getFirstName() . ", car il a la même nationalité qu'une des cibles."; 
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                            
                        if (empty($errors)){
                            $agentRepository->UpdateIdMission($idAgentsArray, $idMission, $newAgents);
                            $targetRepository->UpdateIdMission($idTargetsArray, $idMission, $newTargets );

                            if (isset($_POST['hideouts']) && !is_null($_POST['hideouts'])){
                                $hideoutRepository->UpdateIdMission($idHideoutsArray, $idMission, $_POST['hideouts'] );
                            }
                            if (isset($_POST['contacts']) && !is_null($_POST['contacts'])){
                                $contactRepository->UpdateIdMission($idContactsArray, $idMission, $_POST['contacts'] );
                            } 
                            $this->home();
                        }
                        
                    }
                }
                $this->render('/homeBack', [
                    'page' => $page,
                    'errors'=> $errors,
                    'mission' => $mission,
                    'targets' => $targets,
                    'contacts' => $contacts,
                    'agents' => $agents,
                    'status' => $status,
                    'typeMission' => $typeMission,
                    'country' => $country,
                    'speciality' => $speciality,
                    'hideouts' => $hideoutsMission,
                    'hideoutsDB' => $hideoutsDB,
                    'idHideoutsArray' =>$idHideoutsArray,
                    'contactsDB' => $contactsDB,
                    'idContactsArray' => $idContactsArray,
                    'targetsDB' => $targetsDB,
                    'idTargetsArray' => $idTargetsArray,
                    'idAgentsSpecialityArray' => $idAgentsSpecialityArray,
                    'agentsDB' => $agentsDB,
                    'idAgentsArray' => $idAgentsArray,
                ]);     
            }else{
                throw new \Exception("Aucun id spécifié");
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $this->render('/errors', [
                'error' => $error
            ]);
        }
    }
}