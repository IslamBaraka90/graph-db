<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;

abstract class AbstractClause
{
    /**
     * Convert the clause instance to a Cypher query string.
     *
     * @return string The Cypher query string representation of the clause.
     */
    abstract public function toCypher(): string;
}
