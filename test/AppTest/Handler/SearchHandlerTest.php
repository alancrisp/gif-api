<?php
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\SearchHandler;
use App\Search\SearchClient;
use App\Search\SearchResult;
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

    public function testProvidesResult(): void
    {
        $searchResult = new SearchResult('Grumpy Cat', 'https://gifs.com/grumpycat.gif');
        $this->searchClient->search('grumpy')->willReturn($searchResult);
        $expected = [
            'result' => [
                'title' => 'Grumpy Cat',
                'url' => 'https://gifs.com/grumpycat.gif',
            ],
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getQueryParams()->willReturn(['term' => 'grumpy']);
        $response = $this->handler->handle($request->reveal());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expected, $response->getPayload());
    }
}
