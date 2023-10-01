<?php
namespace Editiel98\Interfaces;

interface SessionInterface
{
    public function getKey($key);
    public function setKey($key,$value);
    public function deleteKey($key);
}