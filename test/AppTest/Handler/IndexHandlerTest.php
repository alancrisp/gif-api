<?php
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\IndexHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class IndexHandlerTest extends TestCase
{
    public function testProvidesIndex(): void
    {
        $handler = new IndexHandler();
        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $handler->handle($request->reveal());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
