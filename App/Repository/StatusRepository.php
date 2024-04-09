<?php 

namespace App\Repository;

use App\Controller\Controller;

class StatusRepository extends Repository
{
    public function findOneStatusById(int $id):array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM status WHERE id = :id");
            $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $query->execute();
            $status = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($status){
                return $status;
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

    public function findOneStatusByName(string $name):bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM status WHERE name = :name");
            $query->bindParam(':name', $name, $this->pdo::PARAM_STR);
            $query->execute();
            $status = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($status){
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
    
    public function findAllStatuss():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM status");
            $query->execute();
            $allstatuts = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($allstatuts){
                return $allstatuts;
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

    public function StatusValidate(): array
    {
        $response['result']= false;
        if (empty($_POST['name'])){
            $response['name'] = 'Le champ nom ne doit pas être vide';
            return $response;
        } else{
            $name = $_POST['name'];
            if (strlen($name)>50){
                $response['name'] = 'Le champ nom ne doit pas dépasser 50 caractères';
            }else{
                $response['result']=true;
                $response['object']= $name;
            } 
        }
        return $response;
    }

    public function StatusSaveToDataBase(string $name): array
    {
        
        //recherche s'il y a déjà un élément en BDD du même nom
        if ($this->findOneStatusByName($name)){
            $response['result'] = false;
            $response['exist'] ='Il existe déjà un statut de même nom';
            return $response;
        }else{
            try{
                $pdoAdd = $this->pdo->prepare("INSERT INTO status(name) VALUES (:name)");
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

    function StatusUpdateToDataBase(string $name):array
    {
        $response['result']=false;
        $id = $_GET['id'];
        try{
            $pdoAdd = $this->pdo->prepare("UPDATE status SET name=:name WHERE id=:id");
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
    
}