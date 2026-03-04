<?php

namespace Hexlet\Code\formatters;

use Hexlet\Code\FormatterInterface;

class StylishFormatter implements FormatterInterface
{
    private const INDENT_SIZE = 4;
    private const SIGN_OFFSET = 2;
    private const SIGN_MAP    = [
        'unchanged' => ' ',
        'removed'   => '-',
        'added'     => '+',
        'nested'    => ' ',
    ];

    public function format(array $data): string
    {
        return "{\n" . join("\n", $this->renderLevel($data, 1)) . "\n}\n";
    }

    private function renderLevel(array $data, int $depth): array
    {
        return array_map(
            fn ($node, $key) => $this->renderNode($key, $node, $depth),
            $data,
            array_keys($data)
        );
    }

    private function renderNode(string $key, array $node, int $depth): string
    {
        if ($node['status'] === 'nested') {
            $children = join("\n", $this->renderLevel($node['children'], ($depth + 1)));
            return
                $this->renderPrefix('nested', $depth) . $key . ": {\n" . $children . "\n" .
                $this->getIndent($depth) . "}";
        }
        if ($node['status'] === 'changed') {
            return join(
                "\n",
                [
                    $this->renderPrefix('removed', $depth) . $key . ': ' .
                    $this->stringifyValue($node['value']['old'], $depth),
                    $this->renderPrefix('added', $depth) . $key . ': ' .
                    $this->stringifyValue($node['value']['new'], $depth),
                ]
            );
        }
        return
            $this->renderPrefix($node['status'], $depth) . $key . ': ' .
            $this->stringifyValue($node['value'], $depth);
    }

    private function stringifyValue(mixed $value, int $depth = 0): string
    {
        if (is_array($value)) {
            return $this->stringifyArray($value, $depth);
        }
        if (is_bool($value)) {
            return $this->stringifyBool($value);
        }
        return $value === null ? 'null' : (string) $value;
    }

    private function stringifyArray(array $array, int $depth): string
    {
        if (array_is_list($array)) {
            $lines = array_map(
                fn($value) => $this->getIndent($depth + 1) . $this->stringifyValue($value, ($depth + 1)),
                $array
            );
            return "[\n" . join("\n", $lines) . "\n" . $this->getIndent($depth) . "]";
        }
        $lines = array_map(
            fn($key, $value) => $this->getIndent($depth + 1) . $key . ': ' .
            $this->stringifyValue($value, ($depth + 1)),
            array_keys($array),
            $array
        );
        return "{\n" . join("\n", $lines) . "\n" . $this->getIndent($depth) . "}";
    }

    private function stringifyBool(bool $value): string
    {
        return $value ? 'true' : 'false';
    }

    private function renderPrefix(string $status, int $depth): string
    {
        $indent = $this->getIndent($depth);
        return substr_replace($indent, self::SIGN_MAP[$status], -self::SIGN_OFFSET, 1);
    }

    private function getIndent(int $depth): string
    {
        return str_repeat(' ', ($depth * self::INDENT_SIZE));
    }
}
