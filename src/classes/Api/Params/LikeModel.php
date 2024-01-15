<?php

namespace Editiel98\Api\Params;

use Editiel98\Entity\User;
use Editiel98\Router\ApiController;
use Editiel98\Services\CSRFCheck;
use Editiel98\Session;

/**
 * LikeModel : change like status between user and model
 */
class LikeModel extends ApiController
{
    private CSRFCheck $csfrCheck;

    /**
     * Manage : dispatch request
     *
     * @return void
     */
    public function manage()
    {
        error_reporting(0);
        $this->csfrCheck = new CSRFCheck($this->session);
        if ($this->isConnected) {
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'GET':
                    header("HTTP/1.1 405 Method Not Allowed");
                    die();
                    break;
                case 'POST':
                    header("HTTP/1.1 405 Method Not Allowed");
                    die();
                    break;
                case 'PUT':
                    $this->updateLike();
                    break;
                case 'DELETE':
                    header("HTTP/1.1 405 Method Not Allowed");
                    die();
                    break;
                default:
                    header("HTTP/1.1 405 Method Not Allowed");
                    die();
            }
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    /**
     * updateLike
     * 
     * Change like state between user and kit
     * Return JSON response
     *
     * @return void
     */
    private function updateLike()
    {
        $datas = $this->datas;
        $modelLike = intval($datas->idModel);
        $likeState = $datas->newLike;
        if (is_null($datas->idModel) || is_null($datas->newLike)) {
            header("HTTP/1.1 422 Unprocessable entity");
            $return = [
                "result" => false,
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
        if (!$this->csfrCheck->checkToken($token)) {
            header("HTTP/1.1 422 Unprocessable entity");

            $return = [
                "result" => false,
            ];
            echo json_encode($return);
            die();
        }
        if (($modelLike === 0) || !is_bool($datas->newLike)) {
            header("HTTP/1.1 422 Unprocessable entity");
            $return = [
                "result" => false,
            ];
            echo json_encode($return);
            die();
        }
        $userId = $this->session->getKey(Session::SESSION_USER_ID);
        $user = new User();
        $user->setId($userId);
        if ($likeState) {
            $result = $user->addFavorite($modelLike);
        } else {
            $result = $user->removeFavorite($modelLike);
        }
        $arrayData = [
            'result' => $result,
        ];
        echo json_encode($arrayData);
        die();
    }
}
