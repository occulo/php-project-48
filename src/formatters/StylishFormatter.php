<?php

namespace Hexlet\Code\formatters;

use Hexlet\Code\FormatterInterface;

class StylishFormatter implements FormatterInterface
{
    private const INDENT_SIZE = 4;
    private const SIGN_OFFSET = 2;
    private const SIGN_MAP = [
        'unchanged' => ' ',
        'removed' => '-',
        'added' => '+',
        'nested' => ' '
    ];

    public function format(array $data): string
    {
        return "{\n" . join("\n", $this->renderLevel($data, 1)) . "\n}\n";
    }

    private function renderLevel(array $data, int $depth): array
    {
        $output = [];
        foreach ($data as $key => $node) {
            $output[] = $this->renderNode($key, $node, $depth);
        }
        return $output;
    }
    
    private function renderNode(string $key, array $node, int $depth): string
    {
        if ($node['status'] === 'nested') {
            $children = join("\n", $this->renderLevel($node['children'], $depth + 1));
            return "{$this->renderPrefix($node['status'], $depth)} {$key}: {\n{$children}\n{$this->getIndent($depth - 1)}}";
        }
        if ($node['status'] === 'changed') {
            return join("\n", [
                "{$this->renderPrefix('removed', $depth)} {$key}: " . $this->stringifyValue($node['value']['old'], $depth),
                "{$this->renderPrefix('added', $depth)} {$key}: " . $this->stringifyValue($node['value']['new'], $depth)
            ]) ;
        }
        return "{$this->renderPrefix($node['status'], $depth)} {$key}: " . $this->stringifyValue($node['value'], $depth);
    }

    private function stringifyValue(mixed $value, int $depth = 0): string
    {
        if (!is_array($value)) {
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }
            return $value === null ? 'null' : (string) $value;
        } else {
            if (array_is_list($value)) {
                $lines = array_map(
                    fn($v) => $this->getIndent($depth + 1) . $this->stringifyValue($v, $depth + 1),
                    $value
                );
                return "[\n" . join("\n", $lines) . "\n" . $this->getIndent($depth) . "]";
            } else {
                $lines = array_map(
                    fn($k, $v) => $this->getIndent($depth + 1) . "$k: " . $this->stringifyValue($v, $depth + 1),
                    array_keys($value),
                    $value
                );
                return "{\n" . join("\n", $lines) . "\n" . $this->getIndent($depth) . "}";
            }
        }
    }

    private function renderPrefix(string $status, int $depth): string
    {
        $indent = $this->getIndent($depth);
        return substr_replace($indent, self::SIGN_MAP[$status], -self::SIGN_OFFSET);
    }

    private function getIndent(int $depth): string
    {
        return str_repeat(' ', $depth * self::INDENT_SIZE);
    }
}
