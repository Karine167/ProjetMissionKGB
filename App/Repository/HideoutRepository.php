<?php 

namespace App\Repository;

use App\Controller\Controller;

class HideoutRepository extends Repository
{
    public function findAllHideoutsByMissionId(int $idMission):array|bool
    {
        try{
            $queryHideouts = $this->pdo->prepare("SELECT hideouts.*, typeHideouts.type_hide, countries.country_name FROM hideouts 
            LEFT JOIN typeHideouts ON typeHideouts.id = hideouts.id_typeHide
            LEFT JOIN countries ON countries.id = hideouts.id_country
            LEFT JOIN missions ON missions.id = hideouts.id_mission
            WHERE missions.id = :idMission");
            $queryHideouts->bindParam(':idMission', $idMission, $this->pdo::PARAM_INT);
            $queryHideouts->execute();
            $hideouts = $queryHideouts->fetchAll($this->pdo::FETCH_ASSOC);
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
        }
            if ($hideouts){
                $arrayHideoutsName = [];
                foreach ($hideouts as $hideout) {
                    $arrayHideoutsName[]=$hideout['code_hide']. " ( " . $hideout['type_hide'] ." ) : ". $hideout['address'] .
                    ", " . $hideout['zipcode'] . ", " . $hideout['city'] . ", " . $hideout['country_name'];
                }
                return $arrayHideoutsName;
            }else {
                return false;
            }
        
    }

    public function findAllHideouts():array|bool
    {
        try{
            $queryHideouts = $this->pdo->prepare("SELECT hideouts.*, typeHideouts.type_hide, countries.country_name FROM hideouts 
            LEFT JOIN typeHideouts ON typeHideouts.id = hideouts.id_typeHide
            LEFT JOIN countries ON countries.id = hideouts.id_country");
            $queryHideouts->execute();
            $hideouts = $queryHideouts->fetchAll($this->pdo::FETCH_ASSOC);
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
        }
            if ($hideouts){
                return $hideouts;
            }else {
                return false;
            }
        
    }
}