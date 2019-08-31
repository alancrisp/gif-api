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
    private $gifs = [
        'ceiling' => [
            'title' => 'Ceiling Cat',
            'file' => 'ceilingcat.gif',
        ],
        'grumpy' => [
            'title' => 'Grumpy Cat',
            'file' => 'grumpycat.gif',
        ],
        'keyboard' => [
            'title' => 'Keyboard Cat',
            'file' => 'keyboardcat.gif',
        ],
        'nyan' => [
            'title' => 'Nyan Cat',
            'file' => 'nyancat.gif',
        ],
        'takeoff' => [
            'title' => 'Take-off',
            'file' => 'takeoff.gif',
        ],
    ];

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function search(string $query): SearchResult
    {
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
