<?php
namespace ReddogsTest\Test;

use Reddogs\Test\ServiceManagerAwareTestCase;
use Interop\Container\ContainerInterface;
use ReddogsTest\Test\_files\TestModule;

class ServiceManagerAwareTestCaseTest extends ServiceManagerAwareTestCase
{

    public function testSetConfigProviders()
    {
        $configProviders = [
            TestModule::class
        ];
        $this->setConfigProviders($configProviders);
        $this->assertSame($configProviders, $this->getConfigProviders());
    }

    public function testSetContainer()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $this->setContainer($container);
        $this->assertSame($container, $this->getContainer());
    }

    public function testSetUp()
    {
        $configProviders = [
            TestModule::class
        ];
        $this->setConfigProviders($configProviders);
        parent::setUp();
        $container = $this->getContainer();
        $expectedConfig = new \ArrayObject([
            'dependencies' => [
                'invokables' => [
                    'TestArrayObject' => \ArrayObject::class
                ]
            ],
        ]);
        $this->assertEquals($expectedConfig, $this->getConfig());
        $this->assertInstanceOf(\ArrayObject::class,  $container->get('TestArrayObject'));
    }
}