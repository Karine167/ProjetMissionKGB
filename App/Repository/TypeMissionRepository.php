<?php 

namespace App\Repository;

use App\Controller\Controller;

class TypeMissionRepository extends Repository
{
    public function findOneTypeMissionById(int $id):array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM typeMissions WHERE id = :id");
            $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $query->execute();
            $typeMission = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($typeMission){
                return $typeMission;
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

    public function findOneTypeMissionByName(string $typeMission):bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM typeMissions WHERE type_mission = :type_mission");
            $query->bindParam(':type_mission', $typeMission, $this->pdo::PARAM_STR);
            $query->execute();
            $typeMissionBDD = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($typeMissionBDD){
                return true;
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

    public function findAllTypeMissions():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM typeMissions");
            $query->execute();
            $alltypeMissions = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($alltypeMissions){
                return $alltypeMissions;
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

    public function TypeMissionValidate(): array
    {
        $response['result']= false;
        if (empty($_POST['typeMission'])){
            $response['typeMission'] = 'Le champ nom ne doit pas être vide';
            return $response;
        } else{
            $typeMission = $_POST['typeMission'];
            if (strlen($typeMission)>50){
                $response['typeMission'] = 'Le champ nom ne doit pas dépasser 50 caractères';
            }else{
                $response['result']=true;
                $response['object']= $typeMission;
            } 
        }
        return $response;
    }

    public function TypeMissionSaveToDataBase(string $typeMission): array
    {
        
        //recherche s'il y a déjà un élément en BDD du même nom
        if ($this->findOneTypeMissionByName($typeMission)){
            $response['result'] = false;
            $response['exist'] ='Il existe déjà un type de mission de même nom';
            return $response;
        }else{
            try{
                $pdoAdd = $this->pdo->prepare("INSERT INTO typeMissions(type_mission) VALUES (:type_mission)");
                $pdoAdd->bindParam(':type_mission', $typeMission, $this->pdo::PARAM_STR);
                $pdoAdd->execute();
                $response['result']= true;
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
        }
        return $response;
    }
    function TypeMissionUpdateToDataBase(string $typeMission):array
    {
        $response['result']= false;
        $id = $_GET['id'];
        try{
            $pdoAdd = $this->pdo->prepare("UPDATE typeMissions SET type_mission = :type_mission WHERE id = :id");
            $pdoAdd->bindParam(':type_mission', $typeMission, $this->pdo::PARAM_STR);
            $pdoAdd->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $pdoAdd->execute();
            $response['result']= true;
        }catch (\Exception $e){
                $error = $e->getMessage();
                $control = new Controller();
                $control->render('/errors', [
                    'error' => $error
                ]);
        }
        return $response;
    }

    public function TypeMissionDelete(int $id):void
    {
        if ($_GET['rep'] == 'oui'){
            try{
                $pdoDelete = $this->pdo->prepare("DELETE FROM typeMissions  WHERE id = :id");
                $pdoDelete->bindParam(':id', $id, $this->pdo::PARAM_INT);
                $pdoDelete->execute();
                $response['result']= true;
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
        }
    }
}