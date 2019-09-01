<?php
declare(strict_types=1);

namespace App\Search;

interface SearchClient
{
    public function search(string $query): ResultCollection;

    public function random(): ResultRecord;
}
