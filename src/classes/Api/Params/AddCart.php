<?php
namespace Editiel98\Api\Params;

use Editiel98\Entity\User;
use Editiel98\Router\ApiController;
use Editiel98\Services\CSRFCheck;
use Editiel98\Session;

class AddCart extends ApiController
{
    private CSRFCheck $csfrCheck;

    public function manage()
    {
        error_reporting(0);
        $this->csfrCheck=new CSRFCheck($this->session);
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
                    case 'PUT': $this->addCart();
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

    private function addCart()
    {
        $datas=$this->datas;
        $modelAdd=intval($datas->idModel);
        if(is_null($datas->idModel) || $modelAdd===0){
            header("HTTP/1.1 422 Unprocessable entity");

            $return=[
                "result"=>false,
            ];
            echo json_encode($return);
            die();
        }
        //test token
        if(!isset($datas->token)){
            header("HTTP/1.1 422 Unprocessable entity");

            $return=[
                "result"=>false,
            ];
            echo json_encode($return);
            die();
        }
        $token=$datas->token;
        if(!$this->csfrCheck->checkToken($token)){
            header("HTTP/1.1 422 Unprocessable entity");

            $return=[
                "result"=>false,
            ];
            echo json_encode($return);
            die();
         }
        //then
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        $user=new User();
        $user->setId($userId);
        $result=$user->addModelStock($modelAdd,null,null);
        $arrayData=[
            'result'=>$result,
        ];
        echo json_encode($arrayData);
        die();

    }
}