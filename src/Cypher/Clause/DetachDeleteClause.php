<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;

class DetachDeleteClause extends AbstractClause
{
    /**
     * The pattern to delete in the Cypher query.
     *
     * @var array
     */
    protected $pattern;

    /**
     * Create an instance of the DetachDeleteClause class.
     *
     * @param array $pattern The pattern to delete in the Cypher query.
     */
    public function __construct(array $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * Get the pattern.
     *
     * @return array The pattern to delete in the Cypher query.
     */
    public function getPattern(): array
    {
        return $this->pattern;
    }

    /**
     * Set the pattern.
     *
     * @param array $pattern The pattern to delete in the Cypher query.
     * @return self
     */
    public function setPattern(array $pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Convert the DetachDeleteClause instance to a Cypher query string.
     *
     * @return string The Cypher query string representation of the DetachDeleteClause.
     */
    public function toCypher(): string
    {
        $pattern = '';

        foreach ($this->pattern as $part) {
            if (isset($part['node'])) {
                $alias = $part['node']['alias'] ?? '';
                $pattern .= $alias . ', ';
            }
        }

        // Remove the trailing comma and space
        $pattern = rtrim($pattern, ', ');

        return 'DETACH DELETE ' . $pattern;
    }
}
