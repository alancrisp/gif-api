<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class ApiKeyMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->hasHeader('api-key')) {
            return new JsonResponse(['error' => 'API key is missing'], 400);
        }

        $apiKey = $request->getHeaderLine('api-key');
        if ('SHOWMEGIFS' != strtoupper($apiKey)) {
            return new JsonResponse(['error' => 'API key is invalid'], 403);
        }

        return $handler->handle($request);
    }
}
