<?php
declare(strict_types=1);

namespace AppTest\Search;

use App\Assert\Assertion;
use App\Search\ResultCollection;
use App\Search\ResultRecord;
use App\Search\StaticSearchClient;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class StaticSearchClientTest extends TestCase
{
    public function testValidatesBaseUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::INVALID_NOT_BLANK);
        $this->createClient('');
    }

    /**
     * @dataProvider invalidGifConfigs
     */
    public function testValidatesGifsConfig(array $gifs): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->createClient('gifs.com', $gifs);
    }

    public function invalidGifConfigs(): array
    {
        return [
            [
                // Empty gif config
                [],
            ],
            [
                // Missing title key
                ['file' => 'notitle.gif'],
            ],
            [
                // Missing file key
                ['title' => 'nofile'],
            ],
        ];
    }

    public function testReturnsEmptyCollectionWhenNoResults(): void
    {
        $client = $this->createClient();
        $result = $client->search('cool dog');
        $expected = new ResultCollection();
        $this->assertEquals($expected, $result);
    }

    public function testSearchesGifs(): void
    {
        $client = $this->createClient();
        $result = $client->search('keyboard');
        $this->assertCount(1, $result);
    }

    public function testPicksRandomGif(): void
    {
        $client = $this->createClient();
        $result = $client->random();
        $this->assertInstanceOf(ResultRecord::class, $result);
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
