<?php
declare(strict_types=1);

namespace AppTest\Middleware;

use App\Middleware\ApiKeyMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;

class ApiKeyMiddlewareTest extends TestCase
{
    /**
     * @var ApiKeyMiddleware
     */
    private $middleware;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @var RequestHandlerInterface
     */
    private $handler;

    protected function setUp(): void
    {
        $this->middleware = new ApiKeyMiddleware();
        $this->request = $this->prophesize(ServerRequestInterface::class);
        $this->handler = $this->prophesize(RequestHandlerInterface::class);
    }

    public function testReturnsBadRequestResponseOnMissingKey(): void
    {
        $response = $this->executeMiddleware();
        $this->request->hasHeader('api-key')->willReturn(false);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testReturnsForbiddenResponseOnInvalidKey(): void
    {
        $this->request->hasHeader('api-key')->willReturn(true);
        $this->request->getHeaderLine('api-key')->willReturn('invalid key');
        $response = $this->executeMiddleware();
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testDelegatesToHandlerOnSuccess(): void
    {
        $called = false;
        $this->handler->handle($this->request)->will(function () use (&$called) {
            $called = true;
            // A response must be returned from the callback
            return new EmptyResponse();
        });
        $this->request->hasHeader('api-key')->willReturn(true);
        $this->request->getHeaderLine('api-key')->willReturn('SHOWMEGIFS');
        $this->executeMiddleware();
        $this->assertTrue($called);
    }

    private function executeMiddleware(): ResponseInterface
    {
        return $this->middleware->process(
            $this->request->reveal(),
            $this->handler->reveal()
        );
    }
}
