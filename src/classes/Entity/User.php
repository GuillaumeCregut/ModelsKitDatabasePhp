<?php

namespace Editiel98\Entity;

use Editiel98\App;
use Editiel98\Factory;
use Editiel98\Manager\UserManager;
use Exception;

/**
 * User Entity
 */
class User extends Entity
{
    private string $firstname;
    private string $lastname;
    private int $id;
    private int $rankUser;
    private string $avatar;
    private bool $isvalid;
    private string $email;
    private string $login;
    private bool $allow;
    private bool $isVisible;
    private array $favorites = [];
    private UserManager $manager;
    private string $password = '';
    private array $providers;
    private array $orders;
    private array $models = [];

    public function __construct()
    {
        $this->manager = Factory::getManager('userManager');
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * 
     * @return self
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * 
     * @return self
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullname(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * 
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getRankUser(): int
    {
        return $this->rankUser;
    }

    /**
     * @param int $rank
     * 
     * @return self
     */
    public function setRankUser(int $rank): self
    {
        $this->rankUser = $rank;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    
    /**
     * @param string $avatar : path to avatar picture
     * 
     * @return self
     */
    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return bool
     */
    public function save(): bool|int
    {
        return $this->manager->save($this);
    }

    /**
     * @return bool
     */
    public function delete(): bool|int
    {
        return $this->manager->delete($this);
    }

    /**
     * @return bool
     */
    public function update(): bool|int
    {
        return $this->manager->update($this);
    }

    /**
     * change user state
     * @param bool $newState
     * 
     * @return self
     */
    public function setValid(bool $newState): self
    {
        $this->isvalid = $newState;
        return $this;
    }

    /**
     * @return bool
     */
    public function getValid(): bool
    {
        return $this->isvalid;
    }

    /**
     * @param string $email
     * 
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getFavorite(): array
    {
        $this->favorites = [];
        $favorites = $this->manager->getFavorites($this);
        foreach ($favorites as $favorite) {
            $this->favorites[] = $favorite->idModel;
        }
        return $this->favorites;
    }

    /**
     * Add a favorite model to user
     * @param int $id : id of model kit
     * 
     * @return bool
     */
    public function addFavorite(int $id): bool
    {
        $this->getFavorite();
        if (in_array($id, $this->favorites)) {
            return false;
        }
        $addFavorite = $this->manager->addFavorite($this, $id);
        if ($addFavorite) {
            $this->favorites[] = $id;
            return true;
        }
        return false;
    }

    /**
     * Remove a favorite model
     * @param int $id : id of model kit
     * 
     * @return bool
     */
    public function removeFavorite(int $id): bool
    {
        $this->getFavorite();
        if (!in_array($id, $this->favorites)) {
            return false;
        }
        $removeFavorite = $this->manager->removeFavorite($this, $id);
        if ($removeFavorite) {
            $this->favorites[] = $id;
            return true;
            if (($key = array_search($id,  $this->favorites)) !== false) {
                unset($this->favorites[$key]);
            }
            return true;
        }
        return false;
    }

    /**
     * Add a model to user's stock
     * @param int $idModel : id of model
     * @param int|null $provider : id of porvider if exists
     * @param float|null $price : price of model if exists
     * 
     * @return bool
     */
    public function addModelStock(int $idModel, ?int $provider = null, ?float $price = null): bool
    {
        $result = $this->manager->addModelStock($this, $idModel, $provider, $price);
        return $result;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * 
     * @return self
     */
    public function setLogin(string $login): self
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return bool
     */
    public function getVisible(): bool
    {
        return $this->isVisible;
    }

    /**
     * @param bool $visibility
     * 
     * @return self
     */
    public function setVisible(bool $visibility): self
    {
        $this->isVisible = $visibility;
        return $this;
    }

    /**
     * @return bool
     */
    public function getAllow(): bool
    {
        return $this->allow;
    }

    /**
     * Change the allow comment right
     * @param bool $allow
     * 
     * @return self
     */
    public function setAllow(bool $allow): self
    {
        $this->allow = $allow;
        return $this;
    }

    
    /**
     * @param string $pass
     * 
     * @return self
     */
    public function setPassword(string $pass) : self
    {
        //Encrypt password
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
        $this->password = $hashedPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * return user's provider list
     * @return array
     */
    public function getProviders(): array
    {
        //Fetch providers
        $this->providers = $this->manager->getProviders($this);
        return $this->providers;
    }

    /**
     * return users orders list
     * @return array
     */
    public function getOrders(): array
    {
        try {
            $this->orders = $this->manager->getOrders($this);
        } catch (Exception $e) {
            $this->orders = [];
        }
        return $this->orders;
    }

    /**
     * return user's models list
     * @return array
     */
    public function getModels(): array
    {
        if (empty($this->models)) {
            $models = $this->manager->getMyModels($this);
            $this->models = $models;
        }
        return $this->models;
    }

    /**
     * return filtered list of user's ordered models
     * @param string|null $filter : filter to apply
     * @param array|null $sorted : array key values as
     * [column name,ASC/DESC]
     * 
     * @return array
     */
    public function getOrderedKit(?string $filter = '', ?array $sorted = []): array
    {
        return $this->manager->getKitByState(App::STATE_BUY, $this->id, $filter, $sorted);
    }

     /**
     * return filtered list of user's stock models
     * @param string|null $filter : filter to apply
     * @param array|null $sorted : array key values as
     * [column name,ASC/DESC]
     * 
     * @return array
     */
    public function getStockKit(?string $filter = '', ?array $sorted = []): array
    {
        return $this->manager->getKitByState(App::STATE_STOCK, $this->id, $filter, $sorted);
    }

     /**
     * return filtered list of user's started models
     * @param string|null $filter : filter to apply
     * @param array|null $sorted : array key values as
     * [column name,ASC/DESC]
     * 
     * @return array
     */
    public function getWipKit(?string $filter = '', ?array $sorted = []): array
    {
        return $this->manager->getKitByState(App::STATE_WIP, $this->id, $filter, $sorted);
    }

    /**
     * Return user's finished kits filtered
     * @param string|null $filter
     * 
     * @return array
     */
    public function getFinishedKit(?string $filter = ''): array
    {
        return $this->manager->getKitByState(App::STATE_FINISHED, $this->id, $filter);
    }
}
