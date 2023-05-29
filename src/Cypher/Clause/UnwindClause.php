<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;

class UnwindClause extends AbstractClause
{
    /**
     * The expression to unwind in the Cypher query.
     *
     * @var string
     */
    protected $expression;

    /**
     * The alias for the unwound results.
     *
     * @var string
     */
    protected $alias;

    /**
     * Create an instance of the UnwindClause class.
     *
     * @param string $expression The expression to unwind in the Cypher query.
     * @param string $alias The alias for the unwound results.
     */
    public function __construct(string $expression, string $alias)
    {
        $this->expression = $expression;
        $this->alias = $alias;
    }

    /**
     * Convert the UnwindClause instance to a Cypher query string.
     *
     * @return string The Cypher query string representation of the UnwindClause.
     */
    public function toCypher(): string
    {
        return 'UNWIND ' . $this->expression . ' AS ' . $this->alias;
    }
}
