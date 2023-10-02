<?php
namespace Editiel98\Auth;

use App\Controller\Error;
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
        $query='SELECT firstname,id,lastname,rankUser,passwd,avatar,isvalid FROM user WHERE login=:login';
        try{
            $userDb=$this->db->prepare($query,null,[':login'=>$login],true);
            $isValid=password_verify( $password,  $userDb->passwd)&&($userDb->isvalid===1);
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

    // public function isLogged() : bool
    // {
    //     return isset($_SESSION['auth']);
    // }

    public function signUp(string $login, string $mail, string $firstname, string $lastname, string $pass): bool
    {
        $hashedPassword=password_hash($pass,PASSWORD_DEFAULT);
        $query="INSERT INTO user 
            (firstname, lastname, login,passwd,rankUser, email, isvalid) 
            VALUES(:firstname,:lastname,:login,:pass,1,:email,0)";
        $values=[
            ':firstname'=>$firstname,
            ':lastname'=>$lastname,
            ':email'=>$mail,
            ':login'=>$login,
            'pass'=>$hashedPassword
        ];
        try{
            $result=$this->db->exec($query,$values);
            return $result;
        }
        catch(DbException $e){
            switch($e->getDbCode()){
                case 23000: $message="L'uilisateur existe déjà";
                    break;
                default: $message=$e->getdbMessage();
            }
            throw new Exception($message);
        }
        return false;
    }
}