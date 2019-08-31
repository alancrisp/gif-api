<?php
declare(strict_types=1);

namespace App;

use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    private function getDependencies(): array
    {
        return [
            'factories' => [
                Handler\IndexHandler::class => InvokableFactory::class,
                Search\StaticSearchClient::class => Search\StaticSearchClientFactory::class,
            ],
        ];
    }
}
