<?php

namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\OrderManager;

/**
 * Order 
 * Manage user's orders
 */
class Order extends Entity
{
    private OrderManager $manager;
    private int $owner;
    private string $reference;
    private int $provider;
    private $dateOrder;
    private string $name;
    private array $lines = [];

    public function __construct()
    {
        $this->manager = Factory::getManager('orderManager');
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
     * @return string
     */
    public function getRef(): string
    {
        return $this->reference;
    }

    /**
     * @param string $ref
     * 
     * @return self
     */
    public function setRef(string $ref): self
    {
        $this->reference = $ref;
        return $this;
    }

    /**
     * @return int
     */
    public function getProvider(): int
    {
        return $this->provider;
    }

    /**
     * @param int $provider
     * 
     * @return self
     */
    public function setProvider(int $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDateOrder(): string
    {
        if (is_null($this->dateOrder)) {
            return '';
        }
        return $this->dateOrder;
    }

    /**
     * @param string $date
     * 
     * @return self
     */
    public function setDate(string $date): self
    {
        $this->dateOrder = $date;
        return $this;
    }

    /**
     * Add a line in user's order
     * @param int $id : model Id
     * @param float $price model price
     * @param int $qty quantity ordered
     * 
     * @return self
     */
    public function addLines(int $id, float $price, int $qty): self
    {
        $newLine = [
            'price' => $price,
            'id' => $id,
            'qty' => $qty
        ];
        $this->lines[] = $newLine;
        return $this;
    }

    /**
     * return all lines of the current order
     * @return array
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        return $this->manager->save($this);
    }
}
