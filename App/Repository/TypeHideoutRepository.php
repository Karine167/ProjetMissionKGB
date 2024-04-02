<?php 

namespace App\Repository;

use App\Controller\Controller;

class TypeHideoutRepository extends Repository
{
    public function findOneTypeHideoutByName(string $typeHide):bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM typeHideouts WHERE type_hide = :type_hide");
            $query->bindParam(':type_hide', $typeHide, $this->pdo::PARAM_STR);
            $query->execute();
            $typeHideout = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($typeHideout){
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
    public function findAllTypeHideouts():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM typeHideouts ORDER BY type_hide");
            $query->execute();
            $alltypeHideouts = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($alltypeHideouts){
                return $alltypeHideouts;
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
    public function TypeHideoutValidate(): array
    {
        $response['result']= false;
        if (empty($_POST['typeHide'])){
            $response['typeHide'] = 'Le champ type ne doit pas être vide';
            return $response;
        } else{
            $typeHide = $_POST['typeHide'];
            if (strlen($typeHide)>50){
                $response['typeHide'] = 'Le champ nom ne doit pas dépasser 50 caractères';
            }else{
                $response['result']=true;
                $response['object']= $typeHide;
            } 
        }
        return $response;
    }

    public function TypeHideoutSaveToDataBase(string $typeHide): array
    {
        
        //recherche s'il y a déjà un élément en BDD du même nom
        if ($this->findOneTypeHideoutByName($typeHide)){
            $response['result'] = false;
            $response['exist'] ='Il existe déjà un type de même nom';
            return $response;
        }else{
            try{
                $pdoAdd = $this->pdo->prepare("INSERT INTO typeHideouts(type_hide) VALUES (:type_hide)");
                $pdoAdd->bindParam(':type_hide', $typeHide, $this->pdo::PARAM_STR);
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
}