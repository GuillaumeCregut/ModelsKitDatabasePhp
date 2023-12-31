<?php
namespace Editiel98;

use Editiel98\Database\Database;
use Editiel98\Entity\Entity;
use Editiel98\Manager\Manager;

class Factory
{
    private static $_instance;
    private static $db;
    private static $smarty;
    private static $session;

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

    public static function getdB(): Database{
        if(is_null(self::$db)){
            self::$db=new Database();
        }
        return self::$db;
    }

    public static function getManager(string $name): Manager
    {
        if(is_null(self::$db)){
            self::getdB();
        }
        $className='Editiel98\\Manager\\' . ucFirst($name);
        return new $className(self::$db);
    }

    public static function getSmarty():SmartyMKD
    {
        if(is_null(self::$smarty)){
            self::$smarty=new SmartyMKD();
        }
        return self::$smarty;
    }

    public static function getSession():Session
    {
        if(is_null(self::$session)){
            self::$session=new Session();
        }
        return self::$session;
    }
}