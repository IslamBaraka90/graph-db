<?php

namespace Islambaraka90\GraphDb\Cypher;

class CypherQuery
{
    /**
     * The list of clauses in the query.
     *
     * @var AbstractClause[]
     */
    protected $clauses;

    /**
     * Create a new instance of the CypherQuery class.
     *
     * @param AbstractClause[] $clauses The list of clauses in the query.
     */
    public function __construct(array $clauses)
    {
        $this->clauses = $clauses;
    }

    /**
     * Convert the query instance to a Cypher query string.
     *
     * @return string The Cypher query string representation of the query.
     */
    public function toCypher(): string
    {
        $cypher = '';

        foreach ($this->clauses as $clause) {
            if (!empty($cypher)) {
                $cypher .= ' ';
            }
            $cypher .= $clause->toCypher();
        }

        return $cypher;
    }
}
