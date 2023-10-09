<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;

class ProviderManager extends SingleManager
{
    public function __construct(Database $db)
    {
        $this->db=$db;
        $this->table='provider';
        $this->className='Editiel98\Entity\Provider';
    }
}