<?php

namespace Hexlet\Code;

class Differ
{
    private const STATUS_UNCHANGED = 'unchanged';
    private const STATUS_CHANGED = 'changed';
    private const STATUS_REMOVED = 'removed';
    private const STATUS_ADDED = 'added';

    public function genDiff(array $firstFile, array $secondFile): array
    {
        $keys = array_unique(array_merge(array_keys($firstFile), array_keys($secondFile)));
        $diff = [];
        foreach ($keys as $key) {
            $diff[$key] = $this->buildNode($key, $firstFile, $secondFile);
        }
        return $diff;
    }

    private function buildNode(string $key, array $firstFile, array $secondFile): array
    {
        $firstValue = array_key_exists($key, $firstFile) ? $firstFile[$key] : null;
        $secondValue = array_key_exists($key, $secondFile) ? $secondFile[$key] : null;
        $node = [];
        if (array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile)) {
            if ($firstValue === $secondValue) {
                $node['status'] = self::STATUS_UNCHANGED;
            } else {
                $node['status'] = self::STATUS_CHANGED;
            }
        } elseif (array_key_exists($key, $firstFile)) {
            $node['status'] = self::STATUS_REMOVED;
        } else {
            $node['status'] = self::STATUS_ADDED;
        }
        if ($this->isAssoc($firstValue) || $this->isAssoc($secondValue)) {
            $node['type'] = 'parent';
            $node['children'] = $this->genDiff(
                is_array($firstValue) ? $firstValue : [],
                is_array($secondValue) ? $secondValue : []
            );
        } else {
            $node['type'] = 'child';
            if ($node['status'] === self::STATUS_CHANGED) {
                $node['value'] = [ 'old' => $firstValue, 'new' => $secondValue];
            } elseif ($node['status'] === self::STATUS_ADDED) {
                $node['value'] = $secondValue;
            } else {
                $node['value'] = $firstValue;
            }
        }
        return $node;
    }

    private function isAssoc(mixed $value): bool
    {
        return is_array($value) && !array_is_list($value);
    }
}
