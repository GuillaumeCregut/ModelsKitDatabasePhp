<?php

namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\BrandManager;

/**
 * Brand
 * Entity to manage brand
 */
class Brand extends Entity
{
    private string $name;
    private int $id;
    private BrandManager $manager;

    public function __construct()
    {
        $this->manager = Factory::getManager('brandManager');
    }

    /**
     * GetId
     * get the id of brand
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * set the brand Id
     *
     * @param integer $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * SetName
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Save Brand to DB
     *
     * @return boolean|integer
     */
    public function save(): bool|int
    {
        return $this->manager->save($this);
    }

    /**
     * Remove brand from DB
     *
     * @return boolean|integer
     */
    public function delete(): bool|int
    {
        return $this->manager->delete($this);
    }

    /**
     * Update Brand in DB
     *
     * @return boolean|integer
     */
    public function update(): bool|int
    {
        return $this->manager->update($this);
    }
}
