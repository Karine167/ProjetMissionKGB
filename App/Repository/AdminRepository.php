<?php 

namespace App\Repository;

use App\Entity\Admin;
use App\Db\Mysql;

class AdminRepository extends Repository
{
    public function findOneByEmail(string $email)
    {
        $query = $this->pdo->prepare("SELECT * FROM admins WHERE email = :email");
        $query->bindParam(':email', $email, $this->pdo::PARAM_STR);
        $query->execute();
        $admin = $query->fetch($this->pdo::FETCH_ASSOC);
        if ($admin){
            var_dump($admin);
            return true;
        }else {
            var_dump($admin);
            return false;
        }
    }
}