<?php
namespace ReddogsTest\Test;

use Interop\Container\ContainerInterface;
use Reddogs\Test\ContainerAwareTestCase;
use ReddogsTest\Test\_files\TestModule;
use Zend\ServiceManager\ServiceManager;
use Zend\ConfigAggregator\ConfigAggregator;

require_once __DIR__ . '/_files/TestModule.php';

class ContainerAwareTestCaseTest extends ContainerAwareTestCase
{
    private $testConfigManager;

    protected function setUp()
    {
        $this->testConfigManager = new ConfigAggregator([
            TestModule::class
        ]);
        $this->setConfigManager($this->testConfigManager);
        parent::setUp();
    }

    public function testGetConfigManager()
    {
        $this->assertSame($this->testConfigManager, $this->getConfigManager());
    }

    public function testSetConfigManager()
    {
        $configManager = new ConfigAggregator([]);
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
            'dependencies' => [
                'invokables' => [
                    'TestArrayObject' => \ArrayObject::class
                ]
            ],
        ]);
        $this->assertEquals($expected, $this->getConfig());
    }
}
