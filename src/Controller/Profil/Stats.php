<?php

namespace App\Controller\Profil;

use Editiel98\Graph\Graph;
use Editiel98\Manager\StatsManager;
use Editiel98\Router\Controller;
use Exception;

class Stats extends Controller
{
    private string $folder;
    const LIMIT_NUMBER = 5;

    public function render()
    {
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $this->manageDir();
        $baseFolder = 'assets/uploads/users/' . $this->userId . '/stats/';
        $statsManager = new StatsManager($this->dbConnection);
        //Do state
        $states = $statsManager->getStatState($this->userId);
        if ($this->drawGraph($states, 'Etat', 'stategraph.png')) {
            $this->smarty->assign('stateGraph', $baseFolder . 'stategraph.png');
        }
        //Do Brand
        $brands = $statsManager->getStatBrand($this->userId);
        $brandsCompacted = $this->reduceArray($brands);
        if ($this->drawGraph($brandsCompacted, 'Marques', 'brandgraph.png')) {
            $this->smarty->assign('brandGraph', $baseFolder . 'brandgraph.png');
        }
        //Do Era
        $eras = $statsManager->getStatPeriod($this->userId);
        if ($this->drawGraph($eras, 'Périodes', 'periodgraph.png')) {
            $this->smarty->assign('periodGraph', $baseFolder . 'periodgraph.png');
        }
        //Do Category
        $categories = $statsManager->getStatCategory($this->userId);
        if ($this->drawGraph($categories, 'Catégories', 'categorygraph.png')) {
            $this->smarty->assign('categoryGraph', $baseFolder . 'categorygraph.png');
        }
        //Do Provider
        $providers = $statsManager->getStatProvider($this->userId);
        if ($this->drawGraph($providers, 'Fournisseurs', 'providergraph.png')) {
            $this->smarty->assign('providerGraph', $baseFolder . 'providergraph.png');
        }
        //Do Scale
        $scales = $statsManager->getStatScale($this->userId);
        if ($this->drawGraph($scales, 'Echelles', 'scalegraph.png')) {
            $this->smarty->assign('scaleGraph', $baseFolder . 'scalegraph.png');
        }

        $this->smarty->assign('profil', 'profil');
        $this->smarty->assign('stats_menu', 'profil');
        //,,,, , 
        $this->smarty->display('profil/stats.tpl');
    }

    private function drawGraph(array $stat, string $title, string $filename): bool
    {
        if (empty($stat)) {
            return false;
        }
        $values = [];
        foreach ($stat as $v) {
            $name = $v->name;
            if (is_null($name)) {
                $name = 'autres';
            }
            $values[$name] = $v->count;
        }
        try {
            $graph = new Graph($this->folder . $filename);
            $graph->draw($values, $title);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function manageDir()
    {
        $folder = dirname(dirname(dirname(__DIR__))) . '/public/assets/uploads/users/' . $this->userId . '/stats/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        } else {
            $files = glob($folder . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        $this->folder = $folder;
    }

    private function reduceArray(array $array): array
    {
        $tempArray = [];
        $count = 0;
        foreach ($array as $v) {
            if ($v->count < self::LIMIT_NUMBER) {
                $count += $v->count;
            } else {
                $tempArray[]=$v;
            }
        }
        $tempArray[]=(object)['count'=>$count,'name'=>'autres'];
        return $tempArray;
    }
}
