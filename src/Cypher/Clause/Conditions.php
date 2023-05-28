<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;

class Conditions
{
    protected $alias;
    protected $conditions = [];

    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    public function equalTo(string $key, $value): self
    {
        $this->addCondition($key, 'eq', $value);
        return $this;
    }

    public function notEqualTo(string $key, $value): self
    {
        $this->addCondition($key, 'neq', $value);
        return $this;
    }

    public function lessThan(string $key, $value): self
    {
        $this->addCondition($key, 'lt', $value);
        return $this;
    }

    public function greaterThan(string $key, $value): self
    {
        $this->addCondition($key, 'gt', $value);
        return $this;
    }

    public function lessThanOrEqualTo(string $key, $value): self
    {
        $this->addCondition($key, 'lte', $value);
        return $this;
    }

    public function greaterThanOrEqualTo(string $key, $value): self
    {
        $this->addCondition($key, 'gte', $value);
        return $this;
    }

    public function startsWith(string $key, string $value): self
    {
        $this->addCondition($key, 'starts with', $value);
        return $this;
    }

    public function endsWith(string $key, string $value): self
    {
        $this->addCondition($key, 'ends with', $value);
        return $this;
    }

    public function contains(string $key, string $value): self
    {
        $this->addCondition($key, 'contains', $value);
        return $this;
    }

    public function inList(string $key, array $values): self
    {
        $this->addCondition($key, 'in', $values);
        return $this;
    }

    public function matchesRegex(string $key, string $regex): self
    {
        $this->addCondition($key, '=~', $regex);
        return $this;
    }

    public function isNull(string $key): self
    {
        $this->addCondition($key, 'is null', null);
        return $this;
    }

    public function isNotNull(string $key): self
    {
        $this->addCondition($key, 'is not null', null);
        return $this;
    }

    public function exists(string $key): self
    {
        $this->addCondition($key, 'exists', null);
        return $this;
    }

    private function addCondition(string $key, string $operator, $value): void
    {
        $this->conditions[] = [
            'alias' => $this->alias,
            'key' => $key,
            'operator' => $operator,
            'value' => $value,
        ];
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }
}