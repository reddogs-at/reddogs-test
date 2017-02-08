<?php

declare(strict_types=1);

namespace Reddogs\Test;

use Interop\Container\ContainerInterface;
use Zend\Expressive\ConfigManager\ConfigManager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

abstract class ServiceManagerAwareTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Array
     *
     * @var array
     */
    private $configProviders = [];

    /**
     * Container
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Set up
     * {@inheritDoc}
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $container = new ServiceManager();
        $this->setContainer($container);

        $configManager = new ConfigManager($this->getConfigProviders());
        $config = new \ArrayObject($configManager->getMergedConfig());
        if (isset($config['dependencies'])) {
            (new Config($config['dependencies']))->configureServiceManager($container);
        }
        $container->setService('config', $config);
        parent::setUp();
    }

    /**
     * Get config providers
     *
     * @return array
     */
    public function getConfigProviders() : array
    {
        return $this->configProviders;
    }

    /**
     * Set config providers
     *
     * @param array $configProviders
     */
    public function setConfigProviders(array $configProviders)
    {
        $this->configProviders = $configProviders;
    }

    /**
     * Get container
     *
     * @return ContainerInterface
     */
    public function getContainer() : ContainerInterface
    {
        return $this->container;
    }

    /**
     * Set container
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig() : \ArrayObject
    {
        return $this->getContainer()->get('config');
    }
}