<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;
class MatchClause extends AbstractClause
{
    /**
     * The pattern to match in the Cypher query.
     *
     * @var array
     */
    protected $pattern;

    /**
     * Create an instance of the MatchClause class.
     *
     * @param array $pattern The pattern to match in the Cypher query.
     */
    public function __construct(array $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * Get the pattern.
     *
     * @return array The pattern to match in the Cypher query.
     */
    public function getPattern(): array
    {
        return $this->pattern;
    }

    /**
     * Set the pattern.
     *
     * @param array $pattern The pattern to match in the Cypher query.
     * @return self
     */
    public function setPattern(array $pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Convert the MatchClause instance to a Cypher query string.
     *
     * @return string The Cypher query string representation of the MatchClause.
     */
    public function toCypher(): string
    {
        $pattern = '';

        foreach ($this->pattern as $element) {
            if (isset($element['node'])) {
                $node = $element['node'];
                $alias = $node['alias'] ?? '';
                $label = $node['label'] ?? '';
                $properties = $this->formatProperties($node['properties'] ?? []);
                $pattern .= sprintf("(%s:%s %s)", $alias, $label, $properties);
            } elseif (isset($element['relationship'])) {
                $relationship = $element['relationship'];
                $type = $relationship['type'] ?? '';
                $direction = $relationship['direction'] ?? '->';
                $length = isset($relationship['length']) ? '*' . $relationship['length'] : '';
                $properties = $this->formatProperties($relationship['properties'] ?? []);
                $pattern .= sprintf("-[%s:%s %s]%s", $length, $type, $properties, $direction);
            }
        }

        return 'MATCH ' . $pattern;
    }

    /**
     * Format properties for Cypher query string.
     *
     * @param array $properties The properties to format.
     * @return string The formatted properties string.
     */
    protected function formatProperties(array $properties): string
    {
        if (empty($properties)) {
            return '';
        }

        $formattedProperties = [];

        foreach ($properties as $key => $value) {
            $formattedProperties[] = $value !== null ? sprintf("%s: '%s'", $key, addslashes($value)) : $key;
        }

        return '{' . implode(', ', $formattedProperties) . '}';
    }
}