<?php 

namespace App\Repository;

use App\Entity\Person;
use App\Entity\Target;
use App\Entity\Mission;
use App\Db\Mysql;
use App\Controller\Controller;

class TargetRepository extends Repository
{
    public function findOneTargetById(string $id):Target|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM targets WHERE id_target = :id_target");
            $query->bindParam(':id_target', $id, $this->pdo::PARAM_STR);
            $query->execute();
            $target = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($target){
                $targetBDD = new Target();
                $targetBDD->setIdTarget($target['id_target']);
                $targetBDD->setCodeName($target['code_name']);
                $targetBDD->setIdMission($target['id_mission']);
                return $targetBDD;
            }else {
                return false;
            }
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
        }
    }

    public function findAllTargetsByMissionId(int $idMission):array|bool
    {
        try{
            $queryTargets = $this->pdo->prepare("SELECT persons.first_name, persons.last_name, persons.birthdate,
            targets.code_name FROM targets  
            LEFT JOIN persons ON persons.id = targets.id_target
            WHERE targets.id_mission = :idMission");
            $queryTargets->bindParam(':idMission', $idMission, $this->pdo::PARAM_INT);
            $queryTargets->execute();
            $targets = $queryTargets->fetchAll($this->pdo::FETCH_ASSOC);
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
        }
            if ($targets){
                $arrayTargetsName = [];
                foreach ($targets as $target) {
                    $arrayTargetsName[]=$target['first_name']. " " . $target['last_name'] ." ( ". $target['birthdate'] .
                    " ) Code : " . $target['code_name'];
                }
                return $arrayTargetsName;
            }else {
                return false;
            }   
    }

    public function findAllTargets():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT *, CONCAT(persons.first_name,' ',persons.last_name) as complete_name FROM targets 
            LEFT JOIN persons ON persons.id = targets.id_target");
            $query->execute();
            $allTargets = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($allTargets){
                return $allTargets;
            }else {
                return false;
            }
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
        }
    }
}