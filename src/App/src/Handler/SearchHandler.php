<?php
declare(strict_types=1);

namespace App\Handler;

use App\Search\SearchClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class SearchHandler implements RequestHandlerInterface
{
    /**
     * @var SearchClient
     */
    private $searchClient;

    public function __construct(SearchClient $searchClient)
    {
        $this->searchClient = $searchClient;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        if (!isset($queryParams['term'])) {
            // @todo handle no search term error
            throw new \Exception('no search term'); // @todo
        }

        $result = $this->searchClient->search($queryParams['term']);

        return new JsonResponse([
            'result' => [
                'title' => $result->getTitle(),
                'url' => $result->getUrl(),
            ],
        ]);
    }
}
