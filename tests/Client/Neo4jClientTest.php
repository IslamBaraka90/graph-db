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

    public function testExtractNodes(){
        $client = self::$client;
        $results = $client->run('MATCH (q:Question) RETURN q LIMIT 5');
        $nodes = $client->extractNodes($results, 'q');
        //assert that the response contain the query MATCH (q:Question) RETURN q LIMIT 5
        $this->assertStringContainsString('MATCH (q:Question) RETURN q LIMIT 5', $client->summaryText($results));
        //assert that the response contain 5 nodes as the limit is 5
        $this->assertCount(5, $nodes);
    }

    //test for the extractRelations method
    public function testExtractRelations(){
        $client = self::$client;
        $results = $client->run('MATCH p=()-[a:ANSWERED]->() RETURN p,a LIMIT 5;');
        $relations = $client->extractRelations($results, 'a');
        //assert that the response contain the query MATCH (q:Question)-[r:RELATED_TO]->(a:Answer) RETURN q,r,a LIMIT 5
        $this->assertStringContainsString('MATCH p=()-[a:ANSWERED]->() RETURN p,a LIMIT 5;', $client->summaryText($results));
        //assert that the response contain 5 relations as the limit is 5
        $this->assertCount(5, $relations);
    }
}
