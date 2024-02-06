<?php

namespace Editiel98\Api\Params;

use Editiel98\Manager\ModelManager;
use Editiel98\Router\ApiController;
use Editiel98\Services\CSRFCheck;
use Editiel98\Session;

class AddRate  extends ApiController
{
    private CSRFCheck $csfrCheck;

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
                    $this->addRate();
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

    private function addRate()
    {
        $datas = $this->datas;
        if (!$this->checkValues()) {
            $this->returnError();
        }
        $token = $datas->token;
        if (!$this->csfrCheck->checkToken($token)) {
            $this->returnError();
        }
        $modelId = intval($datas->idModel);
        $newRate = $datas->newRate;
        $userId = $this->session->getKey(Session::SESSION_USER_ID);
        $result = $this->storeRate($userId, $modelId, $newRate);
        if ($result === -1)
            $this->returnError();
        $arrayData = [
            'result' => [
                'id' => $modelId,
                'rate' => $result,
                'userRate' => intval($newRate)
            ]
        ];
        echo json_encode($arrayData);
        die();
    }

    private function checkValues(): bool
    {
        $datas = $this->datas;
        if (is_null($datas->idModel) || is_null($datas->newRate))
            return false;
        if (intval($datas->idModel) === 0 || intval($datas->newRate === 0))
            return false;
        if (!isset($datas->token))
            return false;
        return true;
    }

    private function returnError(): void
    {
        header("HTTP/1.1 422 Unprocessable entity");

        $return = [
            "result" => false,
        ];
        $return = [
            "result" => $this->datas,
        ];
        echo json_encode($return);
        die();
    }

    private function storeRate(int $user, int $model, int $rate): int
    {
        $modelManager = new ModelManager($this->dbConnection);
        return $modelManager->addRate($model, $user, $rate);
    }
}
