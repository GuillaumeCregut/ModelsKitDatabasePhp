<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;

class PeriodManager extends SingleManager
{
    public function __construct(Database $db)
    {
        $this->db=$db;
        $this->table='period';
        $this->className='Editiel98\Entity\Period';
    }
}