<?php
namespace Editiel98\Auth;

use Editiel98\Database\Database;
use Editiel98\DbException;
use Editiel98\Entity\User;
use Editiel98\Factory;
use Exception;


class DbAuth
{
    private Database $db;
    
    public function __construct()
    {
        $db=Factory::getdB();
        $this->db=$db;
    }

    public function login(string $login, string $password):bool
    {
        $query='SELECT firstname,id,lastname,rankUser,passwd,avatar FROM user WHERE login=:login';
        try{
            $userDb=$this->db->prepare($query,null,[':login'=>$login],true);
            $isValid=password_verify( $password,  $userDb->passwd);
            if($isValid){
                $user=new User(
                    $userDb->firstname,
                    $userDb->lastname,
                    $userDb->id,
                    $userDb->rankUser,
                    $userDb->avatar
                );
                $_SESSION['isConnected']=true;
                $_SESSION['userId']=$user->getId();
                $_SESSION['fullName']=$user->getFullname();
                $_SESSION['rankUser']=$user->getRankUser();
            }
            return $isValid;
        }
        catch(DbException $e){
            throw new Exception($e->getdbMessage());
        }
    }

    public function isLogged() : bool
    {
        return isset($_SESSION['auth']);
    }
}