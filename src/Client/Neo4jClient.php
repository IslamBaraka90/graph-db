<?php

namespace Islambaraka90\GraphDb\Client;
use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;

use Laudis\Neo4j\Databags\SummarizedResult;
use Laudis\Neo4j\Types\CypherMap;
use Psr\Http\Message\ResponseInterface;
class Neo4jClient
{

    private mixed $config;
    private \Laudis\Neo4j\Contracts\ClientInterface $client;

    function __construct($config)
    {
        $this->validateConfig($config);
        $this->connect();
    }

    public function getClient(): \Laudis\Neo4j\Contracts\ClientInterface
    {
        return $this->client;
    }

    public function getSession(): \Laudis\Neo4j\Contracts\SessionInterface
    {
        return $this->client->getDriver(null)->createSession();
    }

   public function run(string $query, array $parameters = [], ?string $tag = null)
    {
        return $this->client->run($query, $parameters, $tag);
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
        //Removed due an error in connection
//        if (strpos($config['url'], '?database=') === false) {
//            $config['url'] = $config['url'] ;
//        }
        $this->config = $config;
    }

    /**
     * @return void
     */
    public function connect(): void
    {
        $this->client = ClientBuilder::create()
            ->withDriver('neo4j', $this->config['url'],
                Authenticate::basic($this->config['username'], $this->config['password']))
            ->withDefaultDriver('neo4j')
            ->build();
        //throw an exception if the connection failed
        if (!$this->client->verifyConnectivity()){
            throw new \Exception('Failed to connect to Neo4j');
        }
    }

    public function disconnect(): void
    {
        // remove the client
        $this->client = null;
    }


    function readbleResult(SummarizedResult $result): array
    {
        $readbleResult = [];
        foreach ($result->records() as $record) {
            $readbleResult[] = $record->values();
        }
        return $readbleResult;
    }

    function summaryText(SummarizedResult $result){
        $summary = $result->getSummary();
        $counters = $summary->getCounters();
        $text = '';
        $text .= 'Running Query '. $summary->getStatement()->getText().PHP_EOL;
        $text .= 'Took ms( '. round(1000 * $summary->getResultAvailableAfter() )  .' )'.PHP_EOL;
        $text .= 'Query Type was: '.  $summary->getQueryType()  .' '.PHP_EOL;
        $text .= 'Created Nodes : '. $counters->nodesCreated() .PHP_EOL;
        $text .= 'Deleted Nodes : '. $counters->nodesDeleted() .PHP_EOL;
        $text .= 'Created Relationships : '. $counters->relationshipsCreated() .PHP_EOL;
        $text .= 'Deleted Relationships : '. $counters->relationshipsDeleted() .PHP_EOL;
        $text .= 'Contains Updates : '. $counters->containsUpdates() .PHP_EOL;
        $text .= 'Rows : '. count ($counters->getIterator() ) .PHP_EOL;
        return $text;
    }

}