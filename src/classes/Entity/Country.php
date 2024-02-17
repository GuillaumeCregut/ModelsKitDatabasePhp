<?php

namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\CountryManager;

/**
 * Manage Country Entity
 */
class Country extends Entity
{
    private string $name;
    private int $id;
    private CountryManager $manager;

    public function __construct()
    {
        $this->manager = Factory::getManager('countryManager');
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * 
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Save entity in DB
     * @return bool
     */
    public function save(): bool|int
    {
        return $this->manager->save($this);
    }

    /**
     * delete entity from DB
     * @return bool
     */
    public function delete(): bool|int
    {
        return $this->manager->delete($this);
    }

    /**
     * Update entity in DB
     * @return bool
     */
    public function update(): bool|int
    {
        return $this->manager->update($this);
    }
}
