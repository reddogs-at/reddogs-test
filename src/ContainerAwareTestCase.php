<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-test for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-test/blob/master/LICENSE MIT License
 */
namespace Reddogs\Test;

use Interop\Container\ContainerInterface;
use Zend\Expressive\ConfigManager\ConfigManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config;
use PHPUnit\Framework\TestCase;

/**
 * Container aware testcase
 *
 * @deprecated
 */
abstract class ContainerAwareTestCase extends TestCase
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