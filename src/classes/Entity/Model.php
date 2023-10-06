<?php
namespace Editiel98\Entity;

use Editiel98\Factory;
use Editiel98\Manager\ModelManager;

class Model extends Entity{
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
    private bool $liked=false;
    private string | null $picture;

    private int $builder;
    private int $countryid;
    private int $category;
    private int $period;
    private int $scale;
    private int $brand;

    private ModelManager $manager;

    public function __construct()
    {
        $this->manager=Factory::getManager('modelManager');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
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
    public function getBrand(): string
    {
        return $this->brandname;
    }

    // public function set(string $name): self
    // {
    //     $this->=$name;
    //     return $this;
    // }

    public function getBuilder():  string
    {
        return $this->buildername;
    }

    // public function setBuilder(): self
    // {
    //     $this->=;
    //     return $this;
    // }

    public function getCountryName(): string
    {
        return $this->countryname;
    }

    // public function set(): self
    // {
    //     $this->=;
    //     return $this;
    // }

    public function getCategory(): string 
    {
        return $this->categoryname;
    }

    // public function set(): self
    // {
    //     $this->=;
    //     return $this;
    // }

    public function getPeriod(): string 
    {
        return $this->periodname;
    }

    // public function set(): self
    // {
    //     $this->=;
    //     return $this;
    // }

    public function getScalemates(): string |null
    {
        return $this->scalemates;
    }

    public function setScalemates(string $link): self
    {
        $this->scalemates=$link;
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

    public function getScale(): string 
    {
        return $this->scalename;
    }


    // public function set(): self
    // {
    //     $this->=;
    //     return $this;
    // }

    public function getLiked(): bool | null
    {
        return $this->liked;
    }


    public function setliked(bool $liked): self
    {
        $this->liked=$liked;
        return $this;
    }

    public function getImage(): string |null
    {
        return $this->picture;
    }


    public function setImage(string $image): self
    {
        $this->picture=$image;
        return $this;
    }

    //Have to do getter/setter or ids

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

    public function setBrandId(int $id): self
    {
        $this->brand=$id;
        return $this;
    }

    public function setScaleId(int $id): self
    {
        $this->scale=$id;
        return $this;
    }

    public function setBuilderId(int $id): self
    {
        $this->builder=$id;
        return $this;
    }

    public function setCategoryId(int $id): self
    {
        $this->category=$id;
        return $this;
    }

    public function setPeriodId(int $id): self
    {
        $this->period=$id;
        return $this;
    }
}