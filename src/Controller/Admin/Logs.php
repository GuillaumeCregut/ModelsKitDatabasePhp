<?php

namespace App\Controller\Admin;

use Editiel98\App;
use Editiel98\Logger\ErrorLogger;
use Editiel98\Logger\InfoLogger;
use Editiel98\Logger\WarnLogger;
use Editiel98\Router\Controller;

class Logs extends Controller
{
    public function render()
    {
        if (App::ADMIN === $this->userRank) {
            $this->smarty->assign('adminLogs_menu', 'true');
            //Get all Logs
            $infoLog = new InfoLogger();
            $infoLogs = $infoLog->loadFromFile();
            $warnLog = new WarnLogger();
            $warnLogs = @$warnLog->loadFromFile();
            $errLog = new ErrorLogger();
            $errorLogs = $errLog->loadFromFile();
            $this->smarty->assign('warnLogs', $warnLogs);
            $this->smarty->assign('errorLogs', $errorLogs);
            $this->smarty->assign('infoLogs', $infoLogs);
            $this->smarty->display('admin/logs.tpl');
        } else {
            $this->smarty->assign('accueil', 'accueil');
            $this->smarty->display('index.tpl');
        }
    }
}
