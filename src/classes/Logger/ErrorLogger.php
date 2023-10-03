<?php
namespace Editiel98\Logger;

class ErrorLogger extends Logger
{
    public function __construct(){
        parent::__construct('error');
    }
}