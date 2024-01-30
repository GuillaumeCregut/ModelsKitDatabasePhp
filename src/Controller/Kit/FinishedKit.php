<?php

namespace App\Controller\Kit;

use Editiel98\Manager\ModelManager;
use Editiel98\Router\Controller;

class FinishedKit extends Controller
{
    private int $count = 0;
    private array $models = [];
    private array $sorted = [];

    public function render()
    {
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('kits', 'kits');
            $this->smarty->display('kit/notconnected.tpl');
            die();
        }
        $modelManager = new ModelManager($this->dbConnection);
        $FilterValues = $this->getParams();
        $models = $modelManager->getFinishedModels($this->userId, $FilterValues);
        $this->models = $models;
        $this->count = count($models);
        $this->displayPage();
    }

    private function getParams(): array
    {
        if (empty($this->params)) {
            return  [];
        }
        $filterName = explode('=', $this->params[0]);
        if ($filterName[0] !== 'sort') {
            return [];
        }
        switch ($filterName[1]) {
            case 'name':
                $name='modelName';
                break;
            case 'brand':
                $name='brandName';
                break;
            case 'scale':
                $name='scaleName';
                break;
            case 'pictures':
                $name='pictures';
                break;
            case 'builder':
                $name='builderName';
                break;
            default : $name='modelName';
        }
        $returnArray[] = $name;
        $this->sorted[0]=$name;
        $sorted = explode('=', $this->params[1]);
        if ($sorted[0] !== 'by') {
            $this->sorted=[];
            return [];
        }
        if ($sorted[1] === 'asc'){
            $this->sorted[1] ='asc';
            $returnArray[] = 'asc';
        }    
        else{
            $returnArray[] = 'desc';
            $this->sorted[1] ='desc';
        }
        
        return $returnArray;
    }

    private function displayPage()
    {
        if (!empty($this->sorted)) {
            $sortBy = $this->sorted[0];
            $sortDisplay = $this->sorted[1];
        } else {
            $sortDisplay = 'asc';
            $sortBy = '';
        }
        $this->smarty->assign('sortBy', $sortBy);
        $this->smarty->assign('orderBy', $sortDisplay);
        $this->smarty->assign('countKit', $this->count);
        $this->smarty->assign('dataList', $this->models);
        $this->smarty->assign('finished_menu', true);
        $this->smarty->assign('kits', true);
        $this->smarty->display('kit/finished.tpl');
    }
}
