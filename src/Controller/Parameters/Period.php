<?php

namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Period as EntityPeriod;
use Editiel98\Manager\PeriodManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;

class Period extends Controller
{
    private CSRFCheck $csfrCheck;

    public function render()
    {
        $this->csfrCheck = new CSRFCheck($this->session);
        if (!empty($_POST)) {
            if (!$this->usePost()) {
                $this->hasFlash = $this->flash->hasFlash();
                /* Render flashes messages */
                if ($this->hasFlash) {
                    $flashes = $this->flash->getFlash();
                    $this->smarty->assign('flash', $flashes);
                }
            }
        }
        $periodManager = new PeriodManager($this->dbConnection);
        $periods = $periodManager->getAll();
        if ($this->isConnected) {
            $this->smarty->assign('connected', true);
            if (App::ADMIN === $this->userRank || App::MODERATE === $this->userRank) {
                $this->smarty->assign('isAdmin', true);
            }
        }
        $token = $this->csfrCheck->createToken();
        $this->smarty->assign('token', $token);
        $this->smarty->assign('list', $periods);
        $this->smarty->assign('params', 'params');
        $this->smarty->assign('period_menu', 'params');
        $this->smarty->display('params/periods.tpl');
    }

    /**
     * @return bool
     */
    private function usePost(): bool
    {
        if (empty($_POST['token'])) {
            return false;
        }
        $token = $_POST['token'];
        if (!$this->csfrCheck->checkToken($token)) {
            return false;
        }
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case "add":
                    if (isset($_POST['name'])) {
                        $name = trim(htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8'));
                        if ($name === '') return false;
                        return $this->add($name);
                    } else
                        return false;
                    break;
                case "remove":
                    if (isset($_POST['id'])) {
                        $id = intval($_POST['id']);
                        if ($id === 0) return false;
                        return $this->remove($id);
                    } else
                        return false;
                    break;
                case "update":
                    if (isset($_POST['name'])) {
                        $name = trim(htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8'));
                        if ($name === '') return false;
                    } else
                        return false;
                    if (isset($_POST['id'])) {
                        $id = intval($_POST['id']);
                        if ($id === 0) return false;
                    } else
                        return false;
                    return $this->update($id, $name);
                    break;
                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param string $name
     * 
     * @return bool
     */
    private function add(string $name): bool
    {
        if (!$this->isConnected) {
            return false;
        }
        $period = new EntityPeriod();
        $period->setName($name);
        $result = $period->save();
        return !!$result;
    }

    /**
     * @param int $id
     * 
     * @return bool
     */
    private function remove(int $id): bool
    {
        if (!(App::ADMIN === $this->userRank || App::MODERATE === $this->userRank)) {
            return false;
        }
        $period = new EntityPeriod();
        $period->setId($id);
        return $period->delete();
    }

    /**
     * @param int $id
     * @param string $name
     * 
     * @return bool
     */
    private function update(int $id, string $name): bool
    {
        if (!(App::ADMIN === $this->userRank || App::MODERATE == $this->userRank)) {
            return false;
        }
        $period = new EntityPeriod();
        $period->setId($id);
        $period->setName($name);
        return $period->update();
    }
}
