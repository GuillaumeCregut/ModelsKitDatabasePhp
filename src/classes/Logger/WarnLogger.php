<?php

namespace Editiel98\Logger;

/**
 * Logger for warnings
 */
class WarnLogger extends Logger
{
    public function __construct()
    {
        parent::__construct('warn');
    }
}
