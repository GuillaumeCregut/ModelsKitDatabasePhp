<?php

namespace Editiel98\Manager;

use Editiel98\Database\Database;

class ScaleManager extends SingleManager
{
    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->table = 'scale';
        $this->className = 'Editiel98\Entity\Scale';
    }
}
