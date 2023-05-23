<?php

namespace Client;

use Islambaraka90\GraphDb\Client\Neo4jClient;
use PHPUnit\Framework\TestCase;

class Neo4jClientTest extends TestCase
{

    protected static Neo4jClient $client;
    public static function setUpBeforeClass(): void
    {
        // Set up your database connection here
        //load configuration from .env file in the root directory
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $configuration = [
            'url' => $_ENV['NEO4J_URL'],
            'dbname' => $_ENV['NEO4J_DATABASE'],
            'username' => $_ENV['NEO4J_USER'],
            'password' => $_ENV['NEO4J_PASSWORD'],
        ];

        $neo4jClient = new Neo4jClient($configuration);
        self::$client = $neo4jClient;
    }

    public function test__construct()
    {
        $this->assertInstanceOf('Islambaraka90\GraphDb\Client\Neo4jClient', self::$client);
    }

    public function testRun(){
        $client = self::$client;
        $results = $client->run('MATCH (q:Question) RETURN q LIMIT 5');
        //assert that the response contain the query MATCH (q:Question) RETURN q LIMIT 5
        $this->assertStringContainsString('MATCH (q:Question) RETURN q LIMIT 5', $client->summaryText($results));
    }
}
