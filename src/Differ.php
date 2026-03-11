<?php

namespace Occulo\Gendiff;

use Funct\Collection;

class Differ
{
    private const STATUS_UNCHANGED = 'unchanged';
    private const STATUS_CHANGED = 'changed';
    private const STATUS_REMOVED = 'removed';
    private const STATUS_ADDED = 'added';
    private const STATUS_NESTED = 'nested';

    public function buildDiff(array $firstFile, array $secondFile): array
    {
        $keys = Collection\sortBy(
            array_unique(array_merge(array_keys($firstFile), array_keys($secondFile))),
            fn($key) => $key
        );
        $values = array_map(fn($key) => $this->buildNode($key, $firstFile, $secondFile), $keys);
        return array_combine($keys, $values);
    }

    private function buildNode(string $key, array $firstFile, array $secondFile): array
    {
        if (array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile)) {
            if ($this->isAssoc($firstFile[$key]) && $this->isAssoc($secondFile[$key])) {
                return [
                    'status' => self::STATUS_NESTED,
                    'children' => $this->buildDiff($firstFile[$key], $secondFile[$key])
                ];
            }
            if ($firstFile[$key] === $secondFile[$key]) {
                return [
                    'status' => self::STATUS_UNCHANGED,
                    'value' => $firstFile[$key]
                ];
            }
            return [
                'status' => self::STATUS_CHANGED,
                'value' => ['old' => $firstFile[$key], 'new' => $secondFile[$key]]
            ];
        }
        if (array_key_exists($key, $firstFile)) {
            return ['status' => self::STATUS_REMOVED, 'value' => $firstFile[$key]];
        }
        return ['status' => self::STATUS_ADDED, 'value' => $secondFile[$key]];
    }

    private function isAssoc(mixed $value): bool
    {
        return is_array($value) && !array_is_list($value);
    }
}
