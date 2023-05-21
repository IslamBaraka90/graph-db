<?php

namespace Factory;

use Islambaraka90\GraphDb\Config\Configuration;
use Islambaraka90\GraphDb\Factory\GraphClientFactory;
use PHPUnit\Framework\TestCase;

class GraphClientFactoryTest extends TestCase
{

    public function testCreateClient()
    {
        // Configuration setup
        $neptuneConfig = [
            // ... your Neptune configuration options
        ];

        $neo4jConfig = [
            // ... your Neo4j configuration options
        ];

        $config = new Configuration($neptuneConfig, $neo4jConfig);

        // Create a Neptune client
        $neptuneClient = GraphClientFactory::createClient(GraphClientFactory::NEPTUNE, $config);

        // Create a Neo4j client
        $neo4jClient = GraphClientFactory::createClient(GraphClientFactory::NEO4J, $config);

        //test the type of the client
        $this->assertInstanceOf('Islambaraka90\GraphDb\Client\NeptuneClient', $neptuneClient);
        $this->assertInstanceOf('Islambaraka90\GraphDb\Client\Neo4jClient', $neo4jClient);
    }
}
