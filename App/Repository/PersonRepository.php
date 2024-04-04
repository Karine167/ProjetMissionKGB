<?php 

namespace App\Repository;

use App\Entity\Person;
use App\Db\Mysql;
use App\Controller\Controller;
use App\Entity\Country;
use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Admin;
use App\Entity\Target;

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
    public function findOnePersonByName(Person $person):bool
    {
        $firstName = $person->getFirstName();
        $lastName = $person->getLastName();
        $birthdate = $person->getBirthdate();
        try{
            $query = $this->pdo->prepare("SELECT * FROM persons WHERE first_name = :first_name AND last_name = :last_name AND birthdate = :birthdate");
            $query->bindParam(':first_name', $firstName, $this->pdo::PARAM_STR);
            $query->bindParam(':last_name', $lastName , $this->pdo::PARAM_STR);
            $query->bindParam(':birthdate', $birthdate, $this->pdo::PARAM_STR);
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

    public function PersonValidate(): array
    {
        $response['result']= true;
        $requiredFields=['firstName', 'lastName'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])){
                $response[$field] = 'Ce champ ne doit pas être vide';
                $response['result']= false;
            }
            if (strlen($_POST[$field])>50){
                $response[$field] = 'Ce champ ne doit pas avoir plus de 50 caractères';
                $response['result']= false;
            } 
        } 
        
        if ($_POST['birthdate']){
            $birthdate = $_POST['birthdate'];
            if (!preg_match('/^[\d-]*/', $birthdate)){
                $response['birthdate'] = 'Cette date n\'est pas au bon format !';
                $response['result']= false;
            } elseif (!checkdate(intval(substr($birthdate,5,2)),intval(substr($birthdate,8,2)),intval(substr($birthdate,0,4)))) {
                $response['birthdate'] = 'Cette date n\'existe pas !';
                $response['result']= false;
            }
        }
        
        $id = uniqid("person", true).date("m.d.Y.h.i.s");
        if ($response['result'] == true){
            $code = substr($_POST['firstName'],0,1). substr($_POST['lastName'],0,1).'-'. date("m.d.Y.h.i.s");
            switch ($_POST['radio']){
                case 'roleAdmin':
                    if (empty($_POST['email'])){
                        $response['email']='Le champ email ne doit pas être vide';
                        $response['result']= false;
                    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                            $errors['email']='L\'email n\'est pas valide';
                            $response['result']= false;
                    }else{
                        $adminRepository = new AdminRepository();
                        $admin = $adminRepository->findOneByEmail($_POST['email']);
                        if (!$admin){
                            if (empty($_POST['password'])){
                                $response['password']='Le mot de passe ne doit pas être vide. ';
                                $response['result']= false;
                            } else {
                                $password = $_POST['password'];
                                if (strlen($password) < 8 || strlen($password) > 20){
                                    $response['password']='Le mot de passe doit contenir entre 8 et 20 caractères';
                                    $response['result']= false;
                                }elseif (ctype_alnum($password)){
                                    $response['password']='le mot de passe doit contenir au moins un caractère spécial.';
                                    $response['result']= false;
                                }elseif (!preg_match('/.*\d.*/', $password)){
                                    $response['password']='le mot de passe doit contenir au moins un chiffre';
                                    $response['result']= false;
                                }elseif (!preg_match('/.*[a-z].*/', $password)){
                                    $response['password']='le mot de passe doit contenir au moins une lettre minuscule';
                                    $response['result']= false;
                                }elseif (!preg_match('/.*[A-Z].*/', $password)){
                                    $response['password']='le mot de passe doit contenir au moins une lettre majuscule';
                                    $response['result']= false;
                                }
                            } 
                            if ($response['result']== true){    
                                $admin = new Admin();
                                $admin->setId($id);
                                $admin->setEmail($_POST['email']);
                                $admin->setPassword($password);
                                $admin->setCreatedAt(date_create("now"));
                                $response['object'][] = ['admin' => $admin];
                            }
                        } else {
                        $response['email']='Cet utilisateur existe déjà !';
                        $response['result']= false;
                        } 
                    }  
                    break; 
                case 'roleAgent':
                    $agent = new Agent();
                    if ($_POST['mission']=!"autre"){
                        $agent->setIdMission($_POST['mission']);
                    }
                    if (empty($_POST['specialityNames'])){
                        $response['specialityNames'] = 'Vous devez avoir au moins une spécialité.';
                        $response['result']= false;
                    }
                    if ($response['result']== true){
                        $agent->setId($id);
                        $agent->setIdentifyCode($code);
                        $response['object'][] = ['agent' => $agent, 'specialités' => $_POST['specialityNames']];
                    }
                    break;
                case 'roleTarget':
                    $target = new Target();
                    if ($_POST['mission']=!"autre"){
                        $target->setIdMission($_POST['mission']);
                    }
                    if ($response['result']== true){
                        $target->setId($id);
                        $target->setCodeName($code);
                        $response['object'][] = ['target' => $target];
                    }
                    break;
                case 'roleContact':
                    $contact = new Contact();
                    if ($_POST['mission']=!"autre"){
                        $contact->setIdMission($_POST['mission']);
                    }
                    if ($response['result']== true){
                        $contact->setId($id);
                        $contact->setCodeName($code);
                        $response['object'][] = ['contact' => $contact];
                    }
                    break;
            }
        }
        if ($response['result']== true){
        $person = new Person(); 
        $person->setId($id);
        $person->setFirstName($_POST['firstName']);
        $person->setLastName($_POST['lastName']);
        
        $country = new Country();
        $country->setId($_POST['nationality']);

        $response['object'][] = ['person'=> $person,'birthdate' => $_POST['birthdate'], 'country'=> $country];
        }
        return $response;    
    }

}