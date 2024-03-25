<?php

namespace App\Controller;

use App\Db\Mysql;
use App\Repository\AdminRepository;

class AuthController extends Controller
{
    public function route():void
    {
        try{
            if (isset($_GET['action'])){
                switch ($_GET['action']){
                    case 'login':
                        $this->login();
                        break;
                    case 'logout':
                        $this->logout();
                        break;
                    default:
                        throw new \Exception("Cette action n'est pas prise en charge.");
                        break;
                }
            }else{
                throw new \Exception("Aucune action spécifiée");
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    protected function login()
    {

        if (isset($_POST['connect'])){
            if (empty($_POST['email'])){
                var_dump('Le champ email ne doit pas être vide');
            } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                var_dump('L\'email n\'est pas valide');
            }else {
                $adminRepository = new AdminRepository();
                $admin = $adminRepository->findOneByEmail($_POST['email']);
                if ($admin){
                    if (empty($_POST['password'])){
                        var_dump('Le mot de passe ne doit pas être vide');
                    }else {
                        if (password_verify($_POST['password'], $admin->getPassword())){
                            session_regenerate_id(true);
                            $_SESSION['user'] = [
                                'idAdmin' => $admin->getIdAdmin(),
                                'email' => $admin->getEmail(),
                            ];
                            header('location: index.php?controller=front');
                        } else {
                            var_dump('mot de passe incorrect');
                        }
                    } 
                } else {
                    var_dump('Cet utilisateur n\'existe pas.');
                }   
            }
        }
        require_once _TEMPLATEPATH_.'/authentification.php';
    }

    protected function logout()
    {
        session_regenerate_id(true);
        session_destroy();
        unset($_SESSION);
        header('location: index.php?controller=front');
    }


}