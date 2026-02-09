<?php

namespace Hexlet\Code\formatters;

use Hexlet\Code\FormatterInterface;

class StylishFormatter implements FormatterInterface
{
    public function format(array $data): string
    {
        return "{\n" . join("\n", $this->renderLevel($data, 1)) . "\n}\n";
    }

    private function renderLevel(array $data, int $depth): array
    {
        $indent = str_repeat(' ', $depth * 2);
        $signs = [
            'removed' => '-',
            'added' => '+',
            'unchanged' => ' '
        ];
        $output = [];
        foreach ($data as $key => $node) {
            if ($node['status'] === 'changed') {
                $output[] = "{$indent}{$signs['removed']} {$key}: {$this->stringifyValue($node['value']['old'])}";
                $output[] = "{$indent}{$signs['added']} {$key}: {$this->stringifyValue($node['value']['new'])}";
                continue;
            }
            $output[] = "{$indent}{$signs[$node['status']]} {$key}: {$this->stringifyValue($node['value'])}";
        }
        return $output;
    }

    private function stringifyValue(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        return $value === null ? 'null' : (string) $value;
    }
}
