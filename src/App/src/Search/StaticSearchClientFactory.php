<?php
declare(strict_types=1);

namespace App\Search;

use Exception;
use Psr\Container\ContainerInterface;

class StaticSearchClientFactory
{
    public function __invoke(ContainerInterface $container): StaticSearchClient
    {
        $config = $container->get('config');
        if (!isset($config['urls']['base'])) {
            throw new Exception('Base URL is not configured');
        }

        return new StaticSearchClient(
            $config['urls']['base'],
            $this->getGifs()
        );
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
