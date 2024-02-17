<?php

namespace Editiel98\Logger;

/**
 * logger for infos
 */
class InfoLogger extends Logger
{
    public function __construct()
    {
        parent::__construct('info');
    }
}
