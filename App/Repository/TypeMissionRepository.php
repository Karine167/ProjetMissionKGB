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
}