<?php
declare(strict_types=1);

namespace AppTest\Search;

use App\Search\SearchResult;
use App\Search\StaticSearchClient;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class StaticSearchClientTest extends TestCase
{
    public function testValidatesBaseUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->createClient('');
    }

    public function testValidatesGifsConfig(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->createClient('gifs.com', []);
    }

    public function testThrowsExceptionWhenNoSearchResult(): void
    {
        $client = $this->createClient();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('No result found matching search term \'cool dog\'');
        $client->search('cool dog');
    }

    public function testSearchesGifs(): void
    {
        $client = $this->createClient();
        $result = $client->search('keyboard');
        $expected = new SearchResult('Keyboard Cat', 'https://gifs.com/keyboardcat.gif');
        $this->assertEquals($expected, $result);
    }

    public function testPicksRandomGif(): void
    {
        $client = $this->createClient();
        $result = $client->random();
        $this->assertInstanceOf(SearchResult::class, $result);
    }

    private function createClient(string $baseUrl = 'gifs.com', ?array $gifs = null): StaticSearchClient
    {
        $gifs = $gifs ?? $this->getGifs();

        return new StaticSearchClient($baseUrl, $gifs);
    }

    private function getGifs(): array
    {
        return [
            'keyboard' => [
                'title' => 'Keyboard Cat',
                'file' => 'keyboardcat.gif',
            ],
        ];
    }
}
