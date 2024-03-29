<?php 

namespace App\Repository;

use App\Entity\Person;
use App\Entity\Target;
use App\Entity\Mission;
use App\Db\Mysql;
use App\Controller\Controller;

class AgentRepository extends Repository
{
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