<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;
class RemoveClause extends AbstractClause
{
    protected $items = [];

    public function removeNode(string $alias): self
    {
        $this->items[] = [
            'type' => 'node',
            'alias' => $alias,
        ];
        return $this;
    }

    public function removeProperty(string $alias, string $property): self
    {
        $this->items[] = [
            'type' => 'property',
            'alias' => $alias,
            'property' => $property,
        ];
        return $this;
    }

    public function removeRelationship(string $alias): self
    {
        $this->items[] = [
            'type' => 'relationship',
            'alias' => $alias,
        ];
        return $this;
    }

    private function itemToString($item): string
    {
        return match ($item['type']) {
            'node' => "DETACH DELETE {$item['alias']}",
            'property' => "{$item['alias']}.{$item['property']}",
            'relationship' => "DELETE {$item['alias']}",
        };
    }

    public function toCypher(): string
    {
        $itemsString = implode(', ', array_map([$this, 'itemToString'], $this->items));
        return "REMOVE $itemsString";
    }
}