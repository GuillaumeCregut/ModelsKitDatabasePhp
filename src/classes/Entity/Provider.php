<?php

namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\ProviderManager;

/**
 * Manage user's provider entity
 */
class Provider extends Entity
{
    private int $id;
    private string $name;
    private int $owner;
    private string $url = '';
    private array $orders=[];
    
    private ProviderManager $manager;

    public function __construct()
    {
        $this->manager = Factory::getManager('providerManager');
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
     * @return int
     */
    public function getOwner(): int
    {
        return $this->owner;
    }

    /**
     * @param int $owner
     * 
     * @return self
     */
    public function setOwner(int $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        return $this->manager->save($this);
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->manager->update($this);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return $this->manager->delete($this);
    }

    /**
     * @param string $url
     * 
     * @return self
     */
    public function setURL(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getURL(): string
    {
        return $this->url;
    }

    /**
     * Get the value of orders
     */ 
    public function getOrders(): array
    {
        if(empty($this->orders)){
            $orders=$this->manager->getOrders($this->id);
            $this->orders=$orders;
        }
        return $this->orders;
    }

    /**
     * Set the value of orders
     *
     * @return  self
     */ 
    public function setOrders(array $orders):self
    {
        $this->orders = $orders;

        return $this;
    }
}
