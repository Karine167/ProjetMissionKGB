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
            $queryIdTargets = $this->pdo->prepare("SELECT persons.first_name, persons.last_name, persons.birthdate,
            targets.code_name FROM targets  
            LEFT JOIN persons ON persons.id = targets.id_target
            WHERE targets.id_mission = :idMission");
            $queryIdTargets->bindParam(':idMission', $idMission, $this->pdo::PARAM_INT);
            $queryIdTargets->execute();
            $targets = $queryIdTargets->fetchAll($this->pdo::FETCH_ASSOC);
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
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
        }
    }
}