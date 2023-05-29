<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;

class SkipClause extends AbstractClause
{
    /**
     * The number of results to skip in the Cypher query.
     *
     * @var int
     */
    protected $skip;

    /**
     * Create an instance of the SkipClause class.
     *
     * @param int $skip The number of results to skip in the Cypher query.
     */
    public function __construct(int $skip)
    {
        $this->skip = $skip;
    }

    /**
     * Convert the SkipClause instance to a Cypher query string.
     *
     * @return string The Cypher query string representation of the SkipClause.
     */
    public function toCypher(): string
    {
        return 'SKIP ' . $this->skip;
    }
}