<?php 

namespace App\Repository;

use App\Controller\Controller;

class TypeHideoutRepository extends Repository
{
    public function findAllTypeHideouts():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM typeHideouts");
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
}