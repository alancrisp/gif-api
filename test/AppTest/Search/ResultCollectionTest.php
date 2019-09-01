<?php
declare(strict_types=1);

namespace AppTest\Search;

use App\Assert\Assertion;
use App\Search\ResultCollection;
use App\Search\ResultRecord;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ResultCollectionTest extends TestCase
{
    public function testValidatesRecords(): void
    {
        $records = ['not a result object'];
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::INVALID_INSTANCE_OF);
        $this->createCollection($records);
    }

    public function testIsCountable(): void
    {
        $records = [
            $this->prophesize(ResultRecord::class)->reveal(),
            $this->prophesize(ResultRecord::class)->reveal(),
            $this->prophesize(ResultRecord::class)->reveal(),
        ];
        $collection = $this->createCollection($records);
        $this->assertEquals(3, count($collection));
    }

    public function testProvidesRecords(): void
    {
        $record1 = new ResultRecord('Grumpy Cat', 'https://allthegifs.com/grumpycat.gif');
        $record2 = new ResultRecord('Keyboard Cat', 'https://allthegifs.com/keyboardcat.gif');
        $records = [$record1, $record2];
        $collection = $this->createCollection($records);
        $this->assertEquals($records, $collection->getRecords());
    }

    private function createCollection(array $records): ResultCollection
    {
        return new ResultCollection($records);
    }
}
