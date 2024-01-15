<?php
namespace Editiel98\Api\Kit;

use Editiel98\Manager\ModelManager;
use Editiel98\Router\ApiController;
use Editiel98\Services\CSRFCheck;
use Editiel98\Session;

class UpdateState extends ApiController
{
    private CSRFCheck $csrfCheck;

    public function manage()
    {
        error_reporting(0);
        if($this->isConnected){
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
                     case 'PUT': $this->changeState();
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
             header("HTTP/1.1 401 Unauthorized");
         }
    }

    private function changeState()
    {
        $this->csrfCheck=new CSRFCheck($this->session);
        $datas=$this->datas;
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        $idModel=intval($datas->idModel);
        $newState=intval($datas->newState);
        if(is_null($datas->idModel) || $idModel===0 || is_null($datas->newState) || $newState===0){
            header("HTTP/1.1 422 Unprocessable entity");
            $return=[
                "result"=>false,
            ];
            echo json_encode($return);
            die();
        }
        if (!isset($datas->token)) {
            header("HTTP/1.1 422 Unprocessable entity");

            $return = [
                "result" => false,
            ];
            echo json_encode($return);
            die();
        }
        $token = $datas->token;
        if (!$this->csrfCheck->checkToken($token)) {
            header("HTTP/1.1 422 Unprocessable entity");

            $return = [
                "result" => false,
            ];
            echo json_encode($return);
            die();
        }
        $modelManager=new ModelManager($this->dbConnection);
        $result=$modelManager->changeUserModelState($idModel,$newState,$userId);
        if(!$result){
            header("HTTP/1.1 500 Internal Server Error");
        }
        $return=[
            "result"=>$result,
        ];
        echo json_encode($return);
        die();
    }
}