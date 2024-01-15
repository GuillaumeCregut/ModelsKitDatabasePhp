<?php

namespace Editiel98\Manager;

use Editiel98\Database\Database;

class CategoryManager extends SingleManager
{
    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->table = 'category';
        $this->className = 'Editiel98\Entity\Category';
    }
}
