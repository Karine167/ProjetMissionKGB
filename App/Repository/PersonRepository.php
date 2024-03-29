<?php 

namespace App\Repository;

use App\Entity\Person;
use App\Db\Mysql;
use App\Controller\Controller;

class PersonRepository extends Repository
{
    public function findOneById(string $id):Person|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM persons WHERE id = :id");
            $query->bindParam(':id', $id, $this->pdo::PARAM_STR);
            $query->execute();
            $person = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($person){
                $personBDD = new Person();
                $personBDD->setId($person['id']);
                $personBDD->setFirstName($person['first_name']);
                $personBDD->setLastName($person['last_name']);
                $personBDD->setBirthdate($person['birthdate']);
                return $personBDD;
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

    public function findAllPersons():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM persons");
            $query->execute();
            $allPersons = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($allPersons){
                return $allPersons;
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