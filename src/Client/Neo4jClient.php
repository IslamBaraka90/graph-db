<?php

namespace Islambaraka90\GraphDb\Client;
use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;

use Psr\Http\Message\ResponseInterface;
class Neo4jClient
{

    private mixed $config;
    private \Laudis\Neo4j\Contracts\ClientInterface $client;

    function __construct($config)
    {
        $this->validateConfig($config);
        $this->client = ClientBuilder::create()
        ->withDriver('neo4j', $this->config['url'] ,
            Authenticate::basic($this->config['username'], $this->config['password'] ))
        ->build();
        var_dump($this->client->verifyConnectivity());
    }

    private function validateConfig($config)
    {
        if (!isset($config['url'])) {
            throw new \InvalidArgumentException('Missing url configuration');
        }
        if (!isset($config['dbname'])) {
            throw new \InvalidArgumentException('Missing dbname configuration');
        }
        if (!isset($config['username'])) {
            throw new \InvalidArgumentException('Missing username configuration');
        }
        if (!isset($config['password'])) {
            throw new \InvalidArgumentException('Missing password configuration');
        }
        //check if the url include the database name or not add it if not
        if (strpos($config['url'], '?database=') === false) {
            $config['url'] = $config['url'] . '?database=' . $config['dbname'];
        }
        $this->config = $config;
    }
    

}