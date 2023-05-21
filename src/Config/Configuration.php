<?php

namespace Islambaraka90\GraphDb\Config;

class Configuration
{
    private $neptuneConfig;
    private $neo4jConfig;

    public function __construct(array $neptuneConfig, array $neo4jConfig)
    {
        $this->neptuneConfig = $neptuneConfig;
        $this->neo4jConfig = $neo4jConfig;
    }

    public function getNeptuneConfig(): array
    {
        return $this->neptuneConfig;
    }

    public function getNeo4jConfig(): array
    {
        return $this->neo4jConfig;
    }

    // Add any other methods needed for handling configuration
}