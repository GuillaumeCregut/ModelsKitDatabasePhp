<?php

namespace Editiel98\Logger;

class WarnLogger extends Logger
{
    public function __construct()
    {
        parent::__construct('warn');
    }
}
