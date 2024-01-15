<?php

namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\CountryManager;

class Country extends Entity
{
    private string $name;
    private int $id;
    private CountryManager $manager;

    public function __construct()
    {
        $this->manager = Factory::getManager('countryManager');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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
