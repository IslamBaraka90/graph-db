<?php

namespace Cypher;

use Islambaraka90\GraphDb\Cypher\Clause\Conditions;
use Islambaraka90\GraphDb\Cypher\Clause\CreateClause;
use Islambaraka90\GraphDb\Cypher\Clause\DetachDeleteClause;
use Islambaraka90\GraphDb\Cypher\Clause\MatchClause;
use Islambaraka90\GraphDb\Cypher\Clause\RemoveClause;
use Islambaraka90\GraphDb\Cypher\Clause\ReturnClause;

use Islambaraka90\GraphDb\Cypher\Clause\SetClause;
use Islambaraka90\GraphDb\Cypher\Clause\WhereClause;
use Islambaraka90\GraphDb\Cypher\CypherQueryBuilder;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testCreateClause()
    {

        $pattern = [
            'fromNode' => [
                'label' => 'Person',
                'properties' => [
                    'name' => 'Alice',
                ],
            ],
            'relationship' => [
                'type' => 'FRIENDS_WITH',
                'properties' => [
                    'since' => '2021-01-01',
                ],
            ],
            'toNode' => [
                'label' => 'Person',
                'properties' => [
                    'name' => 'Bob',
                ],
            ],
        ];

        $queryBuilder = new CypherQueryBuilder();
        $queryBuilder->addClause(new CreateClause($pattern));
        $queryBuilder->addClause(new ReturnClause('a, r, b'));

        $query = $queryBuilder->getQuery();
        $queryString = $query->toCypher();

        $this->assertEquals("CREATE (a:Person {name: 'Alice'})-[r:FRIENDS_WITH {since: '2021-01-01'}]->(b:Person {name: 'Bob'}) RETURN a, r, b", $queryString);
    }



    public function testMatchClause()
    {
        $pattern = [
            'fromNode' => [
                'label' => 'Person',
                'properties' => [
                    'name' => 'Alice',
                ],
            ],
            'relationship' => [
                'type' => 'FRIENDS_WITH',
                'properties' => [
                    'since' => '2021-01-01',
                ],
            ],
            'toNode' => [
                'label' => 'Person',
                'properties' => [
                    'name' => 'Bob',
                ],
            ],
        ];

        $queryBuilder = new CypherQueryBuilder();
        $queryBuilder->addClause(new MatchClause($pattern));
        $queryBuilder->addClause(new ReturnClause('a, r, b'));

        $query = $queryBuilder->getQuery();
        $queryString = $query->toCypher();

        $this->assertEquals("MATCH (a:Person {name: 'Alice'})-[r:FRIENDS_WITH {since: '2021-01-01'}]->(b:Person {name: 'Bob'}) RETURN a, r, b", $queryString);
    }


    function testMassMatch(){

// Example 1: MATCH (n:Label)
        $pattern1 = [
            ['node' => ['alias' => 'n', 'label' => 'Label']],
        ];

        $queryBuilder1 = new CypherQueryBuilder();
        $queryBuilder1->addClause(new MatchClause($pattern1));
        $queryBuilder1->addClause(new ReturnClause('n'));
        $queryString1 = $queryBuilder1->getQuery()->toCypher();
        echo $queryString1 . PHP_EOL;

// Example 2: MATCH (n1:Label1)-[:RELATIONSHIP {property: value}]->(n2:Label2)
        $pattern2 = [
            ['node' => ['alias' => 'n1', 'label' => 'Label1']],
            ['relationship' => ['type' => 'RELATIONSHIP', 'properties' => ['property' => 'value']]],
            ['node' => ['alias' => 'n2', 'label' => 'Label2']],
        ];

        $queryBuilder2 = new CypherQueryBuilder();
        $queryBuilder2->addClause(new MatchClause($pattern2));
        $queryBuilder2->addClause(new ReturnClause('n1, n2'));
        $queryString2 = $queryBuilder2->getQuery()->toCypher();
        echo $queryString2 . PHP_EOL;

// Example 3: MATCH (n1:Label1)-[:RELATIONSHIP*3 {property: value}]->(n2:Label2)
        $pattern3 = [
            ['node' => ['alias' => 'n1', 'label' => 'Label1']],
            ['relationship' => ['type' => 'RELATIONSHIP', 'length' => 3, 'properties' => ['property' => 'value']]],
            ['node' => ['alias' => 'n2', 'label' => 'Label2']],
        ];

        $queryBuilder3 = new CypherQueryBuilder();
        $queryBuilder3->addClause(new MatchClause($pattern3));
        $queryBuilder3->addClause(new ReturnClause('n1, n2'));
        $queryString3 = $queryBuilder3->getQuery()->toCypher();
        echo $queryString3 . PHP_EOL;

// Example 4: MATCH (n1:Label1)-[:RELATIONSHIP1]->(n2:Label2)-[:RELATIONSHIP2]->(n3:Label3)-[:RELATIONSHIP3]->(n4:Label4)
        $pattern4 = [
            ['node' => ['alias' => 'n1', 'label' => 'Label1']],
            ['relationship' => ['type' => 'RELATIONSHIP1']],
            ['node' => ['alias' => 'n2', 'label' => 'Label2']],
            ['relationship' => ['type' => 'RELATIONSHIP2']],
            ['node' => ['alias' => 'n3', 'label' => 'Label3']],
            ['relationship' => ['type' => 'RELATIONSHIP3']],
            ['node' => ['alias' => 'n4', 'label' => 'Label4']],
        ];

        $queryBuilder4 = new CypherQueryBuilder();
        $queryBuilder4->addClause(new MatchClause($pattern4));
        $queryBuilder4->addClause(new ReturnClause('n1, n2, n3, n4'));
        $queryString4 = $queryBuilder4->getQuery()->toCypher();
        echo $queryString4 . PHP_EOL;

// Example 5: MATCH (n1:Label1)-[:RELATIONSHIP1]->(n2:Label2)-[:RELATIONSHIP2]->(n3:Label3)-[:RELATIONSHIP3]->(n4:Label4)-[:RELATIONSHIP4]->(n5:Label5)-[:RELATIONSHIP5]->(n6:Label6)
        $pattern5 = [
            ['node' => ['alias' => 'n1', 'label' => 'Label1']],
            ['relationship' => ['type' => 'RELATIONSHIP1']],
            ['node' => ['alias' => 'n2', 'label' => 'Label2']],
            ['relationship' => ['type' => 'RELATIONSHIP2']],
            ['node' => ['alias' => 'n3', 'label' => 'Label3']],
            ['relationship' => ['type' => 'RELATIONSHIP3']],
            ['node' => ['alias' => 'n4', 'label' => 'Label4']],
            ['relationship' => ['type' => 'RELATIONSHIP4']],
            ['node' => ['alias' => 'n5', 'label' => 'Label5']],
            ['relationship' => ['type' => 'RELATIONSHIP5']],
            ['node' => ['alias' => 'n6', 'label' => 'Label6']],
        ];

        $queryBuilder5 = new CypherQueryBuilder();
        $queryBuilder5->addClause(new MatchClause($pattern5));
        $queryBuilder5->addClause(new ReturnClause('n1, n2, n3, n4, n5, n6'));
        $queryString5 = $queryBuilder5->getQuery()->toCypher();
        echo $queryString5 . PHP_EOL;
        die();
    }


    function testSetClause(){
        // Example: MATCH (n:Person {name: 'John'}) SET n.age = 30
        $pattern = [
            ['node' => ['alias' => 'n', 'label' => 'Person', 'properties' => ['name' => 'John']]],
        ];

        $items = [
            ['property' => ['alias' => 'n', 'key' => 'age', 'value' => 30]],
        ];

        $queryBuilder = new CypherQueryBuilder();
        $queryBuilder->addClause(new MatchClause($pattern));
        $queryBuilder->addClause(new SetClause($items));
        $queryString = $queryBuilder->getQuery()->toCypher();

        echo $queryString . PHP_EOL;


        // Example: MATCH (n:Person {name: 'John'}) SET n.age = 30, n.city = 'New York'
        $pattern = [
            ['node' => ['alias' => 'n', 'label' => 'Person', 'properties' => ['name' => 'John']]],
        ];

        $items = [
            ['property' => ['alias' => 'n', 'key' => 'age', 'value' => 30]],
            ['property' => ['alias' => 'n', 'key' => 'city', 'value' => 'New York']],
        ];

        $queryBuilder = new CypherQueryBuilder();
        $queryBuilder->addClause(new MatchClause($pattern));
        $queryBuilder->addClause(new SetClause($items));
        $queryString = $queryBuilder->getQuery()->toCypher();

        echo $queryString . PHP_EOL;


        die();
    }



    function testWhere(){

        $pattern = [
            ['node' => ['alias' => 'n', 'label' => 'Person']],
            ['node' => ['alias' => 'L', 'label' => 'Person' , 'properties' => ['name' => 'John']]],
        ];

        $conditions = new Conditions('n');
        $conditions
        ->greaterThanOrEqualTo('age', 33)
            ->equalTo('name', 'John')
            ->setAlias('L')
            ->equalTo('city', 'New York')
            ->inList('country', ['USA', 'Canada']);

        $queryBuilder = new CypherQueryBuilder();
        $queryBuilder->addClause(new MatchClause($pattern));
        $queryBuilder->addClause(new WhereClause($conditions));
        $queryString = $queryBuilder->getQuery()->toCypher();

        echo $queryString . PHP_EOL;
        die();
    }


    function testRemove(){


        $pattern = [
            ['node' => ['alias' => 'n', 'label' => 'Person']],
            ['relationship' => ['alias' => 'r', 'type' => 'FRIENDS_WITH']],
            ['node' => ['alias' => 'f', 'label' => 'Friend']],
        ];

        $removeClause = (new RemoveClause())
//            ->removeNode('f')
            ->removeProperty('n', 'age');
//            ->removeRelationship('r');

        $queryBuilder = new CypherQueryBuilder();
        $queryBuilder->addClause(new MatchClause($pattern));
        $queryBuilder->addClause($removeClause);
        $queryString = $queryBuilder->getQuery()->toCypher();

        echo $queryString . PHP_EOL;

        die();
    }


    public function testDeAttach()
    {
        $pattern = [
            ['node' => ['alias' => 'n', 'label' => 'Person']],
            ['relationship' => ['alias' => 'r', 'type' => 'FRIENDS_WITH']],
            ['node' => ['alias' => 'f', 'label' => 'Friend']],
        ];

        $detachDeleteClause = new DetachDeleteClause($pattern);

        $queryBuilder = new CypherQueryBuilder();
        $queryBuilder->addClause(new MatchClause($pattern));
        $queryBuilder->addClause($detachDeleteClause);

        $expected = 'MATCH (n:Person )-[r:FRIENDS_WITH]->(f:Friend ) DETACH DELETE n, f';
        $actual = $queryBuilder->getQuery()->toCypher();

        $this->assertEquals($expected, $actual);
    }

    public function testReturnClause()
    {
        $returnClause = new ReturnClause('n');

        $this->assertEquals('RETURN n', $returnClause->toCypher());
    }
}
