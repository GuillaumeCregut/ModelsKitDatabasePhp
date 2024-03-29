<?php

namespace Editiel98\Api\Admin;

use Editiel98\App;
use Editiel98\Event\Emitter;
use Editiel98\Manager\UserManager;
use Editiel98\Router\ApiController;
use Editiel98\Services\CSRFCheck;
use Exception;

/**
 * ChangeValidUser : Api manage user status
 */
class ChangeValidUser extends ApiController
{
    private CSRFCheck $csrfCheck;

    /**
     * Manage : dispatch request
     *
     * @return void
     */
    public function manage()
    {
        error_reporting(0);
        if ($this->isConnected) {
            if (App::ADMIN == $this->userRank) {
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
                        $this->updateUser();
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
                header("HTTP/1.1 403 Forbidden");
            }
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    /**
     * updateUser
     *
     * Change user state. return JSON response
     * 
     * @return void
     */
    private function updateUser()
    {
        $this->csrfCheck = new CSRFCheck($this->session);
        $rawData = file_get_contents("php://input");
        $datas = json_decode($rawData);
        $arrayData = [
            'Utilisateur' => $datas->idUser,
            'NewValue' => $datas->newStatus
        ];
        $idUser = $datas->idUser;
        $newStatus = $datas->newStatus;
        if (!is_int($idUser) || !is_bool($newStatus)) {
            $return = [
                "result" => false,
                'Utilisateur' => $idUser,
                'NewValue' => $newStatus,
            ];
            header("HTTP/1.1 422 Unprocessable entity");
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
        $userManager = new UserManager($this->dbConnection);
        try {
            $user = $userManager->findById($idUser);
        } catch (Exception $e) {
            header("HTTP/1.1 500 Unprocessable entity");
            die();
        }
        try {
            $result = $userManager->setNewStatus($idUser, $newStatus);
            $result = !!$result;
            if ($newStatus && $result) {
                $emitter = Emitter::getInstance();
                $serverAdress = $_SERVER['SERVER_NAME'];
                $mailValues = [
                    'firstname' => $user->getFirstname(),
                    'lastname' => $user->getLastname(),
                    'server' => $serverAdress
                ];
                $emitter->emit(Emitter::USER_VALIDATED, $user->getEmail(), $mailValues);
            }
            $arrayData = [
                'Utilisateur' => $idUser,
                'NewValue' => $newStatus,
                'result' => $result
            ];
            echo (json_encode($arrayData));
        } catch (Exception $e) {
            header("HTTP/1.1 500 Unprocessable entity");
            die();
        }
    }
}
