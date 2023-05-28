<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;

class WhereClause extends AbstractClause
{
    protected $conditions = [];

    public function __construct(Conditions $conditions)
    {
        $this->conditions = $conditions->getConditions();
    }

    private function conditionToString($condition): string
    {
        $operator = match ($condition['operator']) {
            'eq' => '=',
            'neq' => '<>',
            'lt' => '<',
            'gt' => '>',
            'lte' => '<=',
            'gte' => '>=',
            default => $condition['operator']
        };

        $value = match ($condition['operator']) {
            'in' => '(' . implode(', ', array_map(fn($v) => is_string($v) ? "'$v'" : $v, $condition['value'])) . ')',
            'is null', 'is not null', 'exists' => '',
            default => is_string($condition['value']) ? "'{$condition['value']}'" : $condition['value']
        };

        return "{$condition['alias']}.{$condition['key']} $operator $value";
    }

    public function toCypher(): string
    {
        $conditionsString = implode(' AND ', array_map([$this, 'conditionToString'], $this->conditions));
        return "WHERE $conditionsString";
    }
}
