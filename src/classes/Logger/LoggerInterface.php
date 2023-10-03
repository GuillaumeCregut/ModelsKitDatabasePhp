<?php
namespace Editiel98\Logger;

interface LoggerInterface
{
    public function storeToFile(string $value) :bool;
    public function loadFromFile(): array | bool;
}