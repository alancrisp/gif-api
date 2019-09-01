<?php
declare(strict_types=1);

namespace AppTest\Search;

use App\Assert\Assertion;
use App\Search\ResultRecord;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ResultRecordTest extends TestCase
{
    public function testValidatesTitle(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::VALUE_EMPTY);
        $this->createRecord('');
    }

    public function testValidatesUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::INVALID_URL);
        $this->createRecord('title', 'not a url');
    }

    public function testProvidesTitle(): void
    {
        $result = $this->createRecord('Grumpy Cat');
        $this->assertEquals('Grumpy Cat', $result->getTitle());
    }

    public function testProvidesUrl(): void
    {
        $result = $this->createRecord('title', 'https://img.allthegifs.com/grumpycat.gif');
        $this->assertEquals('https://img.allthegifs.com/grumpycat.gif', $result->getUrl());
    }

    private function createRecord(string $title, ?string $url = null): ResultRecord
    {
        $url = $url ?? 'https://img.allthegifs.com/grumpycat.gif';
        return new ResultRecord($title, $url);
    }
}
