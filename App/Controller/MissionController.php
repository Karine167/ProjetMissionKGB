<?php

namespace App\Controller;

use App\Db\Mysql;
use App\Controller\Controller;
use App\Repository\MissionRepository;
use App\Repository\TargetRepository;

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

    protected function knowMore()
    {
        $errors = [];
        try{
            if (isset($_GET['id'])){
                $id = $_GET['id'];
                $missionRepository = new MissionRepository();
                $mission = $missionRepository->findOneById($id);
                if (!$mission){
                    $errors['mission']='Cette mission n\'existe pas.';    
                }
                $targetRepository = new TargetRepository();
                $targets = $targetRepository->findAllTargetsByMissionId($id);

                $this->render('/detailFront', [
                    'errors'=> $errors,
                    'mission' => $mission,
                    'targets' => $targets,
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