<?php 

namespace App\Repository;

use App\Controller\Controller;

class CountryRepository extends Repository
{
    public function findOneCountryById(int $id):array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM countries WHERE id = :id");
            $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $query->execute();
            $country = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($country){
                return $country;
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

    public function findOneCountryByName(string $countryName):bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM countries WHERE country_name = :country_name");
            $query->bindParam(':country_name', $countryName, $this->pdo::PARAM_STR);
            $query->execute();
            $country = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($country){
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

    public function findAllNationalities():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM countries ORDER BY nationality");
            $query->execute();
            $allNationalities = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($allNationalities){
                return $allNationalities;
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
    public function findAllCountrys():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM countries ORDER BY country_name");
            $query->execute();
            $allCountries = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($allCountries){
                return $allCountries;
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

    public function CountryValidate(): array
    {
        $response['result']= false;
        if (empty($_POST['countryName'])){
            $response['countryName'] = 'Le champ pays ne doit pas être vide';
            return $response;
        } else{
            $country = $_POST['countryName'];
            if (strlen($country)>50){
                $response['countryName'] = 'Le champ pays ne doit pas dépasser 50 caractères';
                return $response;
            }else{
                if (empty($_POST['nationality'])){
                    $response['nationality'] = 'Le champ nationalité ne doit pas être vide';
                    return $response;
                } else{
                    $nationality = $_POST['nationality'];
                    if (strlen($nationality)>50){
                        $response['nationality'] = 'Le champ nationalité ne doit pas dépasser 50 caractères';
                        return $response;
                    }else{
                        $response['result']= true;
                        $response['object']= ['nationality'=>$nationality, 'countryName' => $country];
                    } 
                }
            }    
        }
        return $response;    
    }

    public function CountrySaveToDataBase(array $object): array
    {
        $countryName = $object['countryName'];
        $nationality = $object['nationality']; 
        //recherche s'il y a déjà un élément en BDD du même nom
        if ($this->findOneCountryByName($countryName)){
            $response['result'] = false;
            $response['exist'] ='Il existe déjà un pays de même nom';
            return $response;
        }else{
            try{
                $pdoAdd = $this->pdo->prepare("INSERT INTO countries(country_name, nationality) VALUES (:country_name, :nationality)");
                $pdoAdd->bindParam(':country_name', $countryName, $this->pdo::PARAM_STR);
                $pdoAdd->bindParam(':nationality', $nationality, $this->pdo::PARAM_STR);
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

    function CountryUpdateToDataBase(array $object):array
    {
        $response['result']= false;
        $countryName = $object['countryName'];
        $nationality = $object['nationality']; 
        $id = $_GET['id'];
        try{
            $pdoAdd = $this->pdo->prepare("UPDATE countries SET country_name=:country_name , nationality=:nationality WHERE id=:id");
            $pdoAdd->bindParam(':country_name', $countryName, $this->pdo::PARAM_STR);
            $pdoAdd->bindParam(':nationality', $nationality, $this->pdo::PARAM_STR);
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
    
    public function CountryDelete(int $id):void
    {
        if ($_GET['rep'] == 'oui'){
            try{
                $pdoDelete = $this->pdo->prepare("DELETE FROM countries  WHERE id = :id");
                $pdoDelete->bindParam(':id', $id, $this->pdo::PARAM_INT);
                $pdoDelete->execute();
                $pdoDeletepersonCountry = $this->pdo->prepare("DELETE FROM persons_countries  WHERE id_country = :id_country");
                $pdoDeletepersonCountry->bindParam(':id_country', $id, $this->pdo::PARAM_INT);
                $pdoDeletepersonCountry->execute();
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