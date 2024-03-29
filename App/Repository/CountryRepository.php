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

    public function findAllCountrys():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM countries");
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
}