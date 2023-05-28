<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;

//define the class
class CreateClause extends  AbstractClause
{
    /**
     * The pattern to create in the Cypher query.
     *
     * @var array
     */
    protected $pattern;

    /**
     * Create an instance of the CreateClause class.
     *
     * @param array $pattern The pattern to create in the Cypher query.
     */
    public function __construct(array $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * Get the pattern.
     *
     * @return array The pattern to create in the Cypher query.
     */
    public function getPattern(): array
    {
        return $this->pattern;
    }

    /**
     * Set the pattern.
     *
     * @param array $pattern The pattern to create in the Cypher query.
     * @return self
     */
    public function setPattern(array $pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Convert the CreateClause instance to a Cypher query string.
     *
     * @return string The Cypher query stringrepresentation of the CreateClause.
     */
    public function toCypher(): string
    {
        $pattern = '';

        $fromNode = $this->pattern['fromNode'];
        $fromNodeLabel = $fromNode['label'] ?? '';
        $fromNodeProperties = $this->formatProperties($fromNode['properties'] ?? []);

        $toNode = $this->pattern['toNode'];
        $toNodeLabel = $toNode['label'] ?? '';
        $toNodeProperties = $this->formatProperties($toNode['properties'] ?? []);

        $relationship = $this->pattern['relationship'];
        $relationshipType = $relationship['type'] ?? '';
        $relationshipProperties = $this->formatProperties($relationship['properties'] ?? []);

        $pattern .= sprintf("(a:%s %s)-[r:%s %s]->(b:%s %s)", $fromNodeLabel, $fromNodeProperties, $relationshipType, $relationshipProperties, $toNodeLabel, $toNodeProperties);

        return 'CREATE ' . $pattern;
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
            $formattedProperties[] = sprintf("%s: '%s'", $key, addslashes($value));
        }

        return '{' . implode(', ', $formattedProperties) . '}';
    }
}