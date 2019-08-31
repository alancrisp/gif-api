<?php
declare(strict_types=1);

namespace App;

use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;

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
                StaticSearchClient::class => StaticSearchClientFactory::class,
            ],
        ];
    }
}
