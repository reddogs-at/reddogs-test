<?php
namespace Reddogs\Test;

use Interop\Container\ContainerInterface;
use Zend\Expressive\ConfigManager\ConfigManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config;

abstract class ContainerAwareTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * Container
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Config manager
     *
     * @var ConfigManager
     */
    private $configManager;

    /**
     * Config manager
     *
     * {@inheritdoc}
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        parent::setUp();

        $config = new \ArrayObject($this->getConfigManager()->getMergedConfig());
        $container = new ServiceManager();
        (new Config($config['dependencies']))->configureServiceManager($container);

        $container->setService('config', $config);

        $this->setContainer($container);
    }

    /**
     * Get container
     *
     * @return ContainerInterface
     */
    public function getContainer()
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
     * Get config manager
     *
     * @return ConfigManager
     */
    public function getConfigManager()
    {
        return $this->configManager;
    }

    /**
     * Set config manager
     *
     * @param ConfigManager $configManager
     */
    public function setConfigManager(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->getContainer()->get('config');
    }
}