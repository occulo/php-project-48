<?php

namespace Hexlet\Code\Formatters;

use Hexlet\Code\FormatterInterface;

class PlainFormatter implements FormatterInterface
{
    public function format(array $data): string
    {
        $output = join("\n", $this->renderLevel($data));
        return $output;
    }

    private function renderLevel(array $data, string $path = ''): array
    {
        $filteredKeys = array_filter($data, fn($node) => $node['status'] !== 'unchanged');
        return array_map(
            fn($key) => $this->renderNode($key, $filteredKeys[$key], $path),
            array_keys($filteredKeys)
        );
    }

    private function renderNode(string $key, array $node, string $path): string
    {
        $fullPath = $path === '' ? $key : "{$path}.{$key}";
        if ($node['status'] === 'nested') {
            return join("\n", $this->renderLevel($node['children'], $fullPath));
        }
        if ($node['status'] === 'changed') {
            return sprintf(
                "Property '%s' was updated. From %s to %s",
                $fullPath,
                $this->stringifyValue($node['value']['old']),
                $this->stringifyValue($node['value']['new'])
            );
        }
        if ($node['status'] === 'added') {
            return sprintf(
                "Property '%s' was added with value: %s",
                $fullPath,
                $this->stringifyValue($node['value'])
            );
        }
        return sprintf("Property '%s' was removed", $fullPath);
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
