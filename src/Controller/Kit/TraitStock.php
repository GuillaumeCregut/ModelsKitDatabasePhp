<?php

namespace App\Controller\Kit;

use Editiel98\App;
use Editiel98\Manager\ModelManager;

trait TraitStock
{
    private function moveStock(int $id, int $newStock, int $user)
    {
        $result = false;
        //check if newStock is OK, then move
        $stocks = [
            App::STATE_BUY,
            App::STATE_FINISHED,
            App::STATE_STOCK,
            App::STATE_WIP,
            App::STATE_LIKED
        ];
        if (in_array($newStock, $stocks)) {
            $modelManager = new ModelManager($this->dbConnection);
            $result = $modelManager->changeUserModelState($id, $newStock, $user);
        }
        return $result;
    }
}
