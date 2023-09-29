<?php
namespace Editiel98;

use Editiel98\Entity\Entity;

class Factory
{
    private static $_instance;


    public static function getInstance()
    {
        if(is_null(self::$_instance)){
            self::$_instance=new Factory();
        }
        return self::$_instance;
    }

    public static function getEntity(string $name): Entity
    {
        $className='Editiel98\\Entity\\' . ucFirst($name);
        return new $className;
    }

}