<?php
declare(strict_types=1);

namespace App\Search;

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
        $this->baseUrl = $baseUrl;
        $this->gifs = $gifs;
    }

    public function search(string $query): SearchResult
    {
        // Normalise search term
        $term = strtolower($query);
        if (!isset($this->gifs[$term])) {
            throw new \Exception('no result'); // @todo
        }

        $result = $this->gifs[$term];

        return new SearchResult($result['title'], $this->buildUrl($result['file']));
    }

    public function random(): SearchResult
    {
        $random = rand(1, count($this->gifs));
        $key = array_keys($this->gifs)[$random - 1];
        $result = $this->gifs[$key];

        return new SearchResult($result['title'], $this->buildUrl($result['file']));
    }

    private function buildUrl(string $file): string
    {
        return sprintf('https://%s/%s', $this->baseUrl, $file);
    }
}
