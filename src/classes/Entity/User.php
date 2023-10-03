<?php
namespace Editiel98\Entity;

use Editiel98\Factory;


class User extends Entity
{
    private $manager;
    private string $firstname;
    private string $lastname;
    private int $id;
    private int $rankUser;
    private string $avatar;
    private bool $isvalid;

    public function __construct(string $firstname, string  $lastname, int  $id, int $rankUser, string  $avatar, bool $isValid)
    {
       // $this->manager=Factory::getManager('countryManager');
       $this->firstname=$firstname;
       $this->lastname=$lastname;
       $this->id=$id;
       $this->rankUser=$rankUser;
       $this->avatar=$avatar;
       $this->isvalid=$isValid;
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
}