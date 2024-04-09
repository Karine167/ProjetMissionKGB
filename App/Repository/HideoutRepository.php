<?php 

namespace App\Repository;

use App\Controller\Controller;
use App\Entity\Hideout;

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
    public function findOneHideoutByAddress(Hideout $hideout):bool
    {
        $address = $hideout->getAddress();
        $city = $hideout->getCity();
        $zipcode = $hideout->getZipcode();
        try{
            $query = $this->pdo->prepare("SELECT * FROM hideouts WHERE address = :address AND city = :city AND zipcode = :zipcode");
            $query->bindParam(':address', $address, $this->pdo::PARAM_STR);
            $query->bindParam(':city', $city , $this->pdo::PARAM_STR);
            $query->bindParam(':zipcode', $zipcode, $this->pdo::PARAM_STR);
            $query->execute();
            $hideout = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($hideout){
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

    public function findOneHideoutById(int $id):array|null
    {
        $id=$_GET['id'];
        try{
            $query = $this->pdo->prepare("SELECT * FROM hideouts WHERE id = :id");
            $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $query->execute();
            $hideout = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($hideout){
                return $hideout;
            }else {
                return null;
            }
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
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

    public function HideoutValidate(): array
    {
        $response['result']= false;
        $fields=['address', 'zipcode', 'city'];
        foreach ($fields as $field) {
            if (empty($_POST[$field])){
                $response[$field] = 'Ce champ ne doit pas être vide';
                return $response;
            }
        } 
        $zipcode = $_POST['zipcode'];
        if (strlen($zipcode)>5){
            $response['zipcode'] = 'Le code postal ne doit pas avoir plus de 5 chiffres';
            return $response; 
        }else{
            if (!ctype_digit($zipcode )){
                $response['zipcode'] = 'Le code postal doit être un entier';
                return $response;
            }
        }
        $city = $_POST['city'];
        if (strlen($city)>50){
            $response['city'] = 'Le champ ville ne doit pas dépasser 50 caractères';
            return $response;
        }
        $hideout = new Hideout(); 
        $hideout->setAddress($_POST['address']);
        $hideout->setZipcode($_POST['zipcode']);
        $hideout->setCity($_POST['city']);
        $hideout->setIdCountry($_POST['country']);
        $hideout->setIdTypeHide($_POST['typeHide']);
        if ($_POST['mission']!="noOne"){
            $hideout->setIdMission($_POST['mission']);
        }
                
        $response['result']= true;
        $response['object']= $hideout;
        return $response;    
    }

    public function HideoutSaveToDataBase(Hideout $hideout): array
    { 
        //recherche s'il y a déjà un élément en BDD du même nom
        if ($this->findOneHideoutByAddress($hideout)){
            $response['result'] = false;
            $response['exist'] ='Il existe déjà une planque à la même adresse';
            return $response;
        }else{
            $codeHide = substr($hideout->getZipcode(),0,2).substr($hideout->getCity(),0,2).$hideout->getIdCountry().'-'.$hideout->getIdTypeHide();
            $hideout->setCodeHide($codeHide);
            $address = $hideout->getAddress();
            $city = $hideout->getCity();
            $zipcode = $hideout->getZipcode();
            $idCountry = $hideout->getIdCountry();
            $idTypeHide = $hideout->getIdTypeHide();
            $idMission = $hideout->getIdMission();
            try{
                $pdoAdd = $this->pdo->prepare("INSERT INTO hideouts(code_hide, city, zipcode, address, id_country, id_typeHide, id_mission ) VALUES (:code_hide, :city, :zipcode, :address, :id_country, :id_typeHide, :id_mission) ");
                $pdoAdd->bindParam(':code_hide', $codeHide, $this->pdo::PARAM_STR);
                $pdoAdd->bindParam(':city', $city, $this->pdo::PARAM_STR);
                $pdoAdd->bindParam(':zipcode', $zipcode, $this->pdo::PARAM_STR);
                $pdoAdd->bindParam(':address', $address, $this->pdo::PARAM_STR);
                $pdoAdd->bindParam(':id_country', $idCountry , $this->pdo::PARAM_INT);
                $pdoAdd->bindParam(':id_typeHide', $idTypeHide, $this->pdo::PARAM_INT);
                $pdoAdd->bindParam(':id_mission', $idMission , $this->pdo::PARAM_INT||null);
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
    function HideoutUpdateToDataBase(Hideout $hideout):array
    {
        $response['result']=false;
        $id = $_GET['id'];
        $codeHide = $codeHide = substr($hideout->getZipcode(),0,2).substr($hideout->getCity(),0,2).$hideout->getIdCountry().'-'.$hideout->getIdTypeHide();
        $address = $hideout->getAddress();
        $city = $hideout->getCity();
        $zipcode = $hideout->getZipcode();
        $idCountry = $hideout->getIdCountry();
        $idTypeHide = $hideout->getIdTypeHide();
        $idMission = $hideout->getIdMission();
        try{
            $pdoAdd = $this->pdo->prepare("UPDATE hideouts SET code_hide = :code_hide , city = :city , zipcode = :zipcode , address = :address , id_country = :id_country , id_typeHide = :id_typeHide, id_mission = :id_mission  WHERE id = :id ");
            $pdoAdd->bindParam(':code_hide', $codeHide, $this->pdo::PARAM_STR);
            $pdoAdd->bindParam(':city', $city, $this->pdo::PARAM_STR);
            $pdoAdd->bindParam(':zipcode', $zipcode, $this->pdo::PARAM_STR);
            $pdoAdd->bindParam(':address', $address, $this->pdo::PARAM_STR);
            $pdoAdd->bindParam(':id_country', $idCountry , $this->pdo::PARAM_INT);
            $pdoAdd->bindParam(':id_typeHide', $idTypeHide, $this->pdo::PARAM_INT);
            $pdoAdd->bindParam(':id_mission', $idMission , $this->pdo::PARAM_INT||null);
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
