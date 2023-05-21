<?php

namespace Client;

use Islambaraka90\GraphDb\Client\Neo4jClient;
use PHPUnit\Framework\TestCase;

class Neo4jClientTest extends TestCase
{

    public function test__construct()
    {
        //load configuration from .env file in the root directory
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
//        $configuration = [
//            'url' => 'neo4j+s://4cfe0d8e.databases.neo4j.io?database=Instance01',
//            'dbname' => 'Instance01',
//            'username' => 'neo4j',
//            'password' => 'N56n8rQBuDexj4tBk8M9TN8V_M8gCbrUZkbhr7kdJL4'
//        ];


        $configuration = [
            'url' => $_ENV['NEO4J_URL'],
            'dbname' => $_ENV['NEO4J_DATABASE'],
            'username' => $_ENV['NEO4J_USER'],
            'password' => $_ENV['NEO4J_PASSWORD'],
        ];

        $neo4jClient = new Neo4jClient($configuration);
        die(var_dump($neo4jClient));
        $this->assertInstanceOf('Islambaraka90\GraphDb\Client\Neo4jClient', $neo4jClient);
    }
}
