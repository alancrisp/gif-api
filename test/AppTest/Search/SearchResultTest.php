<?php
declare(strict_types=1);

namespace AppTest\Search;

use App\Assert\Assertion;
use App\Search\SearchResult;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SearchResultTest extends TestCase
{
    public function testValidatesTitle(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::VALUE_EMPTY);
        $this->createSearchResult('');
    }

    public function testValidatesUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::INVALID_URL);
        $this->createSearchResult('title', 'not a url');
    }

    public function testProvidesTitle(): void
    {
        $result = $this->createSearchResult('Grumpy Cat');
        $this->assertEquals('Grumpy Cat', $result->getTitle());
    }

    public function testProvidesUrl(): void
    {
        $result = $this->createSearchResult('title', 'https://img.allthegifs.com/grumpycat.gif');
        $this->assertEquals('https://img.allthegifs.com/grumpycat.gif', $result->getUrl());
    }

    private function createSearchResult(string $title, ?string $url = null): SearchResult
    {
        $url = $url ?? 'https://img.allthegifs.com/grumpycat.gif';
        return new SearchResult($title, $url);
    }
}
