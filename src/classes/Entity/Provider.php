<?php
namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\ProviderManager;

class Provider extends Entity
{
    private int $id;
    private string $name;
    private int $owner;
    private ProviderManager $manager;
    public function __construct()
    {
        $this->manager=Factory::getManager('providerManager');
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name=$name;
        return $this;
    }

    public function getOwner(): int
    {
        return $this->owner;
    }

    public function setOwner(int $owner): self
    {
        $this->owner=$owner;
        return $this;
    }

    public function save(): bool
    {
        return $this->manager->save($this);
    }

    public function update(): bool
    {
        return $this->manager->update($this);
    }

    public function delete(): bool
    {
        return $this->manager->delete($this);
    }
}