<?php

namespace App\Controller\Profil;


use Editiel98\Entity\Provider as EntityProvider;
use Editiel98\Entity\User;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;
use Editiel98\Session;

class Provider extends Controller
{
    private User $user;
    private array $providers;
    private CSRFCheck $csfrCheck;

    public function render()
    {
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $this->csfrCheck = new CSRFCheck($this->session);
        if (!empty($_POST)) {
            $this->usePost();
        }
        $this->hasFlash = $this->flash->hasFlash();
        /* Render flashes messages */
        if ($this->hasFlash) {
            $flashes = $this->flash->getFlash();
            $this->smarty->assign('flash', $flashes);
        }
        $this->getUser();
        //todo 
        $this->displayPage();
    }

    private function usePost()
    {
        if (empty($_POST['token'])) {
            return false;
        }
        $token = $_POST['token'];
        if (!$this->csfrCheck->checkToken($token)) {
            return false;
        }
        if (!isset($_POST['action'])) {
            return;
        }
        switch ($_POST['action']) {
            case 'add':
                $this->addProvider();
                break;
            case 'update':
                $this->updateProvider();
                break;
            case 'delete':
                $this->deleteProvider();
                break;
            default:
                return;
        }
    }

    private function addProvider(): void
    {
        if (!isset($_POST['name'])) {
            return;
        }
        $name = trim(htmlspecialchars($_POST['name']));
        if ($name === '') {
            return;
        }
        $userId = $this->session->getKey(Session::SESSION_USER_ID);
        $provider = new EntityProvider();
        $provider->setName($name);
        $provider->setOwner($userId);
        $provider->save();
    }

    private function updateProvider(): void
    {
        if (!isset($_POST['name'])) {
            return;
        }
        $name = trim(htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8'));
        if ($name === '') {
            return;
        }
        if (!isset($_POST['id'])) {
            return;
        }
        $id = intval($_POST['id']);
        if ($id === 0) {
            return;
        }
        $provider = new EntityProvider();
        $provider->setName($name);
        $provider->setId($id);
        $provider->update();
    }

    private function deleteProvider(): void
    {
        if (!isset($_POST['id'])) {
            return;
        }
        $id = intval($_POST['id']);
        if ($id === 0) {
            return;
        }
        $provider = new EntityProvider();
        $provider->setId($id);
        $provider->delete();
    }

    /**
     * @return void
     */
    private function getUser(): void
    {
        $userId = $this->session->getKey(Session::SESSION_USER_ID);
        $userManager = new UserManager($this->dbConnection);
        $user = $userManager->findById($userId);
        $this->user = $user;
        $providers = $this->user->getProviders();
        $this->providers = $this->getOrders($providers);
        $this->stringToLink();
    }

    private function getOrders(array $providers): array
    {
        $providersFull=[];
        foreach($providers as $provider){
            $provider->getOrders();
            $providersFull[]=$provider;
        }
        return $providersFull;
    }

    /**
     * @return void
     */
    private function displayPage(): void
    {
        $token = $this->csfrCheck->createToken();
        $this->smarty->assign('token', $token);
        $this->smarty->assign('providers', $this->providers);
        $this->smarty->assign('profil', 'profil');
        $this->smarty->assign('provider_menu', 'profil');
        $this->smarty->display('profil/provider.tpl');
    }

    /**
     * convert string to URL if it is.
     * @return void
     */
    private function stringToLink(): void
    {
        foreach ($this->providers as $key => $provider) {

            $url = parse_url($provider->getName());
            if (!empty($url['scheme'])) {
                $provider->setUrl($provider->getName());
                $provider->setName($url['host']);
            }
        }
    }
}
