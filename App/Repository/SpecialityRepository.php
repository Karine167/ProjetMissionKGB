<?php 

namespace App\Repository;

use App\Controller\Controller;

class SpecialityRepository extends Repository
{
    public function findOneSpecialityById(int $id):array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM specialities WHERE id = :id");
            $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $query->execute();
            $speciality = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($speciality){
                return $speciality;
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
    public function findOneSpecialityByName(string $name):bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM specialities WHERE name = :name");
            $query->bindParam(':name', $name, $this->pdo::PARAM_STR);
            $query->execute();
            $speciality = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($speciality){
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

    public function findAllSpecialitys():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM specialities ORDER BY name");
            $query->execute();
            $allSpecialities = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($allSpecialities){
                return $allSpecialities;
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
    
    public function SpecialityValidate(): array
    {
        $response['result']= false;
        if (empty($_POST['name'])){
            $response['name'] = 'Le champ spécialité ne doit pas être vide';
            return $response;
        } else{
            $speciality = $_POST['name'];
            if (strlen($speciality)>50){
                $response['name'] = 'Le champ spécialité ne doit pas dépasser 50 caractères';
            }else{
                $response['result']=true;
                $response['object']= $speciality;
            } 
        }
        return $response;
    }

    public function SpecialitySaveToDataBase(string $name): array
    {
        
        //recherche s'il y a déjà un élément en BDD du même nom
        if ($this->findOneSpecialityByName($name)){
            $response['result'] = false;
            $response['exist'] ='Il existe déjà un statut de même nom';
            return $response;
        }else{
            try{
                $pdoAdd = $this->pdo->prepare("INSERT INTO specialities(name) VALUES (:name)");
                $pdoAdd->bindParam(':name', $name, $this->pdo::PARAM_STR);
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
    function SpecialityUpdateToDataBase(string $name):array
    {
        $response['result']= false;
        $id = $_GET['id'];
        try{
            $pdoAdd = $this->pdo->prepare("UPDATE specialities SET name=:name WHERE id=:id");
            $pdoAdd->bindParam(':name', $name, $this->pdo::PARAM_STR);
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
    
    public function SpecialityDelete(int $id):void
    {
        if ($_GET['rep'] == 'oui'){
            try{
                $pdoDelete = $this->pdo->prepare("DELETE FROM specialities  WHERE id = :id");
                $pdoDelete->bindParam(':id', $id, $this->pdo::PARAM_INT);
                $pdoDelete->execute();
                $pdoDeleteAgentSpeciality = $this->pdo->prepare("DELETE FROM agents_specialities  WHERE id_speciality = :id_speciality");
                $pdoDeleteAgentSpeciality->bindParam(':id_speciality', $id, $this->pdo::PARAM_INT);
                $pdoDeleteAgentSpeciality->execute();
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