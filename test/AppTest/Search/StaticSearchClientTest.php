<?php
declare(strict_types=1);

namespace AppTest\Search;

use App\Search\SearchResult;
use App\Search\StaticSearchClient;
use PHPUnit\Framework\TestCase;

class StaticSearchClientTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = new StaticSearchClient('gifs.com');
    }

    public function testSearchesGifs(): void
    {
        $result = $this->client->search('keyboard');
        $expected = new SearchResult('Keyboard Cat', 'https://gifs.com/keyboardcat.gif');
        $this->assertEquals($expected, $result);
    }

    public function testPicksRandomGif(): void
    {
        $result = $this->client->random();
        $this->assertInstanceOf(SearchResult::class, $result);
    }
}
