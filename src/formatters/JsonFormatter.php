<?php

namespace Hexlet\Code\formatters;

use Hexlet\Code\FormatterInterface;

class JsonFormatter implements FormatterInterface
{
    public function format(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
