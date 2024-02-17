<?php

namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\BuilderManager;

/**
 * Manage Builder Entity
 */
class Builder extends Entity
{
    private string $name;
    private int $id;
    private int $country;
    private string $countryName;
    private BuilderManager $manager;

    public function __construct()
    {
        $this->manager = Factory::getManager('builderManager');
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
     * Get countryName for Buyilder Entity
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }

    /**
     * @param string $countryName
     * 
     * @return self
     */
    public function setCountryName(string $countryName): self
    {
        return $this;
    }

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->country;
    }

    /**
     * @param int $countryId
     * 
     * @return self
     */
    public function setCountryId(int $countryId): self
    {
        $this->country = $countryId;
        return $this;
    }

    /**
     * Save Entity ind DB
     * @return bool
     */
    public function save(): bool|int
    {
        return $this->manager->save($this);
    }

    /**
     * Delete entity from DB
     * @return bool
     */
    public function delete(): bool|int
    {
        return $this->manager->delete($this);
    }

    /**
     * Update Entity in DB
     * @return bool
     */
    public function update(): bool|int
    {
        return $this->manager->update($this);
    }
}
