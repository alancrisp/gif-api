<?php
declare(strict_types=1);

namespace App\Search;

use Psr\Container\ContainerInterface;

class StaticSearchClientFactory
{
    public function __invoke(ContainerInterface $container): StaticSearchClient
    {
        // @todo get from config
        $baseUrl = 'https://img.allthegifs.com';
        $gifs = $this->getGifs();

        return new StaticSearchClient($baseUrl, $gifs);
    }

    private function getGifs(): array
    {
        return [
            'ceiling' => [
                'title' => 'Ceiling Cat',
                'file' => 'ceilingcat.gif',
            ],
            'grumpy' => [
                'title' => 'Grumpy Cat',
                'file' => 'grumpycat.gif',
            ],
            'keyboard' => [
                'title' => 'Keyboard Cat',
                'file' => 'keyboardcat.gif',
            ],
            'nyan' => [
                'title' => 'Nyan Cat',
                'file' => 'nyancat.gif',
            ],
            'takeoff' => [
                'title' => 'Take-off',
                'file' => 'takeoff.gif',
            ],
        ];
    }
}
