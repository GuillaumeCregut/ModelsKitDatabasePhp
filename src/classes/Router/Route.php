<?php
namespace Editiel98\Router;

use Editiel98\SmartyMKD;

abstract class Route
{
    protected SmartyMKD $smarty;
    protected array $subPages;
    protected array $params;

    public function __construct(array $subPages=null, array $params=null)
    {
        $this->smarty=new SmartyMKD();
        $this->subPages=$subPages;
        $this->params=$params;
    }
    abstract public function render();


}