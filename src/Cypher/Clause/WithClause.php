<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;

class WithClause extends AbstractClause
{
    /**
     * The variables to include in the Cypher query.
     *
     * @var array
     */
    protected $variables;

    /**
     * Create an instance of the WithClause class.
     *
     * @param array $variables The variables to include in the Cypher query.
     */
    public function __construct(array $variables)
    {
        $this->variables = $variables;
    }

    /**
     * Get the variables.
     *
     * @return array The variables to include in the Cypher query.
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * Set the variables.
     *
     * @param array $variables The variables to include in the Cypher query.
     * @return self
     */
    public function setVariables(array $variables): self
    {
        $this->variables = $variables;
        return $this;
    }

    /**
     * Convert the WithClause instance to a Cypher query string.
     *
     * @return string The Cypher query string representation of the WithClause.
     */
    public function toCypher(): string
    {
        return 'WITH ' . implode(', ', $this->variables);
    }
}
