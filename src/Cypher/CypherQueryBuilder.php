<?php

namespace Islambaraka90\GraphDb\Cypher;
use Islambaraka90\GraphDb\Cypher\Clause\AbstractClause;
class CypherQueryBuilder
{
    /**
     * The list of clauses in the query.
     *
     * @var AbstractClause[]
     */
    protected $clauses = [];

    /**
     * Add a clause to the query.
     *
     * @param AbstractClause $clause The clause to add.
     * @return self
     */
    public function addClause(AbstractClause $clause): self
    {
        $this->clauses[] = $clause;
        return $this;
    }

    /**
     * Get the list of clauses in the query.
     *
     * @return AbstractClause[] The list of clauses in the query.
     */
    public function getClauses(): array
    {
        return $this->clauses;
    }

    /**
     * Remove all clauses from the query.
     *
     * @return self
     */
    public function clearClauses(): self
    {
        $this->clauses = [];
        return $this;
    }

    /**
     * Get the query instance.
     *
     * @return CypherQuery The query instance.
     */
    public function getQuery(): CypherQuery
    {
        return new CypherQuery($this->clauses);
    }
}
