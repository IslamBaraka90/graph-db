<?php

namespace Islambaraka90\GraphDb\Factory;

use InvalidArgumentException;
use Islambaraka90\GraphDb\Client\Neo4jClient;
use Islambaraka90\GraphDb\Client\NeptuneClient;
use Islambaraka90\GraphDb\Config\Configuration;

class GraphClientFactory
{
    const NEPTUNE = 'neptune';
    const NEO4J = 'neo4j';

    public static function createClient(string $clientType, Configuration $config)
    {
        switch ($clientType) {
            case self::NEPTUNE:
                $neptuneConfig = $config->getNeptuneConfig();
                return new NeptuneClient($neptuneConfig);
            case self::NEO4J:
                $neo4jConfig = $config->getNeo4jConfig();
                return new Neo4jClient($neo4jConfig);
            default:
                throw new InvalidArgumentException("Invalid client type: {$clientType}");
        }
    }
}
