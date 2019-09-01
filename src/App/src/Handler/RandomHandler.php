<?php
declare(strict_types=1);

namespace App\Handler;

use App\Search\SearchClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class RandomHandler implements RequestHandlerInterface
{
    private $searchClient;

    public function __construct(SearchClient $searchClient)
    {
        $this->searchClient = $searchClient;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $result = $this->searchClient->random();

        return new JsonResponse([
            'title' => $result->getTitle(),
            'url' => $result->getUrl(),
        ]);
    }
}
