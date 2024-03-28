<?php 

namespace App\Repository;

use App\Entity\Person;
use App\Entity\Target;
use App\Entity\Mission;
use App\Db\Mysql;
use App\Controller\Controller;

class TargetRepository extends Repository
{
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
}