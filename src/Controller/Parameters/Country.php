<?php
namespace App\Controller\Parameters;

use Editiel98\Factory;

class Country
{
    private $smarty;

    public function __construct($smarty)
    {
        $this->smarty=Factory::getSmarty();
    }

    public function render()
    {
        echo "Country";
        var_dump($_POST);
    }
}