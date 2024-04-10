<?php 

namespace App\Repository;

use App\Entity\Admin;
use App\Db\Mysql;
use App\Controller\Controller;

class AdminRepository extends Repository
{
    public function findOneAdminById(string $id):Admin|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM admins WHERE id_admin = :id_admin");
            $query->bindParam(':id_admin', $id, $this->pdo::PARAM_STR);
            $query->execute();
            $admin = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($admin){
                $adminBDD = new Admin();
                $adminBDD->setEmail($admin['email']);
                $adminBDD->setPassword($admin['password']);
                $adminBDD->setIdAdmin($admin['id_admin']);
                return $adminBDD;
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
    
    public function findOneAdminByEmail(string $email):Admin|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT * FROM admins WHERE email = :email");
            $query->bindParam(':email', $email, $this->pdo::PARAM_STR);
            $query->execute();
            $admin = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($admin){
                $adminBDD = new Admin();
                $adminBDD->setEmail($admin['email']);
                $adminBDD->setPassword($admin['password']);
                $adminBDD->setIdAdmin($admin['id_admin']);
                return $adminBDD;
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

    public function findAllAdmins():Array|bool
    {
        try{
            $query = $this->pdo->prepare("SELECT *, CONCAT(persons.first_name,' ',persons.last_name) as complete_name FROM admins 
            LEFT JOIN persons ON persons.id = admins.id_admin");
            $query->execute();
            $allAdmins = $query->fetchAll($this->pdo::FETCH_ASSOC);
            if ($allAdmins){
                return $allAdmins;
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