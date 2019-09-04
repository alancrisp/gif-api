<?php
declare(strict_types=1);

namespace AppTest;

use App\ConfigProvider;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;

class ConfigProviderTest extends TestCase
{
    public function testProvidesConfig(): void
    {
        $provider = new ConfigProvider();
        $config = $provider();
        $this->assertInternalType('array', $config);
        $this->assertArrayHasKey(ConfigAbstractFactory::class, $config);
        $this->assertArrayHasKey('dependencies', $config);
    }
}
