<?php
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\SearchHandler;
use App\Search\ResultCollection;
use App\Search\ResultRecord;
use App\Search\SearchClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class SearchHandlerTest extends TestCase
{
    private $handler;
    private $searchClient;

    protected function setUp(): void
    {
        $this->searchClient = $this->prophesize(SearchClient::class);
        $this->handler = new SearchHandler($this->searchClient->reveal());
    }

    public function testReturnsErrorOnMissingSearchTerm(): void
    {
        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->handler->handle($request->reveal());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(['error' => 'No search term provided'], $response->getPayload());
    }

    public function testProvidesResult(): void
    {
        $record = new ResultRecord('Grumpy Cat', 'https://gifs.com/grumpycat.gif');
        $result = new ResultCollection([$record]);
        $this->searchClient->search('grumpy')->willReturn($result);
        $expected = [
            'count' => 1,
            'records' => [
                [
                    'title' => 'Grumpy Cat',
                    'url' => 'https://gifs.com/grumpycat.gif',
                ],
            ],
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getAttribute('term')->willReturn('grumpy');
        $response = $this->handler->handle($request->reveal());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expected, $response->getPayload());
    }
}
