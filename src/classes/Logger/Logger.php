<?php

namespace Editiel98\Logger;

use App\Controller\Error;
use DateTime;
use Exception;

abstract class Logger implements LoggerInterface
{
    private string $filename;

    public function __construct(string $filename)
    {
        $directory = dirname(dirname(__DIR__)) . '/logs/';
        $this->filename = $directory . $filename . '.log';
    }

    public function storeToFile(string $value): bool
    {
        date_default_timezone_set('Europe/Paris');
        $now = new DateTime();
        $dateMessage = date_format($now, 'd/m/Y H:i:s');
        $message = $dateMessage . ' : ' . $value . "\n";
        try {
            if (($file = fopen($this->filename, 'a')) && (is_writable($this->filename))) {
                fwrite($file, $message);
                fclose($file);
                return true;
            } else {
                echo "Pas put ouvrir";
                return false;
            }
        } catch (Exception $e) {
            $error = new Error($e->getMessage());
            $error->render();
            die();
        }
    }

    public function loadFromFile(): array|bool
    {
        $logs = [];
        if ($file = fopen($this->filename, 'r')) {
            while (!feof($file)) {
                $line = fgets($file);
                if ($line) {
                    $logs[] = $line;
                }
            }
            return $logs;
        } else {
            return false;
        }
    }
}
