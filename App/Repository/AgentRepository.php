<?php 

namespace App\Repository;

use App\Entity\Person;
use App\Entity\Target;
use App\Entity\Mission;
use App\Entity\Agent;
use App\Db\Mysql;
use App\Controller\Controller;

class AgentRepository extends Repository
{
    public function findOneAgentById(string $id):Agent|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM agents WHERE id_agent = :id_agent");
            $query->bindParam(':id_agent', $id, $this->pdo::PARAM_STR);
            $query->execute();
            $agent = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($agent){
                $agentBDD = new Agent();
                $agentBDD->setIdAgent($agent['id_agent']);
                $agentBDD->setIdentifyCode($agent['identify_code']);
                $agentBDD->setIdMission($agent['id_mission']);
                return $agentBDD;
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

    public function findAllIdAgentsByIdSpeciality(int $idSpeciality):array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT id_agent FROM agents_specialities WHERE id_speciality = :id_speciality");
            $query->bindParam(':id_speciality', $idSpeciality, $this->pdo::PARAM_INT);
            $query->execute();
            $idAgents = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($idAgents){
                $idAgentsArray=[];
                foreach ($idAgents as $idAgent){
                    $idAgentsArray[]= $idAgent['id_agent'];
                }
                return $idAgentsArray;
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

    public function findAllAgentsByMissionId(int $idMission):array|bool
    {
        try{
            $queryAgents = $this->pdo->prepare("SELECT persons.first_name, persons.last_name, persons.birthdate,
            agents.identify_code FROM agents  
            LEFT JOIN persons ON persons.id = agents.id_agent
            WHERE agents.id_mission = :idMission");
            $queryAgents->bindParam(':idMission', $idMission, $this->pdo::PARAM_INT);
            $queryAgents->execute();
            $agents = $queryAgents->fetchAll($this->pdo::FETCH_ASSOC);
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
        }
            if ($agents){
                $arrayAgentsName = [];
                foreach ($agents as $agent) {
                    $arrayAgentsName[]=$agent['first_name']. " " . $agent['last_name'] ." ( ". $agent['birthdate'] .
                    " ) Code : " . $agent['identify_code'];
                }
                return $arrayAgentsName;
            }else {
                return false;
            }
    }

    public function findAllIdAgentsByMissionId(int $idMission):array|bool
    {
        try{
            $queryAgents = $this->pdo->prepare("SELECT id_agent FROM agents  WHERE agents.id_mission = :idMission");
            $queryAgents->bindParam(':idMission', $idMission, $this->pdo::PARAM_INT);
            $queryAgents->execute();
            $agents = $queryAgents->fetchAll($this->pdo::FETCH_ASSOC);
        }catch (\Exception $e){
            $error = $e->getMessage();
            $control = new Controller();
            $control->render('/errors', [
                'error' => $error
            ]);
        }
            if ($agents){
                $agentsArray = [];
                foreach ($agents as $agent){
                    $agentsArray[] = $agent['id_agent'];
                }
                return $agentsArray;
            }else {
                return false;
            }
    }
    
    public function findAllIdSpecialityByIdPerson($idPerson):array|bool{
        $specialities=[];
        try{
            $query = $this->pdo->prepare("SELECT id_speciality FROM agents_specialities WHERE id_agent = :id_agent");
            $query->bindParam(':id_agent', $idPerson, $this->pdo::PARAM_STR);
            $query->execute();
            $agentSpecialities = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($agentSpecialities){
                foreach ($agentSpecialities as $agentSpeciality){
                    $specialities[]=$agentSpeciality['id_speciality'];
                }
                return $specialities;
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

    public function findAllSpecialitiesByIdAgent (string $idAgent): string|bool
    {
        $specialities=" ";
        try{
            $query = $this->pdo->prepare("SELECT agents.id_agent, specialities.name FROM agents 
            LEFT JOIN agents_specialities ON agents_specialities.id_agent = agents.id_agent
            LEFT JOIN specialities ON specialities.id = agents_specialities.id_speciality 
            WHERE agents.id_agent = :id_agent");
            $query->bindParam(':id_agent', $idAgent, $this->pdo::PARAM_STR);
            $query->execute();
            $agentSpecialities = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($agentSpecialities){
                foreach ($agentSpecialities as $agentSpeciality){
                    $specialities .= $agentSpeciality['name']. "; ";
                }
                return $specialities;
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

    public function findAllAgents():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT *, CONCAT(persons.first_name,' ',persons.last_name) as complete_name FROM agents 
            LEFT JOIN persons ON persons.id = agents.id_agent");
            $query->execute();
            $allAgents = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($allAgents){
                return $allAgents;
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

    public function UpdateIdMission(array|bool $idAgentsArray, int $id_mission, array $newIdAgents ): void
    {
        if ($idAgentsArray){
            foreach ($idAgentsArray as $idAgent){
                try{
                    $pdoRemoveIdMission = $this->pdo->prepare("UPDATE agents SET id_mission = null  WHERE id_agent = :id_agent ");
                    $pdoRemoveIdMission->bindParam(':id_agent', $idAgent, $this->pdo::PARAM_STR);
                    $pdoRemoveIdMission->execute();
                }catch (\Exception $e){
                    $error = $e->getMessage();
                    $control = new Controller();
                    $control->render('/errors', [
                        'error' => $error
                    ]);
                }
            }
        }
        if (!is_null($newIdAgents)){
            foreach ($newIdAgents as $newIdAgent){
                if (!is_null($newIdAgent)){
                    try{
                        $pdoUpdateIdMission = $this->pdo->prepare("UPDATE agents SET id_mission = :id_mission  WHERE id_agent = :id_agent ");
                        $pdoUpdateIdMission->bindParam(':id_agent', $newIdAgent, $this->pdo::PARAM_STR);
                        $pdoUpdateIdMission->bindParam(':id_mission', $id_mission, $this->pdo::PARAM_INT);
                        $pdoUpdateIdMission->execute();
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