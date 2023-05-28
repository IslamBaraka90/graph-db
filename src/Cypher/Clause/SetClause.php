<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;
class SetClause extends AbstractClause
{
    /**
     * The items to set in the Cypher query.
     *
     * @var array
     */
    protected $items;

    /**
     * Create an instance of the SetClause class.
     *
     * @param array $items The items to set in the Cypher query.
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Convert the SetClause instance to a Cypher query string.
     *
     * @return string The Cypher query string representation of the SetClause.
     */
    public function toCypher(): string
    {
        $cypherParts = [];

        foreach ($this->items as $item) {
            if (isset($item['property'])) {
                $cypherParts[] = $this->formatProperty($item['property']);
            } elseif (isset($item['label'])) {
                $cypherParts[] = $this->formatLabel($item['label']);
            }
        }

        return 'SET ' . implode(', ', $cypherParts);
    }

    /**
     * Format a property assignment for Cypher query string.
     *
     * @param array $property The property assignment to format.
     * @return string The formatted property assignment string.
     */
    protected function formatProperty(array $property): string
    {
        $alias = $property['alias'];
        $key = $property['key'];
        $value = $property['value'];
        $formattedValue = is_string($value) ? sprintf("'%s'", addslashes($value)) : $value;

        return sprintf("%s.%s = %s", $alias, $key, $formattedValue);
    }

    /**
     * Format a label assignment for Cypher query string.
     *
     * @param array $label The label assignment to format.
     * @return string The formatted label assignment string.
     */
    protected function formatLabel(array $label): string
    {
        $alias = $label['alias'];
        $labelName = $label['label'];

        return sprintf("%s:%s", $alias, $labelName);
    }
}