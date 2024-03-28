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
}