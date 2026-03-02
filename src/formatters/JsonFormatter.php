<?php

namespace Hexlet\Code\formatters;

use Hexlet\Code\FormatterInterface;

class JsonFormatter implements FormatterInterface
{
    public function format(array $data): string
    {
        try {
            return json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \Exception('Failed to encode data as JSON: ' . $e->getMessage(), 0, $e);
        }
    }
}
