<?php 

namespace App\Repository;

use App\Entity\Mission;
use App\Db\Mysql;
use App\Controller\Controller;
use ArrayObject;
use DateTime;

class MissionRepository extends Repository
{
    public function findOneById(int $id):Mission|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM missions WHERE id = :id");
            $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $query->execute();
            $mission = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($mission){
                $missionBDD = new Mission();
                $missionBDD->setid($mission['id']);
                $missionBDD->setTitle($mission['title']);
                $missionBDD->setDescription($mission['description']);
                $missionBDD->setCodeName($mission['code_name']);
                if (!is_null($mission['begin_date'])){
                    $missionBDD->setBeginDate(new DateTime($mission['begin_date']));
                } else {
                    $missionBDD->setBeginDate();
                }
                if (!is_null($mission['end_date'])){
                    $missionBDD->setEndDate(new DateTime($mission['end_date']));
                } else {
                    $missionBDD->setEndDate();
                }
                $missionBDD->setIdCountry($mission['id_country']);
                $missionBDD->setIdStatus($mission['id_status']);
                $missionBDD->setIdTypeMission($mission['id_typeMission']);
                $missionBDD->setIdSpeciality($mission['id_speciality']);
                return $missionBDD;
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

    public function findAllMissions():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM missions ORDER BY title");
            $query->execute();
            $allMissions = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($allMissions){
                return $allMissions;
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