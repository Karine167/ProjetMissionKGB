<?php 

namespace App\Repository;

use App\Entity\Person;
use App\Entity\Target;
use App\Entity\Mission;
use App\Entity\Contact;
use App\Db\Mysql;
use App\Controller\Controller;

class ContactRepository extends Repository
{
    public function findOneContactById(string $id):Contact|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM contacts WHERE id_contact = :id_contact");
            $query->bindParam(':id_contact', $id, $this->pdo::PARAM_STR);
            $query->execute();
            $contact = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($contact){
                $contactBDD = new Contact();
                $contactBDD->setIdContact($contact['id_contact']);
                $contactBDD->setCodeName($contact['code_name']);
                $contactBDD->setIdMission($contact['id_mission']);
                return $contactBDD;
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

    public function findAllContactsByMissionId(int $idMission):array|bool
    {
        try{
            $queryContacts = $this->pdo->prepare("SELECT persons.first_name, persons.last_name, persons.birthdate,
            contacts.code_name FROM contacts  
            LEFT JOIN persons ON persons.id = contacts.id_contact
            WHERE contacts.id_mission = :idMission");
            $queryContacts->bindParam(':idMission', $idMission, $this->pdo::PARAM_INT);
            $queryContacts->execute();
            $contacts = $queryContacts->fetchAll($this->pdo::FETCH_ASSOC);
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
        }
            if ($contacts){
                $arrayContactsName = [];
                foreach ($contacts as $contact) {
                    $arrayContactsName[]=$contact['first_name']. " " . $contact['last_name'] ." ( ". $contact['birthdate'] .
                    " ) Code : " . $contact['code_name'];
                }
                return $arrayContactsName;
            }else {
                return false;
            }  
    }

    public function findAllContacts():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT *, CONCAT(persons.first_name,' ',persons.last_name) as complete_name FROM contacts 
            LEFT JOIN persons ON persons.id = contacts.id_contact");
            $query->execute();
            $allContacts = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($allContacts){
                return $allContacts;
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