<?php
namespace Editiel98\Api\Admin;

use Editiel98\App;
use Editiel98\Router\ApiController;

class ChangeRankUser extends ApiController
{
    public function manage()
    {
        if($this->isConnected){
            if(App::ADMIN==$this->userRank){
                $method=$_SERVER['REQUEST_METHOD'];
                switch ($method){
                    case 'GET': $this->updateUser();
                        
                        break;
                    case 'POST': $this->updateUser();
                        break;
                    case 'PUT': header("HTTP/1.1 405 Method Not Allowed");
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
             //   header("HTTP/1.1 403 Forbidden");
            }
        }
        else{
          //  header("HTTP/1.1 401 Unauthorized");
        }
    }

    private function updateUser()
    {
        $rawData = file_get_contents("php://input");
        $datas=json_decode($rawData);
        $arrayData=[
            'Utilisateur'=>$datas->idUser,
            'NewValue'=>$datas->newStatus
        ];
        echo (json_encode($arrayData));
    
    }
}