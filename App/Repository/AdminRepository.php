<?php 

namespace App\Repository;

use App\Entity\Admin;
use App\Db\Mysql;
use App\Controller\Controller;

class AdminRepository extends Repository
{
    public function findOneByEmail(string $email):Admin|bool
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
}