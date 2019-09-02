<?php
declare(strict_types=1);

namespace App\Search;

use App\Assert\Assertion;
use Exception;

class StaticSearchClient implements SearchClient
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var array Canned responses
     */
    private $gifs;

    public function __construct(string $baseUrl, array $gifs)
    {
        Assertion::notBlank($baseUrl);
        Assertion::notEmpty($gifs);
        Assertion::allKeyIsset($gifs, 'title');
        Assertion::allKeyIsset($gifs, 'file');

        $this->baseUrl = $baseUrl;
        $this->gifs = $gifs;
    }

    public function search(string $query): ResultCollection
    {
        // Normalise search term
        $term = strtolower($query);
        if (!isset($this->gifs[$term])) {
            return new ResultCollection([]);
        }

        $result = $this->gifs[$term];
        $records = [
            new ResultRecord($result['title'], $this->buildUrl($result['file'])),
        ];

        return new ResultCollection($records);
    }

    public function random(): ResultRecord
    {
        $random = rand(1, count($this->gifs));
        $key = array_keys($this->gifs)[$random - 1];
        $result = $this->gifs[$key];

        return new ResultRecord($result['title'], $this->buildUrl($result['file']));
    }

    private function buildUrl(string $file): string
    {
        return sprintf('http://%s/%s', $this->baseUrl, $file);
    }
}
