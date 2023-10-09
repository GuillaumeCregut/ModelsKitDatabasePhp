<?php
namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\ProviderManager;

class Provider extends Entity
{
    private int $id;
    private string $name;
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
}