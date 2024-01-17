<?php

namespace App\Controller\Profil;

use Editiel98\Entity\User;
use Editiel98\Manager\ModelManager;
use Editiel98\Router\Controller;
use Editiel98\Session;

/**
 * Controller for display page of model to add in order
 */
class ModelSelector extends Controller
{
    private array $models;
    public function render()
    {
        if (!$this->isConnected) {
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $userId = $this->session->getKey(Session::SESSION_USER_ID);
        $user = new User();
        $user->setId($userId);
        $favorites = $user->getFavorite();
        $filter = null;
        if (!empty($_GET)) {
            if (isset($_GET['name'])) {
                $filter = trim(htmlspecialchars($_GET['name'], ENT_NOQUOTES, 'UTF-8'));
            }
        }
        $this->getModels($filter);
        $modelsDisplay = [];
        $favoriteDisplay = [];
        foreach ($this->models as $model) {
            if (in_array($model->getId(), $favorites)) {
                $favoriteDisplay[] = $model;
            } else {
                $modelsDisplay[] = $model;
            }
        }
        if ($filter) {
            $this->smarty->assign('filterName', $filter);
        }
        $this->smarty->assign('favorites', $favoriteDisplay);
        $this->smarty->assign('models', $modelsDisplay);
        $this->smarty->display('profil/addmodelorder.tpl');
    }

    /**
     * @param string|null $filter
     * 
     * @return void
     */
    private function getModels(?string $filter = null): void
    {
        $modelManager = new ModelManager($this->dbConnection);
        if (is_null($filter)) {
            $models = $modelManager->getAll();
        } else {
            $values = ['name' => $filter];
            $models = $modelManager->getFiltered($values);
        }
        $this->models = $models;
    }
}
