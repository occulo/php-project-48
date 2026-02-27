<?php

namespace Hexlet\Code\formatters;

use Hexlet\Code\FormatterInterface;

class PlainFormatter implements FormatterInterface
{
    public function format(array $data): string
    {
        return join("\n", $this->renderLevel($data));
    }

    private function renderLevel(array $data, string $path = ''): array
    {
        $output = [];
        foreach ($data as $key => $node) {
            if ($node['status'] === 'unchanged') {
                continue;
            }
            $output[] = $this->renderNode($key, $node, $path);
        }
        return $output;
    }

    private function renderNode(string $key, array $node, string $path): string
    {
        $fullPath = $path === '' ? $key : "{$path}.{$key}";
        if ($node['status'] === 'nested') {
            return join("\n", $this->renderLevel($node['children'], $fullPath));
        }
        if ($node['status'] === 'changed') {
            return "Property '{$fullPath}' was updated. From " .
                $this->stringifyValue($node['value']['old']) . " to " .
                $this->stringifyValue($node['value']['new']);
        }
        if ($node['status'] === 'added') {
            return "Property '{$fullPath}' was added with value: " .
            $this->stringifyValue($node['value']);
        }
        return "Property '{$fullPath}' was removed";
    }

    private function stringifyValue(mixed $value): string
    {
        if (!is_array($value)) {
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }
            if (is_string($value)) {
                return "'{$value}'";
            }
            return $value === null ? 'null' : (string) $value;
        } else {
            return '[complex value]';
        }
    }
}
