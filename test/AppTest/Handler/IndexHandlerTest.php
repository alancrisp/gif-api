<?php
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\IndexHandler;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Helper\UrlHelper;

class IndexHandlerTest extends TestCase
{
    /**
     * @var IndexHandler
     */
    private $handler;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    protected function setUp(): void
    {
        $this->urlHelper = $this->prophesize(UrlHelper::class);
        $this->handler = new IndexHandler($this->urlHelper->reveal());
    }

    public function testProvidesIndex(): void
    {
        $this->urlHelper->generate('random')->willReturn('/random');
        $this->urlHelper->generate('search', Argument::type('array'))->willReturn('/search/{term}');
        $expected = [
            'endpoints' => [
                'random' => '/random',
                'search' => '/search/{term}',
            ],
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->handler->handle($request->reveal());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expected, $response->getPayload());
    }
}
