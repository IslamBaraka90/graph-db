<?php

namespace Islambaraka90\GraphDb\Cypher\Clause;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;

class ReturnClause extends AbstractClause
{
    /**
     * The elements to return in the Cypher query.
     *
     * @var string
     */
    protected $elements;

    /**
     * Create an instance of the ReturnClause class.
     *
     * @param string $elements The elements to return in the Cypher query.
     */
    public function __construct(string $elements)
    {
        $this->elements = $elements;
    }

    /**
     * Get the elements.
     *
     * @return string The elements to return in the Cypher query.
     */
    public function getElements(): string
    {
        return $this->elements;
    }

    /**
     * Set the elements.
     *
     * @param string $elements The elements to return in the Cypher query.
     * @return self
     */
    public function setElements(string $elements): self
    {
        $this->elements = $elements;
        return $this;
    }

    /**
     * Convert the ReturnClause instance to a Cypher query string.
     *
     * @return string The Cypher query string representation of the ReturnClause.
     */
    public function toCypher(): string
    {
        return 'RETURN ' . $this->elements;
    }
}