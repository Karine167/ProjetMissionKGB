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

    public function MissionValidate(): array
    {
        $response['result']= false;
        $fields=['title', 'idCountry', 'idStatus', 'idTypeMission', 'idSpeciality'];
        foreach ($fields as $field) {
            if (empty($_POST[$field])){
                $response[$field] = 'Ce champ ne doit pas être vide';
                return $response;
            }
        } 
        
        if (strlen($_POST['title'])>50){
            $response['title'] = 'Le titre ne doit pas avoir plus de 50 caractères';
            return $response; 
        }
        
        $mission = new Mission(); 
        $mission->setTitle($_POST['title']);
        if (empty($_POST['description'])){
            $mission->setDescription(null);
        }else{
            $mission->setDescription($_POST['description']);
        }
        if (!empty($_POST['beginDate'])){
            $beginDate = $_POST['beginDate'];
            if (!preg_match('/^[\d-]*/', $beginDate)){
                $response['beginDate'] = 'Cette date n\'est pas au bon format !';
                return $response; 
            } elseif (!checkdate(intval(substr($beginDate,5,2)),intval(substr($beginDate,8,2)),intval(substr($beginDate,0,4)))) {
                $response['beginDate'] = 'Cette date n\'existe pas !';
                return $response; 
            }
        }
        if (!empty($_POST['endDate'])){
            $endDate = $_POST['endDate'];
            if (!preg_match('/^[\d-]*/', $endDate)){
                $response['endDate'] = 'Cette date n\'est pas au bon format !';
                return $response; 
            } elseif (!checkdate(intval(substr($endDate,5,2)),intval(substr($endDate,8,2)),intval(substr($endDate,0,4)))) {
                $response['endDate'] = 'Cette date n\'existe pas !';
                return $response; 
            }
        }
        if (empty($_POST['beginDate'])){
            $mission->setBeginDate(null);
        } else { 
            $mission->setBeginDate(date_create($_POST['beginDate']));
        }
        if (empty($_POST['beginDate'])){
            $mission->setEndDate(null);
        } else {
            $mission->setEndDate(date_create($_POST['endDate']));
        }
        if ($mission->getBeginDate() && $mission->getEndDate()){
            if ($mission->getBeginDate() > $mission->getEndDate()){
                $response['endDate']='La date finale de la mission doit être supérieure ou égale à la date de début de mission';
                return $response;
            }
        }
        $mission->setIdTypeMission($_POST['idTypeMission']);
        $mission->setIdCountry($_POST['idCountry']);
        $mission->setIdStatus($_POST['idStatus']);
        $mission->setIdSpeciality($_POST['idSpeciality']);
        $codeMission = substr(substr($mission->getTitle(),0,5).'-'.substr($mission->getIdTypeMission(),0,5).'-'.$mission->getIdCountry().'-'.$mission->getIdSpeciality().date("m.d.Y.h.i.s"),0,60);
        $mission->setCodeName($codeMission);        
        $response['result']= true;
        $response['object']= $mission;
        return $response;    
    }

    public function MissionSaveToDataBase(Mission $mission): array
    { 

        $title = $mission->getTitle();
        $description = $mission->getDescription();
        $codeName = $mission->getCodeName();
        if ($mission->getBeginDate()){
            $beginDate = date_format($mission->getBeginDate(), 'Y-m-d');
        }else{ 
            $beginDate = null;
        }
        if ($mission->getEndDate()){
            $endDate = date_format($mission->getEndDate(), 'Y-m-d');
        }else{
            $endDate = null;
        }
        $idCountry = $mission->getIdCountry();
        $idStatus = $mission->getIdStatus();
        $idTypeMission = $mission->getIdTypeMission();
        $idSpeciality = $mission->getIdSpeciality();
        
        try{
            $pdoAdd = $this->pdo->prepare("INSERT INTO missions(title, description, code_name, begin_date, end_date, id_country, id_status, id_typeMission, id_speciality ) VALUES (:title, :description, :code_name, :begin_date, :end_date, :id_country, :id_status, :id_typeMission, :id_speciality ) ");
            $pdoAdd->bindParam(':title', $title, $this->pdo::PARAM_STR);
            $pdoAdd->bindParam(':description', $description, $this->pdo::PARAM_STR|null);
            $pdoAdd->bindParam(':code_name', $codeName, $this->pdo::PARAM_STR);
            $pdoAdd->bindParam(':begin_date', $beginDate, $this->pdo::PARAM_STR|null);
            $pdoAdd->bindParam(':end_date', $endDate , $this->pdo::PARAM_STR|null);
            $pdoAdd->bindParam(':id_country', $idCountry, $this->pdo::PARAM_INT);
            $pdoAdd->bindParam(':id_status', $idStatus , $this->pdo::PARAM_INT);
            $pdoAdd->bindParam(':id_typeMission', $idTypeMission , $this->pdo::PARAM_INT);
            $pdoAdd->bindParam(':id_speciality', $idSpeciality , $this->pdo::PARAM_INT);
            $pdoAdd->execute();
            $response['result']= true;
        }catch (\Exception $e){
                $error = $e->getMessage();
                $control = new Controller();
                $control->render('/errors', [
                    'error' => $error
                ]);
        }
        $response['result']=true;
        $_POST=[];
        return $response;
    }
    
}