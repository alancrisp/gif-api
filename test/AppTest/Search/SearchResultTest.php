<?php
declare(strict_types=1);

namespace AppTest\Search;

use App\Search\SearchResult;
use PHPUnit\Framework\TestCase;

class SearchResultTest extends TestCase
{
    public function testProvidesTitle(): void
    {
        $result = new SearchResult('Grumpy Cat', 'https://img.allthegifs.com/grumpycat.gif');
        $this->assertEquals('Grumpy Cat', $result->getTitle());
    }

    public function testProvidesUrl(): void
    {
        $result = new SearchResult('Grumpy Cat', 'https://img.allthegifs.com/grumpycat.gif');
        $this->assertEquals('https://img.allthegifs.com/grumpycat.gif', $result->getUrl());
    }
}
