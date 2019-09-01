<?php
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\RandomHandler;
use App\Search\ResultRecord;
use App\Search\SearchClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class RandomHandlerTest extends TestCase
{
    private $handler;
    private $searchClient;

    protected function setUp(): void
    {
        $this->searchClient = $this->prophesize(SearchClient::class);
        $this->handler = new RandomHandler($this->searchClient->reveal());
    }

    public function testProvidesImage(): void
    {
        $result = new ResultRecord('Nyan Cat', 'https://gifs.com/nyancat.gif');
        $this->searchClient->random()->willReturn($result);
        $expected = [
            'title' => 'Nyan Cat',
            'url' => 'https://gifs.com/nyancat.gif',
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->handler->handle($request->reveal());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expected, $response->getPayload());
    }
}
