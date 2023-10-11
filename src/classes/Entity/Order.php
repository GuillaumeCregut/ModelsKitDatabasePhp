<?php
namespace Editiel98\Entity;

use DateTime;
use Editiel98\Factory;
use Editiel98\Manager\OrderManager;

class Order extends Entity
{
    private OrderManager $manager;
    private int $owner;
    private string $reference;
    private int $provider;
    private $dateOrder;
    private string $name;
    public function __construct()
    {
        $this->manager=Factory::getManager('orderManager');
    }

    public function getOwner(): int
    {
        return $this->owner;
    }

    public function setOwner(int $owner) : self
    {
        $this->owner=$owner;
        return $this;
    }

    public function getRef(): string
    {
        return $this->reference;
    }

    public function setRef(string $ref): self
    {
        $this->reference=$ref;
        return $this;
    }

    public function getProvider(): int
    {
        return $this->provider;
    }

    public function setProvider(int $provider): self
    {
        $this->provider=$provider;
        return $this;
    }

    public function getProviderName(): string
    {
        return $this->name;
    }

    public function getDateOrder(): string
    {
        if(is_null($this->dateOrder)){
            return '';
        }
        return $this->dateOrder;
    }

    public function setDate(string $date): self
    {
        /*todo */
        return $this;
    }
}