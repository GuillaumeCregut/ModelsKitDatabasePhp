<?php
namespace Editiel98\Entity;

use Editiel98\App;
use Editiel98\Factory;
use Editiel98\Manager\UserManager;
use Exception;

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
    private array $favorites=[];
    private UserManager $manager;
    private string $password='';
    private array $providers;
    private array $orders;
    private array $models=[];

    public function __construct()
    {
        $this->manager=Factory::getManager('userManager');
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname=$firstname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname=$lastname;
        return $this;
    }

    public function getFullname(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id) : self
    {
        $this->id=$id;
        return $this;
    }

    public function getRankUser(): int
    {
        return $this->rankUser;
    }

    public function setRankUser(int $rank): self
    {
        $this->rankUser=$rank;
        return $this;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    //Revoir la méthode, car ce sera un fichier !
    public function setAvatar(string $avatar): self
    {
        $this->avatar=$avatar;
        return $this;
    }

    public function save(): bool|int
    {
       return $this->manager->save($this);
    }

    public function delete(): bool|int
    {
        return $this->manager->delete($this);
    }

    public function update(): bool|int
    {
        return $this->manager->update($this);
    }
    
    public function setValid(bool $newState): self
    {
        $this->isvalid=$newState;
        return $this;
    }

    public function getValid(): bool
    {
        return $this->isvalid;
    }

    public function setEmail(string $email): self
    {
        $this->email=$email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFavorite(): array
    {
        $this->favorites=[];
        $favorites=$this->manager->getFavorites($this);
        foreach($favorites as $favorite){
            $this->favorites[]=$favorite->idModel;
        }
        return $this->favorites;
        
    }

    public function addFavorite(int $id): bool
    {
        $this->getFavorite();
        if(in_array($id,$this->favorites)){
            return false;
        }
        $addFavorite=$this->manager->addFavorite($this, $id);
        if($addFavorite){
            $this->favorites[]=$id;
            return true;
        }
        return false;

    }

    public function removeFavorite(int $id): bool
    {
        $this->getFavorite();
        if(!in_array($id,$this->favorites)){
            return false;
        }
        $removeFavorite=$this->manager->removeFavorite($this,$id);
        if($removeFavorite){
            $this->favorites[]=$id;
            return true;
            if (($key = array_search($id,  $this->favorites)) !== false) {
                unset($this->favorites[$key]);
            }
            return true;
        }
        return false;
    }

    public function addModelStock(int $idModel, ?int $provider=null, ?float $price=null): bool
    {
        $result=$this->manager->addModelStock($this,$idModel,$provider,$price);
        return $result;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login=$login;
        return $this;
    }

    public function getVisible(): bool
    {
        return $this->isVisible;
    }

    public function setVisible(bool $visibility): self
    {
        $this->isVisible=$visibility;
        return $this;
    }

    public function getAllow(): bool
    {
        return $this->allow;
    }

    public function setAllow(bool $allow): self
    {
        $this->allow=$allow;
        return $this;
    }

    public function setPassword($pass)
    {
        //Encrypt password
        $hashedPassword=password_hash($pass,PASSWORD_DEFAULT);
        $this->password=$hashedPassword;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function getProviders(): array
    {
        //Fetch providers
        $this->providers=$this->manager->getProviders($this);
        return $this->providers;
    }

    public function getOrders(): array
    {
        try{
            $this->orders=$this->manager->getOrders($this);
        }
        catch(Exception $e){
            $this->orders=[];
        }
        return $this->orders;
    }

    public function getModels(): array
    {
        if(empty($this->models)){
            $models=$this->manager->getMyModels($this);
            $this->models=$models;
        }
        return $this->models;
    }

    public function getOrderedKit(?string $filter=''): array
    {
        return $this->manager->getKitByState(App::STATE_BUY,$this->id,$filter);
    }

    public function getStockKit(?string $filter=''): array
    {
        return $this->manager->getKitByState(App::STATE_STOCK,$this->id,$filter);
    }

    public function getWipKit(?string $filter=''): array
    {
        return $this->manager->getKitByState(App::STATE_WIP,$this->id,$filter);
    }

    public function getFinishedKit(?string $filter=''): array
    {
        return $this->manager->getKitByState(App::STATE_FINISHED,$this->id,$filter);
    }
}