<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;

class BrandManager extends SingleManager
{
    public function __construct(Database $db)
    {
        $this->db=$db;
        $this->table='brand';
        $this->className='Editiel98\Entity\Brand';
    }
}