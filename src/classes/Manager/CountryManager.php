<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;

class CountryManager extends SingleManager
{
    public function __construct(Database $db)
    {
        $this->db=$db;
        $this->table='country';
        $this->className='Editiel98\Entity\Country';
    }
}