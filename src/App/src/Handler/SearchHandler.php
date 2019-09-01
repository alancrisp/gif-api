<?php
declare(strict_types=1);

namespace App\Handler;

use App\Search\SearchClient;
use Exception;
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
        $searchTerm = $request->getAttribute('term');
        if (null === $searchTerm) {
            throw new Exception('No search term provided');
        }

        $result = $this->searchClient->search($searchTerm);
        $records = [];
        foreach ($result->getRecords() as $record) {
            $records[] = [
                'title' => $record->getTitle(),
                'url' => $record->getUrl(),
            ];
        }

        return new JsonResponse([
            'count' => count($result),
            'records' => $records,
        ]);
    }
}
