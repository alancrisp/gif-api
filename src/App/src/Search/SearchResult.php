<?php
declare(strict_types=1);

namespace App\Search;

class SearchResult
{
    private $title;
    private $url;

    public function __construct(string $title, string $url)
    {
        // @todo validate params
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
