<?php

namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Country as EntityCountry;
use Editiel98\Manager\CountryManager;
use Editiel98\Router\Controller;

class Country extends Controller
{
    public function render()
    {
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
        $countryManager = new CountryManager($this->dbConnection);
        $countries = $countryManager->getAll();
        if ($this->isConnected) {
            $this->smarty->assign('connected', true);
            if (App::ADMIN === $this->userRank || App::MODERATE===$this->userRank) {
                $this->smarty->assign('isAdmin', true);
            }
        }
        $this->smarty->assign('list', $countries);
        $this->smarty->assign('params', 'params');
        $this->smarty->assign('country_menu', 'params');
        $this->smarty->display('params/countries.tpl');
    }

    private function usePost(): bool
    {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case "add":
                    if (isset($_POST['name'])) {
                        $name = trim(htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8'));
                        if (strlen($name) === 0) return false;
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

    private function add(string $name): bool
    {
        if (!$this->isConnected) {
            return false;
        }
        $country = new EntityCountry();
        $country->setName($name);
        $result = $country->save();
        return !!$result;
    }

    private function remove(int $id): bool
    {
        if (!(App::ADMIN === $this->userRank || App::MODERATE===$this->userRank)) {
            return false;
        }
        $country = new EntityCountry();
        $country->setId($id);
        return $country->delete();
    }

    private function update(int $id, string $name): bool
    {
        if(!(App::ADMIN===$this->userRank || App::MODERATE==$this->userRank)) {
            return false;
        }
        $country = new EntityCountry();
        $country->setId($id);
        $country->setName($name);
        return $country->update();
    }
}
