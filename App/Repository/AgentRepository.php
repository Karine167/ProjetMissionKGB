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
    
    public function findAllIdSpecialityByIdPerson($idPerson):array|bool{
        $specialities=[];
        try{
            $query = $this->pdo->prepare("SELECT * FROM agents_specialities WHERE id_agent = :id_agent");
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
}