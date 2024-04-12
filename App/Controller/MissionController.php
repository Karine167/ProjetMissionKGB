<?php

namespace App\Controller;

use App\Db\Mysql;
use App\Controller\Controller;
use App\Repository\AgentRepository;
use App\Repository\ContactRepository;
use App\Repository\CountryRepository;
use App\Repository\HideoutRepository;
use App\Repository\MissionRepository;
use App\Repository\SpecialityRepository;
use App\Repository\StatusRepository;
use App\Repository\TargetRepository;
use App\Repository\TypeMissionRepository;

class MissionController extends Controller
{
    public function route():void
    {
        try{
            if (isset($_GET['action'])){
                switch ($_GET['action']){
                    case 'home':
                        $this->home();
                        break;
                    case 'plus':
                        $this->knowMore();
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
        $errors = [];
        $missionRepository = new MissionRepository();
        $allMissions = $missionRepository->findAllMissions();
        if (!$allMissions){
            $errors['mission']='Cette mission n\'existe pas.';
        }
        $this->render('/homeFront', [
            'errors'=> $errors,
            'allMissions' => $allMissions,
        ]);
    }

    protected function knowMore():void
    {
        $errors = [];
        try{
            if (isset($_GET['id'])){
                $id = $_GET['id'];
                //recherche de la mission
                $missionRepository = new MissionRepository();
                $mission = $missionRepository->findOneMissionById($id);
                if (!$mission){
                    $errors['mission']='Cette mission n\'existe pas.';    
                }else {
                    $response = $missionRepository->findAllInformationsOnOneMissionByID($id);
                    $targets = $response['targets'];
                    $contacts = $response['contacts'];
                    $agents = $response['agents'];
                    $status = $response['status'];
                    $typeMission = $response['typeMission'];
                    $country = $response['country'];
                    $speciality = $response['speciality'];
                    $hideouts = $response['hideouts'];
                }
                $this->render('/detailFront', [
                    'errors'=> $errors,
                    'mission' => $mission,
                    'targets' => $targets,
                    'contacts' => $contacts,
                    'agents' => $agents,
                    'status' => $status,
                    'typeMission' => $typeMission,
                    'country' => $country,
                    'speciality' => $speciality,
                    'hideouts' => $hideouts,
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