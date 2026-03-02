<?php

namespace Hexlet\Code;

class Differ
{
    private const STATUS_UNCHANGED = 'unchanged';
    private const STATUS_CHANGED = 'changed';
    private const STATUS_REMOVED = 'removed';
    private const STATUS_ADDED = 'added';
    private const STATUS_NESTED = 'nested';

    public function genDiff(array $firstFile, array $secondFile): array
    {
        $keys = array_unique(array_merge(array_keys($firstFile), array_keys($secondFile)));
        sort($keys);
        $values = array_map(fn($key) => $this->buildNode($key, $firstFile, $secondFile), $keys);
        return array_combine($keys, $values);
    }

    private function buildNode(string $key, array $firstFile, array $secondFile): array
    {
        [$firstValue, $secondValue] = [
            $this->getValue($firstFile, $key),
            $this->getValue($secondFile, $key)
        ];
        if (!is_null($firstValue) && !is_null($secondValue)) {
            if ($this->isAssoc($firstValue) && $this->isAssoc($secondValue)) {
                return [
                    'status' => self::STATUS_NESTED,
                    'children' => $this->genDiff($firstValue, $secondValue)
                ];
            }
            if ($firstValue === $secondValue) {
                return [
                    'status' => self::STATUS_UNCHANGED,
                    'value' => $firstValue
                ];
            }
            return [
                'status' => self::STATUS_CHANGED,
                'value' => ['old' => $firstValue, 'new' => $secondValue]
            ];
        }
        if (!is_null($firstValue)) {
            return ['status' => self::STATUS_REMOVED, 'value' => $firstValue];
        }
        return ['status' => self::STATUS_ADDED, 'value' => $secondValue];
    }

    private function isAssoc(mixed $value): bool
    {
        return is_array($value) && !array_is_list($value);
    }

    private function getValue(array $array, string $key): mixed
    {
        return $array[$key] ?? null;
    }
}
