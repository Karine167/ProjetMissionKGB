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
}