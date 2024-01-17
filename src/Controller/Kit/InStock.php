<?php

namespace App\Controller\Kit;

use Editiel98\App;
use Editiel98\Entity\User;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;

class InStock extends Controller
{
    use TraitStock;
    use TraitListKit;
    private string $search = '';
    private array $sorted = [];
    private CSRFCheck $csrfCheck;

    public function render()
    {
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('kits', 'kits');
            $this->smarty->display('kit/notconnected.tpl');
            die();
        }
        $this->csrfCheck = new CSRFCheck($this->session);
        $user = new User();
        $user->setId($this->userId);
        if (!empty($_GET)) {
            if (isset($_GET['name'])) {
                $this->search = htmlspecialchars($_GET['name'], ENT_NOQUOTES, 'UTF-8');
            } else $this->search = false;
            if (!empty($_GET['sort'])) {
                $this->sorted = $this->makeSearch($_GET['sort']);
            }
        } else $this->search = '';
        if (!empty($_POST)) {
            $this->usePost();
        }
        $kits = $user->getStockKit($this->search, $this->sorted);
        $kitCount = count($kits);
        $page = 'kit_stock';
        $this->displayPage($kitCount, $page, $kits, $this->search);  //search : search from $_POST
    }


    private function displayPage(int $count, string $page, array $list, ?string $search = '')
    {
        //Define list of stocks
        $stocks = [
            App::STATE_FINISHED => 'terminé',
            App::STATE_WIP => 'En cours',
        ];
        if (!empty($this->sorted)) {
            $sortDisplay = $this->sorted[1];
            $sortBy = $this->sorted[0];
        } else {
            $sortDisplay = 'asc';
            $sortBy = '';
        }
        $token = $this->csrfCheck->createToken();
        $this->smarty->assign('token', $token);
        $this->smarty->assign('sortBy', $sortBy);
        $this->smarty->assign('orderBy', $sortDisplay);
        $this->smarty->assign('listStock', $stocks);
        $this->smarty->assign('dataList', $list);
        $this->smarty->assign('kits', true);
        $this->smarty->assign('instock_menu', true);
        $this->smarty->assign('title', 'Kit en stock');
        $this->smarty->assign('titleDisplay', 'en stock');
        $this->smarty->assign('actionPage', $page);
        $this->smarty->assign('countKit', $count);
        $this->smarty->assign('searchValue', $search);
        $this->smarty->display('kit/kitlist.tpl');
    }

    private function usePost()
    {
        if (isset($_POST['search'])) {
            $this->search = trim(htmlspecialchars($_POST['search'], ENT_NOQUOTES, 'UTF-8'));
        }
        if (!isset($_POST['action'])) {
            return;
        }
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
        }
        if ($id === 0) {
            return;
        }
        if (empty($_POST['token'])) {
            return;
        }
        $token = $_POST['token'];
        if (!$this->csrfCheck->checkToken($token)) {
            return;
        }
        $action = $_POST['action'];
        switch ($action) {
            case 'delete':
                return $this->deleteModel($id);
                break;
            case 'move':
                return $this->moveStock($id, $_POST['newStock'], $this->userId);
                break;
            default:
                return;
        }
    }

    private function deleteModel(int $id)
    {
        $kitManager = new UserManager($this->dbConnection);
        return $kitManager->deleteModelFromStock($id, $this->userId);
    }
}
