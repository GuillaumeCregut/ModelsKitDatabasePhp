<?php
namespace Editiel98\Api\Params;

use Editiel98\App;
use Editiel98\Entity\User;
use Editiel98\Manager\UserManager;
use Editiel98\Router\ApiController;
use Editiel98\Session;
use Exception;

class LikeModel extends ApiController
{
    public function manage()
    {
        error_reporting(0);
      //  if($this->isConnected){
                $method=$_SERVER['REQUEST_METHOD'];
                switch ($method){
                    case 'GET':  $this->updateLike();
                       // header("HTTP/1.1 405 Method Not Allowed");
                        die();
                        break;
                    case 'POST': 
                        header("HTTP/1.1 405 Method Not Allowed");
                        die();
                        break;
                    case 'PUT': $this->updateLike();
                        break;
                    case 'DELETE':
                        header("HTTP/1.1 405 Method Not Allowed");
                        die();
                        break;
                    default:
                        header("HTTP/1.1 405 Method Not Allowed");
                        die();
                }
        // }
        // else{
        //     header("HTTP/1.1 401 Unauthorized");
        // }
    }

    private function updateLike()
    {
        /*$rawData = file_get_contents("php://input");
        $datas=json_decode($rawData);
        if(is_null($datas->idModel) || is_null($datas->newLike)){
            header("HTTP/1.1 422 Unprocessable entity");
            $return=[
                "result"=>false,
            ];
            echo json_encode($return);
            die();
        }
        if(!is_int($datas->idModel) || !is_bool($datas->newLike)){
            header("HTTP/1.1 422 Unprocessable entity");
            $return=[
                "result"=>false,
            ];
            echo json_encode($return);
            die();
        }
        $modelLike=$datas->idModel;
        $likeState=$datas->newLike;*/
        /*debug */
        $modelLike=27;
        $likeState=false;
        /*end debug*/
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        $user=new User();
        $user->setId($userId);
        $liked=$user->getFavorite();
        var_dump($liked);
        $arrayData=[
            'Model'=>$modelLike,
            'Like'=>$likeState,
            'userId'=>$userId,
            'result'=>false
        ];
        if(in_array($modelLike,$liked) && $likeState){
            //On ne fais rien
            echo "Déjà";
            $arrayData=[
                'Model'=>$modelLike,
                'Like'=>$likeState,
                'userId'=>$userId,
                'result'=>false
            ];
            header("HTTP/1.1 409 Conflict");
            echo json_encode($arrayData);
            die();
        }
        //Here, we know that user never liked this model, or had disliked it
        //We can like / dislike in DB
        /*

            todo

        */
        echo json_encode($arrayData);
        // $idUser=$datas->idUser;
        // $newRole=$datas->newRole;
        // if(!is_int($idUser) ||!is_int($newRole) || !in_array($newRole,[1,2,5])){
        //     $return=[
        //         "result"=>false,
        //         'Utilisateur'=>$idUser,
        //         'NewValue'=>$newRole,
        //     ];
        //     header("HTTP/1.1 422 Unprocessable entity");
        //     echo json_encode($return);
        //     die();
        // }
        // $userManager=new UserManager($this->dbConnection);
        // try{
        //     $user=$userManager->findById($idUser);
        // }
        // catch(Exception $e){
        //     header("HTTP/1.1 500 Unprocessable entity");
        //     die();
        // }
        // try{
        //     $result=$userManager->setNewRole($idUser,$newRole);
        //     $result=!!$result;
        //     $arrayData=[
        //         'Utilisateur'=>$idUser,
        //         'NewValue'=>$newRole,
        //         'result'=>$result
        //     ];
        //     echo (json_encode($arrayData));
        // }
        // catch(Exception $e){
        //     header("HTTP/1.1 500 Unprocessable entity");
        //     die();
        // }
    }
}