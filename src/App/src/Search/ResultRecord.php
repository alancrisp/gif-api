<?php
declare(strict_types=1);

namespace App\Search;

use App\Assert\Assertion;

class ResultRecord
{
    private $title;
    private $url;

    public function __construct(string $title, string $url)
    {
        Assertion::notEmpty($title);
        Assertion::url($url);

        $this->title = $title;
        $this->url = $url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
