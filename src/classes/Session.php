<?php
namespace Editiel98;

use Editiel98\Interfaces\SessionInterface;

class Session implements SessionInterface
{
    public function __construct()
    {
        if(session_status()===PHP_SESSION_NONE)
        session_start();
    }
    
    public function getKey(string $key): mixed
    {
        if(isset( $_SESSION[$key])){
            return $_SESSION[$key];
        }else {
            return null;
        }
    }

    public function setKey(string $key, mixed $value)
    {
        $_SESSION[$key]=$value;
    }

    public function setMultipleKey(string $key, mixed $value){
        $_SESSION[$key][]=$value;
    }

    public function deleteKey(string $key)
    {
        unset($_SESSION[$key]);
    }
}