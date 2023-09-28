<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;
use Editiel98\Entity\Country;

class CountryManager
{
    private Database $db;
    public function __construct(Database $db)
    {
        $this->db=$db;
    }

    public function __get($name)
    {
        $method='get' . ucfirst($name);
        return $this->$method();
    }

    /**
     * 
     * Return all countries
     * @return array
     */
    public function getAll():array
    {
        $result=$this->db->query('SELECT * FROM country','Editiel98\Entity\Country');
        return $result;
    }
/**
 * 
 * get 
 * @param integer $id
 * @return Country
 */
    public function findById(int $id): Country
    {
        $query='SELECT * FROM country WHERE id=:id';
        $result=$this->db->prepare($query,'Editiel98\Entity\Country',[':id'=>$id],true);
        return $result;
    }
}