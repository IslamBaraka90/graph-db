<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;

class OrderByClause extends AbstractClause
{
    /**
     * The variable to order by in the Cypher query.
     *
     * @var string
     */
    protected $variable;

    /**
     * Create an instance of the OrderByClause class.
     *
     * @param string $variable The variable to order by in the Cypher query.
     */
    public function __construct(string $variable)
    {
        $this->variable = $variable;
    }

    /**
     * Convert the OrderByClause instance to a Cypher query string.
     *
     * @return string The Cypher query string representation of the OrderByClause.
     */
    public function toCypher(): string
    {
        return 'ORDER BY ' . $this->variable;
    }
}
