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
    public function findOnePersonById(string $id):Person|bool
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
                $personBDD->setBirthdate(date_create($person['birthdate']));
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

    public function findAllIdCountryByIdPerson($idPerson):array|bool
    {
        $countries=[];
        try{
            $query = $this->pdo->prepare("SELECT * FROM persons_countries WHERE id_person = :id_person");
            $query->bindParam(':id_person', $idPerson, $this->pdo::PARAM_STR);
            $query->execute();
            $personCountries = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($personCountries){
                foreach ($personCountries as $personCountry){
                    $countries[]=$personCountry['id_country'];
                }
                return $countries;
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
        $contactArray=[];
        $adminArray=[];
        $targetArray=[];
        $agentArray=[];
        if (isset($_POST['Person'])){
            $roleRadio=$_POST['roleRadio'];
        } else {
            $roleRadio = $_GET['roleRadio'];
        }
        $object=[];
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
        } else {
            $response['birthdate'] = 'Vous devez entrer une date de naissance !';
            $response['result']= false;
        }
        if (empty($_POST['nationality'])){
            $response['nationality'] = 'Vous devez sélectionner au moins une des possibilités proposées.';
            $response['result']= false;
        }
        $id = substr(date("m.d.Y.h.i.s").uniqid("person", true),0,36);
        if ($response['result'] == true){
            $code = substr($_POST['firstName'],0,1). substr($_POST['lastName'],0,1).'-'. date("m.d.Y.h.i.s");
            switch ($roleRadio){
                case 'roleAdmin':
                    if (empty($_POST['email'])){
                        $response['email']='Le champ email ne doit pas être vide';
                        $response['result']= false;
                    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                            $errors['email']='L\'email n\'est pas valide';
                            $response['result']= false;
                    }else{
                        $adminRepository = new AdminRepository();
                        $admin = $adminRepository->findOneAdminByEmail($_POST['email']);
                        if (!$admin){
                            if (empty($_POST['password'])){
                                $response['password']='Le mot de passe ne doit pas être vide. ';
                                $response['result']= false;
                            } else {
                                $password = $_POST['password'];
                                if (strlen($password) < 8 || strlen($password) > 20){
                                    $response['password']='Le mot de passe doit contenir entre 8 et 20 caractères, et posséder au moins un caractère de chacune des catégories suivantes : caractère spécial, un chiffre, une majuscule et une minuscule.';
                                    $response['result']= false;
                                }elseif (ctype_alnum($password)){
                                    $response['password']='Le mot de passe doit contenir au moins un caractère spécial, et au moins un caractère de chacune des catégories suivantes : un chiffre, une majuscule et une minuscule. Il doit également avoir entre 8 et 20 caractères.';
                                    $response['result']= false;
                                }elseif (!preg_match('/.*\d.*/', $password)){
                                    $response['password']='Le mot de passe doit contenir au moins un chiffre, et au moins un caractère de chacune des catégories suivantes : un caractère spécial, une majuscule et une minuscule. Il doit également avoir entre 8 et 20 caractères.';
                                    $response['result']= false;
                                }elseif (!preg_match('/.*[a-z].*/', $password)){
                                    $response['password']='Le mot de passe doit contenir au moins une lettre minuscule, et au moins un caractère de chacune des catégories suivantes : un chiffre, une majuscule et un caractère spécial. Il doit également avoir entre 8 et 20 caractères.';
                                    $response['result']= false;
                                }elseif (!preg_match('/.*[A-Z].*/', $password)){
                                    $response['password']='Le mot de passe doit contenir au moins une lettre majuscule et au moins un caractère de chacune des catégories suivantes : un chiffre, une minuscule et un caractère spécial. Il doit également avoir entre 8 et 20 caractères.';
                                    $response['result']= false;
                                }
                            } 
                            if ($response['result']== true){    
                                $admin = new Admin();
                                $admin->setId($id);
                                $admin->setEmail($_POST['email']);
                                $admin->setPassword($password);
                                $admin->setCreatedAt(date_create("now"));
                                $adminArray = ['admin' => $admin];
                            }
                        } else {
                        $response['email']='Cet utilisateur existe déjà !';
                        $response['result']= false;
                        } 
                    }  
                    break; 
                case 'roleAgent':
                    $agent = new Agent();
                    if ($_POST['mission']=="noOne"){
                        $agent->setIdMission(null);
                    }else {
                        $agent->setIdMission($_POST['mission']);
                    }
                    
                    if (empty($_POST['specialityNames'])){
                        $response['specialityNames'] = 'Vous devez avoir au moins une spécialité.';
                        $response['result']= false;
                    }
                    
                    if ($response['result']== true){
                        $agent->setId($id);
                        $agent->setIdentifyCode($code);
                        $agentArray= ['agent' => $agent, 'specialities' => $_POST['specialityNames']];
                    }
                    break;
                case 'roleTarget':
                    $target = new Target();
                    if ($_POST['mission']=="noOne"){
                        $target->setIdMission(null);
                    }else {
                        $target->setIdMission($_POST['mission']);
                    }
                    
                    if ($response['result']== true){
                        $target->setId($id);
                        $target->setCodeName($code);
                        $targetArray = ['target' => $target];
                    }
                    break;
                case 'roleContact':
                    $contact = new Contact();
                    if ($_POST['mission']=="noOne"){
                        $contact->setIdMission(null);
                    }else {
                        $contact->setIdMission($_POST['mission']);
                        $missionRepository = new MissionRepository();
                        $mission = $missionRepository->findOneMissionById($_POST['mission']);
                        if ($mission){
                            $missionIdCountry = $mission->getIdCountry();
                            if (!(in_array( $missionIdCountry, $_POST['nationality'] ))) {
                                $response['mission'] = 'Vous devez choisir une mission qui a lieu dans le pays du contact !';
                                $response['result'] = false;
                            }
                        
                        }
                    }
                    
                    if ($response['result']== true){
                        $contact->setId($id);
                        $contact->setCodeName($code);
                        $contactArray = ['contact' => $contact];
                    }
                    break;
            }
        }
        if ($response['result']== true){
        $person = new Person(); 
        $person->setId($id);
        $person->setFirstName($_POST['firstName']);
        $person->setLastName($_POST['lastName']);

        $personArray = ['person'=> $person,'birthdate' => $_POST['birthdate'], 'countrys' => $_POST['nationality']];
        $response['object'] = ['personArray' => $personArray];
        if (key_exists('contact', $contactArray)){
            $response['object'] [] =['contactArray' => $contactArray ];}
        if (key_exists('admin', $adminArray)){
            $response['object'] [] =['adminArray' => $adminArray ];}
        if (key_exists('target', $targetArray)){
            $response['object'] [] =['targetArray' => $targetArray];}
        if (key_exists('agent', $agentArray)){
            $response['object'] [] =['agentArray' => $agentArray ];}
        }
        return $response;    
    }

    public function PersonSaveToDataBase(array $object): array
    {       
        $person =$object['personArray']['person'];
        $id = $person->getId();
        $firstName = $person->getFirstName();
        $lastName = $person->getLastName();
        $birthdate = $object['personArray']['birthdate'];
        try{
            $pdoAddPerson = $this->pdo->prepare("INSERT INTO persons(id, first_name, last_name, birthdate) VALUES (:id, :first_name, :last_name, :birthdate) ");
            $pdoAddPerson->bindParam(':id', $id, $this->pdo::PARAM_STR);
            $pdoAddPerson->bindParam(':first_name', $firstName, $this->pdo::PARAM_STR);
            $pdoAddPerson->bindParam(':last_name', $lastName, $this->pdo::PARAM_STR);
            $pdoAddPerson->bindParam(':birthdate', $birthdate, $this->pdo::PARAM_STR|null);
            $pdoAddPerson->execute();
        }catch (\Exception $e){
                $error = $e->getMessage();
                $control = new Controller();
                $control->render('/errors', [
                    'error' => $error
                ]);
        }
        $countrys = $object['personArray']['countrys'];
        foreach ($countrys as $idCountry){
            try{
                $pdoAddCountry = $this->pdo->prepare("INSERT INTO persons_countries(id_person, id_country) VALUES (:id_person, :id_country) ");
                $pdoAddCountry->bindParam(':id_person', $id, $this->pdo::PARAM_STR);
                $pdoAddCountry->bindParam(':id_country', $idCountry, $this->pdo::PARAM_STR);
                $pdoAddCountry->execute();
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
        }
        
        if (array_key_exists('contactArray', $object[0])){
            $contact = $object[0]['contactArray']['contact'];
            $codeName = $contact->getCodeName();
            $idMission = $contact->getIdMission();
            try{
                $pdoAddContact = $this->pdo->prepare("INSERT INTO contacts(id_contact, code_name, id_mission) VALUES (:id_contact, :code_name, :id_mission) ");
                $pdoAddContact->bindParam(':id_contact', $id, $this->pdo::PARAM_STR);
                $pdoAddContact->bindParam(':code_name', $codeName, $this->pdo::PARAM_STR);
                $pdoAddContact->bindParam(':id_mission', $idMission, $this->pdo::PARAM_INT || null);
                $pdoAddContact->execute();
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
        }
        if (array_key_exists('targetArray', $object[0])){
            $target = $object[0]['targetArray']['target'];
            $codeName = $target->getCodeName();
            $idMission = $target->getIdMission();
            try{
                $pdoAddTarget = $this->pdo->prepare("INSERT INTO targets(id_target, code_name, id_mission) VALUES (:id_target, :code_name, :id_mission) ");
                $pdoAddTarget->bindParam(':id_target', $id, $this->pdo::PARAM_STR);
                $pdoAddTarget->bindParam(':code_name', $codeName, $this->pdo::PARAM_STR);
                $pdoAddTarget->bindParam(':id_mission', $idMission, $this->pdo::PARAM_INT || null);
                $pdoAddTarget->execute();
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
        }
        if (array_key_exists('agentArray', $object[0])){
            $agent = $object[0]['agentArray']['agent'];
            $identifyCode = $agent->getIdentifyCode();
            $idMission = $agent->getIdMission();
            try{
                $pdoAddAgent = $this->pdo->prepare("INSERT INTO agents(id_agent, identify_code, id_mission) VALUES (:id_agent, :identify_code, :id_mission) ");
                $pdoAddAgent->bindParam(':id_agent', $id, $this->pdo::PARAM_STR);
                $pdoAddAgent->bindParam(':identify_code', $identifyCode, $this->pdo::PARAM_STR);
                $pdoAddAgent->bindParam(':id_mission', $idMission, $this->pdo::PARAM_INT || null);
                $pdoAddAgent->execute();
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
            $specialities = $object[0]['agentArray']['specialities'];
            foreach ($specialities as $idSpeciality){
                try{
                    $pdoAddAgentSpe = $this->pdo->prepare("INSERT INTO agents_specialities(id_agent, id_speciality) VALUES (:id_agent, :id_speciality) ");
                    $pdoAddAgentSpe->bindParam(':id_agent', $id, $this->pdo::PARAM_STR);
                    $pdoAddAgentSpe->bindParam(':id_speciality', $idSpeciality, $this->pdo::PARAM_INT);
                    $pdoAddAgentSpe->execute();
                }catch (\Exception $e){
                        $error = $e->getMessage();
                        $control = new Controller();
                        $control->render('/errors', [
                            'error' => $error
                        ]);
                }
            }
        }
        if (array_key_exists('adminArray', $object[0])){
            $admin = $object[0]['adminArray']['admin'];
            $email = $admin->getEmail();
            $password = password_hash($admin->getPassword(), PASSWORD_BCRYPT);
            $createdAt = date_format($admin->getCreatedAt(), 'Y-m-d');
            try{
                $pdoAddAdmin = $this->pdo->prepare("INSERT INTO admins(id_admin, email, password, created_at) VALUES (:id_admin, :email, :password, :created_at) ");
                $pdoAddAdmin->bindParam(':id_admin', $id, $this->pdo::PARAM_STR);
                $pdoAddAdmin->bindParam(':email', $email, $this->pdo::PARAM_STR);
                $pdoAddAdmin->bindParam(':password', $password, $this->pdo::PARAM_STR);
                $pdoAddAdmin->bindParam(':created_at', $createdAt, $this->pdo::PARAM_STR);
                $pdoAddAdmin->execute();
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
        }

        $response['result']= true;
        $_POST=[];
        return $response;
    }
    public function PersonUpdateToDataBase(array $object): array
    {       
        $response['result']=false;
        $id = $_GET['id'];
        $person =$object['personArray']['person'];
        $firstName = $person->getFirstName();
        $lastName = $person->getLastName();
        $birthdate = $object['personArray']['birthdate'];
        try{
            $pdoEditPerson = $this->pdo->prepare("UPDATE persons SET first_name = :first_name , last_name = :last_name , birthdate = :birthdate WHERE id = :id ");
            $pdoEditPerson->bindParam(':id', $id, $this->pdo::PARAM_STR);
            $pdoEditPerson->bindParam(':first_name', $firstName, $this->pdo::PARAM_STR);
            $pdoEditPerson->bindParam(':last_name', $lastName, $this->pdo::PARAM_STR);
            $pdoEditPerson->bindParam(':birthdate', $birthdate, $this->pdo::PARAM_STR);
            $pdoEditPerson->execute();
        }catch (\Exception $e){
                $error = $e->getMessage();
                $control = new Controller();
                $control->render('/errors', [
                    'error' => $error
                ]);
        }
        try {
            $pdoRemoveCountry = $this->pdo->prepare("DELETE FROM persons_countries WHERE id_person = :id_person");
            $pdoRemoveCountry->bindParam(':id_person', $id, $this->pdo::PARAM_STR);
            $pdoRemoveCountry->execute();
            $countrys = $object['personArray']['countrys'];
            foreach ($countrys as $idCountry){
            $pdoEditCountry = $this->pdo->prepare("INSERT INTO persons_countries(id_person, id_country) VALUES (:id_person, :id_country) ");
            $pdoEditCountry->bindParam(':id_person', $id, $this->pdo::PARAM_STR);
            $pdoEditCountry->bindParam(':id_country', $idCountry, $this->pdo::PARAM_STR);
            $pdoEditCountry->execute();
            }
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
        }
        
        
        if (array_key_exists('contactArray', $object[0])){
            $contact = $object[0]['contactArray']['contact'];
            $idMission = $contact->getIdMission();
            try{
                $pdoEditContact = $this->pdo->prepare("UPDATE contacts SET id_mission = :id_mission WHERE id_contact = :id_contact ");
                $pdoEditContact->bindParam(':id_contact', $id, $this->pdo::PARAM_STR);
                $pdoEditContact->bindParam(':id_mission', $idMission, $this->pdo::PARAM_INT || null);
                $pdoEditContact->execute();
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
        }
        if (array_key_exists('targetArray', $object[0])){
            $target = $object[0]['targetArray']['target'];
            $idMission = $target->getIdMission();
            try{
                $pdoEditTarget = $this->pdo->prepare("UPDATE targets SET id_mission = :id_mission WHERE id_target = :id_target ");
                $pdoEditTarget->bindParam(':id_target', $id, $this->pdo::PARAM_STR);
                $pdoEditTarget->bindParam(':id_mission', $idMission, $this->pdo::PARAM_INT || null);
                $pdoEditTarget->execute();
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
        }
        if (array_key_exists('agentArray', $object[0])){
            $agent = $object[0]['agentArray']['agent'];
            $idMission = $agent->getIdMission();
            try{
                $pdoEditAgent = $this->pdo->prepare("UPDATE agents SET id_mission = :id_mission WHERE id_agent = :id_agent ");
                $pdoEditAgent->bindParam(':id_agent', $id, $this->pdo::PARAM_STR);
                $pdoEditAgent->bindParam(':id_mission', $idMission, $this->pdo::PARAM_INT || null);
                $pdoEditAgent->execute();
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
            try{
                $pdoRemoveSpeciality = $this->pdo->prepare("DELETE FROM agents_specialities WHERE id_agent = :id_agent");
                $pdoRemoveSpeciality->bindParam(':id_agent', $id, $this->pdo::PARAM_STR);
                $pdoRemoveSpeciality->execute();
                $specialities = $object[0]['agentArray']['specialities'];
                foreach ($specialities as $idSpeciality){
                        $pdoEditAgentSpe = $this->pdo->prepare("INSERT INTO agents_specialities(id_agent, id_speciality) VALUES (:id_agent, :id_speciality) ");
                        $pdoEditAgentSpe->bindParam(':id_agent', $id, $this->pdo::PARAM_STR);
                        $pdoEditAgentSpe->bindParam(':id_speciality', $idSpeciality, $this->pdo::PARAM_INT);
                        $pdoEditAgentSpe->execute();
                    }
            }catch (\Exception $e){
                $error = $e->getMessage();
                $control = new Controller();
                $control->render('/errors', [
                    'error' => $error
                ]);
            }
            
        }
        if (array_key_exists('adminArray', $object[0])){
            $admin = $object[0]['adminArray']['admin'];
            $email = $admin->getEmail();
            $password = password_hash($admin->getPassword(), PASSWORD_BCRYPT);
            try{
                $pdoEditAdmin = $this->pdo->prepare("UPDATE admins SET email = :email , password = :password WHERE id_admin = :id_admin ");
                $pdoEditAdmin->bindParam(':id_admin', $id, $this->pdo::PARAM_STR);
                $pdoEditAdmin->bindParam(':email', $email, $this->pdo::PARAM_STR);
                $pdoEditAdmin->bindParam(':password', $password, $this->pdo::PARAM_STR);
                $pdoEditAdmin->execute();
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
        }

        $response['result']= true;
        $_POST=[];
        return $response;
    }

    public function PersonDelete(string $id):void
    {
        if ($_GET['rep'] == 'oui'){
            try{
                $pdoDeletePerson = $this->pdo->prepare("DELETE FROM persons  WHERE id = :id");
                $pdoDeletePerson->bindParam(':id', $id, $this->pdo::PARAM_STR);
                $pdoDeletePerson->execute();
                //suppression des associations dans la table persons_countries liées à cette personne
                $pdoDeletePersonCountry = $this->pdo->prepare("DELETE FROM persons_countries  WHERE id_person = :id_person");
                $pdoDeletePersonCountry->bindParam(':id_person', $id, $this->pdo::PARAM_STR);
                $pdoDeletePersonCountry->execute();
            }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
            }
            
            //vérification si cette personne est un agent puis si c'est le cas, suppression de la personne dans la table des agents
            //Si c'est un agent, suppression des associations liées à cet agent dans la table des agents_specialities
            $agentRepository = new AgentRepository();
            $agent = $agentRepository->findOneAgentById($id);
            if ($agent){
                try{
                    $pdoDeleteAgent = $this->pdo->prepare("DELETE FROM agents WHERE id_agent = :id_agent");
                    $pdoDeleteAgent->bindParam(':id_agent', $id, $this->pdo::PARAM_STR);
                    $pdoDeleteAgent->execute();
                    $pdoDeleteAgentSpeciality = $this->pdo->prepare("DELETE FROM agents_specialities  WHERE id_agent = :id_agent");
                    $pdoDeleteAgentSpeciality->bindParam(':id_agent', $id, $this->pdo::PARAM_STR);
                    $pdoDeleteAgentSpeciality->execute();
                }catch (\Exception $e){
                        $error = $e->getMessage();
                        $control = new Controller();
                        $control->render('/errors', [
                            'error' => $error
                        ]);
                }   
            } else {
                //vérification si cette personne est un contact puis si c'est le cas, suppression de la personne dans la table des contacts
                $contactRepository = new ContactRepository();
                $contact = $contactRepository->findOneContactById($id);
                if ($contact){
                    try{
                        $pdoDeleteContact = $this->pdo->prepare("DELETE FROM contacts WHERE id_contact = :id_contact");
                        $pdoDeleteContact->bindParam(':id_contact', $id, $this->pdo::PARAM_STR);
                        $pdoDeleteContact->execute();
                    }catch (\Exception $e){
                            $error = $e->getMessage();
                            $control = new Controller();
                            $control->render('/errors', [
                                'error' => $error
                            ]);
                    }   
                } else {
                    //vérification si cette personne est une cible puis si c'est le cas, suppression de la personne dans la table des cibles
                    $targetRepository = new TargetRepository();
                    $target = $targetRepository->findOneTargetById($id);
                    if ($target){
                        try{
                            $pdoDeleteTarget = $this->pdo->prepare("DELETE FROM targets WHERE id_target = :id_target");
                            $pdoDeleteTarget->bindParam(':id_target', $id, $this->pdo::PARAM_STR);
                            $pdoDeleteTarget->execute();
                        }catch (\Exception $e){
                                $error = $e->getMessage();
                                $control = new Controller();
                                $control->render('/errors', [
                                    'error' => $error
                                ]);
                        }   
                    } else {
                        //vérification si cette personne est un admin puis si c'est le cas, suppression de la personne dans la table des admins
                        $adminRepository = new AdminRepository();
                        $admin = $adminRepository->findOneAdminById($id);
                        if ($admin){
                            try{
                                $pdoDeleteAdmin = $this->pdo->prepare("DELETE FROM admins WHERE id_admin = :id_admin");
                                $pdoDeleteAdmin->bindParam(':id_admin', $id, $this->pdo::PARAM_STR);
                                $pdoDeleteAdmin->execute();
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
            }
        }
    }

}