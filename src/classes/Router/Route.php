<?php
namespace Editiel98\Router;

use Editiel98\SmartyMKD;

abstract class Route
{
    protected $smarty;

    public function __construct()
    {
        $this->smarty=new SmartyMKD();
    }
    abstract public function render();


}