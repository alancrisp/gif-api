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
            ConfigAbstractFactory::class => $this->getConfigAbstractFactoryServices(),
            'dependencies' => $this->getDependencies(),
        ];
    }

    private function getDependencies(): array
    {
        return [
            'factories' => [
                Handler\IndexHandler::class => InvokableFactory::class,
                Middleware\ApiKeyMiddleware::class => InvokableFactory::class,
                Search\StaticSearchClient::class => Search\StaticSearchClientFactory::class,
            ],
        ];
    }

    private function getConfigAbstractFactoryServices(): array
    {
        return [
            Handler\SearchHandler::class => [
                Search\StaticSearchClient::class,
            ],
        ];
    }
}
