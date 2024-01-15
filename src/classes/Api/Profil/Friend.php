<?php

namespace Editiel98\Api\Profil;

use Editiel98\Manager\SocialManager;
use Editiel98\Router\ApiController;
use Editiel98\Services\CSRFCheck;
use Editiel98\Session;

/**
 * Friend
 * Change relation state between users
 */
class Friend extends ApiController
{
    private CSRFCheck $csfrCheck;

    /**
     * Manage : dispatch request
     *
     * @return void
     */
    public function manage()
    {
        //error_reporting(0);
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
                    $this->changeState();
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
     * changeState
     * Change state relation between users
     * Return JSON response
     *
     * @return void
     */
    private function changeState()
    {
        $this->csfrCheck = new CSRFCheck($this->session);
        $userId = $this->session->getKey(Session::SESSION_USER_ID);
        $datas = $this->datas;
        if (is_null($datas) || is_null($datas->idUser) || intval($datas->idUser) === 0) {
            header('Content-Type: application/json');
            header("HTTP/1.1 422 Unprocessable entity");
            $return = [
                "result" => false,
            ];
            echo json_encode($return);
            die();
        }
        //token here
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
        $friendId = intval($datas->idUser);
        $socialManager = new SocialManager($this->dbConnection);
        $result = $socialManager->getFriendVisibility($friendId);
        if (empty($result)) {
            header('Content-Type: application/json');
            header("HTTP/1.1 404 Not Found");
            $return = [
                "result" => false,
            ];
            echo json_encode($return);
            die();
        }
        if ($result[0]->isVisible === 0) {
            header('Content-Type: application/json');
            header("HTTP/1.1 403 Forbidden");
            $return = [
                "result" => false,
            ];
            echo json_encode($return);
            die();
        }
        $addFriend = $socialManager->addFriendShip($userId, $friendId);
        if ($addFriend === 23000) {
            header('Content-Type: application/json');
            header("HTTP/1.1 409 Conflict");
            $return = [
                "result" => false,
            ];
            echo json_encode($return);
            die();
        }
        if ($addFriend !== 1) {
            header('Content-Type: application/json');
            header("HTTP/1.1 500 Internal Server Error");
            $return = [
                "result" => false,
            ];
            echo json_encode($return);
            die();
        }
        $return = [
            "result" => true,
        ];
        header('Content-Type: application/json');
        echo json_encode($return);
        die();
    }
}
