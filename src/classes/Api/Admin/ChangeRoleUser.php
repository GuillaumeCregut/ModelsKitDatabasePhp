<?php
namespace Editiel98\Api\Admin;

use Editiel98\App;
use Editiel98\Manager\UserManager;
use Editiel98\Router\ApiController;
use Exception;

class ChangeRoleUser extends ApiController
{
    public function manage()
    {
        error_reporting(0);
        if($this->isConnected){
            if(App::ADMIN==$this->userRank){
                $method=$_SERVER['REQUEST_METHOD'];
                switch ($method){
                    case 'GET': 
                        header("HTTP/1.1 405 Method Not Allowed");
                        die();
                        break;
                    case 'POST': 
                        header("HTTP/1.1 405 Method Not Allowed");
                        die();
                        break;
                    case 'PUT': $this->updateUser();
                        break;
                    case 'DELETE':
                        header("HTTP/1.1 405 Method Not Allowed");
                        die();
                        break;
                    default:
                        header("HTTP/1.1 405 Method Not Allowed");
                        die();
                }
            }
            else{
                header("HTTP/1.1 403 Forbidden");
            }
        }
        else{
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    private function updateUser()
    {
        $rawData = file_get_contents("php://input");
        $datas=json_decode($rawData);
        $arrayData=[
            'Utilisateur'=>$datas->idUser,
            'NewRole'=>$datas->newRole
        ];
        $idUser=$datas->idUser;
        $newRole=$datas->newRole;
        if(!is_int($idUser) ||!is_int($newRole) || !in_array($newRole,[1,2,5])){
            $return=[
                "result"=>false,
                'Utilisateur'=>$idUser,
                'NewValue'=>$newRole,
            ];
            header("HTTP/1.1 422 Unprocessable entity");
            echo json_encode($return);
            die();
        }
        $userManager=new UserManager($this->dbConnection);
        try{
            $user=$userManager->findById($idUser);
        }
        catch(Exception $e){
            header("HTTP/1.1 500 Unprocessable entity");
            die();
        }
        try{
            $result=$userManager->setNewRole($idUser,$newRole);
            $result=!!$result;
            $arrayData=[
                'Utilisateur'=>$idUser,
                'NewValue'=>$newRole,
                'result'=>$result
            ];
            echo (json_encode($arrayData));
        }
        catch(Exception $e){
            header("HTTP/1.1 500 Unprocessable entity");
            die();
        }
    }
}