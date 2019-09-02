<?php
declare(strict_types=1);

namespace App;

use Zend\Expressive\Helper\UrlHelper;
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
            'aliases' => [
                // Sets the static search client as default for the purpose of the demo
                // Can be overridden in a *.local.php config file as necessary
                Search\SearchClient::class => Search\StaticSearchClient::class,
            ],
            'factories' => [
                Middleware\ApiKeyMiddleware::class => InvokableFactory::class,
                Search\StaticSearchClient::class => Search\StaticSearchClientFactory::class,
            ],
        ];
    }

    private function getConfigAbstractFactoryServices(): array
    {
        return [
            Handler\IndexHandler::class => [
                UrlHelper::class,
            ],
            Handler\RandomHandler::class => [
                Search\SearchClient::class,
            ],
            Handler\SearchHandler::class => [
                Search\SearchClient::class,
            ],
        ];
    }
}
