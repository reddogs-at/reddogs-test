<?php

namespace ReddogsTest\Test;

use Interop\Container\ContainerInterface;
use Reddogs\Test\ContainerAwareTestCase;
use Zend\Expressive\ConfigManager\ConfigManager;
use ReddogsTest\Test\_files\TestModule;
use Zend\ServiceManager\ServiceManager;

class ContainerAwareTestCaseTest extends ContainerAwareTestCase
{
    private $testConfigManager;

    protected function setUp()
    {
        $this->testConfigManager = new ConfigManager([TestModule::class]);
        $this->setConfigManager($this->testConfigManager);
        parent::setUp();
    }

    public function testGetConfigManager()
    {
        $this->assertSame($this->testConfigManager, $this->getConfigManager());
    }

    public function testSetConfigManager()
    {
        $configManager = new ConfigManager([]);
        $this->setConfigManager($configManager);
        $this->assertSame($configManager, $this->getConfigManager());
    }

    public function testSetContainer()
    {
        $container = $this->createMock(ContainerInterface::class);
        $this->setContainer($container);
        $this->assertSame($container, $this->getContainer());
    }

    public function testGetContainer()
    {
        $this->assertInstanceOf(ServiceManager::class, $this->getContainer());
    }

    public function testGetConfig()
    {
        $expected = new \ArrayObject([
            'dependencies' => []
        ]);
        $this->assertEquals($expected, $this->getConfig());
    }
}