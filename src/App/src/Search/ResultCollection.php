<?php
declare(strict_types=1);

namespace App\Search;

use App\Assert\Assertion;
use Countable;

class ResultCollection implements Countable
{
    /**
     * @var array
     */
    private $records;

    public function __construct(array $records = [])
    {
        Assertion::allIsInstanceOf($records, ResultRecord::class);

        $this->records = $records;
    }

    public function getRecords(): array
    {
        return $this->records;
    }

    public function count(): int
    {
        return count($this->records);
    }
}
