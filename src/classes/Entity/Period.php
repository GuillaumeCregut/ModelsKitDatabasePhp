<?php

namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\PeriodManager;

/**
 * Manage period entity
 */
class Period extends Entity
{
    private string $name;
    private int $id;
    private PeriodManager $manager;

    public function __construct()
    {
        $this->manager = Factory::getManager('periodManager');
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
}
