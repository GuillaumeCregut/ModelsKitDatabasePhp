<?php

namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\ModelManager;

/**
 * Manage Model entity
 */
class Model extends Entity
{
    private string $name;
    private int $id;
    private string $buildername;
    private string $countryname;
    private string $categoryname;
    private string $periodname;
    private string | null $scalemates;
    private string $reference;
    private string $scalename;
    private string $brandname;
    private string | null $picture;
    private bool $liked = false;
    private int $builder;
    private int $category;
    private int $period;
    private int $scale;
    private int $brand;
    private int $countryId;
    private int $globalRate=0;
    private int $userRate=0;

    private ModelManager $manager;

    public function __construct()
    {
        $this->manager = Factory::getManager('modelManager');
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
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brandname;
    }

    /**
     * @param string $name
     * 
     * @return self
     */
    public function setBrandName(string $name): self
    {
        $this->brandname=$name;
        return $this;
    }


    /**
     * @return string
     */
    public function getBuilder(): string
    {
        return $this->buildername;
    }

    /**
     * @param string $name
     * 
     * @return self
     */
    public function setBuilderName(string $name): self
    {
        $this->buildername=$name;
        return $this;
    }


    /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryname;
    }

    /**
     * @param string $name
     * 
     * @return self
     */
    public function setCountryName(string $name): self
    {
        $this->countryname=$name;
        return $this;
    }


    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->categoryname;
    }

    /**
     * @param string $name
     * 
     * @return self
     */
    public function setCategoryName(string $name): self
    {
        $this->categoryname=$name;
        return $this;
    }


    /**
     * @return string
     */
    public function getPeriod(): string
    {
        return $this->periodname;
    }

    /**
     * @param string $name
     * 
     * @return self
     */
    public function setPeriodName(string $name): self
    {
        $this->periodname=$name;
        return $this;
    }

    /**
     * @return string
     */
    public function getScalemates(): string |null
    {
        return $this->scalemates;
    }

    /**
     * @param string $link
     * 
     * @return self
     */
    public function setScalemates(string $link): self
    {
        $this->scalemates = $link;
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
     * @return string
     */
    public function getScale(): string
    {
        return $this->scalename;
    }

    /**
     * @param string $name
     * 
     * @return self
     */
    public function setScaleName(string $name): self
    {
        $this->scalename = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function getLiked(): bool | null
    {
        return $this->liked;
    }


    /**
     * @param bool $liked
     * 
     * @return self
     */
    public function setliked(bool $liked): self
    {
        $this->liked = $liked;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string |null
    {
        return $this->picture;
    }


    /**
     * @param string $image
     * 
     * @return self
     */
    public function setImage(string $image): self
    {
        $this->picture = $image;
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

    /**
     * @return int
     */
    public function getBrandId(): int
    {
        return $this->brand;
    }

    /**
     * @param int $id
     * 
     * @return self
     */
    public function setBrandId(int $id): self
    {
        $this->brand = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getScaleId(): int
    {
        return $this->scale;
    }

    /**
     * @param int $id
     * 
     * @return self
     */
    public function setScaleId(int $id): self
    {
        $this->scale = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getBuilderId(): int
    {
        return $this->builder;
    }

    /**
     * @param int $id
     * 
     * @return self
     */
    public function setBuilderId(int $id): self
    {
        $this->builder = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category;
    }

    /**
     * @param int $id
     * 
     * @return self
     */
    public function setCategoryId(int $id): self
    {
        $this->category = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPeriodId(): int
    {
        return $this->period;
    }

    /**
     * @param int $id
     * 
     * @return self
     */
    public function setPeriodId(int $id): self
    {
        $this->period = $id;
        return $this;
    }

    /**
     * Get the value of countryId
     */ 
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set the value of countryId
     *
     * @return  self
     */ 
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * @return int
     */
    public function getGlobalRate(): int
    {
        return $this->globalRate;
    }

    /**
     * @param int $rate
     * 
     * @return self
     */
    public function setGlobalRate(int $rate): self
    {
        $this->globalRate=$rate;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserRate(): int
    {
        return $this->userRate;
    }

    /**
     * @param int $rate
     * 
     * @return self
     */
    public function setUserRate(int $rate): self
    {
        $this->userRate=$rate;
        return $this;
    }
}
