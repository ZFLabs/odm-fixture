<?php

namespace ZFLabsODMFixture;

use Zend\Console\ColorInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use ZFLabsODMFixture\Version\Version;


class Module implements
    InitProviderInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface,
    ConsoleBannerProviderInterface,
    ConsoleUsageProviderInterface

{
    private $version;
    /**
     * {@inheritdoc}
     */
    public function init(ModuleManagerInterface $manager)
    {
        $this->version = '0.0.1';
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConsoleUsage(AdapterInterface $console)
    {
        $console->write(__NAMESPACE__.' Command Line Interface', ColorInterface::BLUE);
        $console->write(' Version ', ColorInterface::GREEN);
        $console->writeLine($this->version, ColorInterface::RED);
        $console->writeLine();

        $console->writeLine('Usage:', ColorInterface::YELLOW);
        $console->writeLine('ZFLabs-orm-fixture <commands> [--options]',  ColorInterface::WHITE);
        $console->writeLine();

        $console->writeLine('Options:', ColorInterface::YELLOW);
        $console->write(' --purge', ColorInterface::GREEN);
        $console->write('   ');
        $console->writeLine('Remove all previous records.',  ColorInterface::WHITE);

        $console->writeLine('Commands:', ColorInterface::YELLOW);

        $console->write('   load', ColorInterface::GREEN);
        $console->write('   ');
        $console->writeLine('Loads all fixtures.', ColorInterface::WHITE);

        $console->write('   check', ColorInterface::GREEN);
        $console->write('   ');
        $console->writeLine('Shows all fixtures to load.', ColorInterface::WHITE);
        $console->writeLine();

        return $console;

    }

    /**
     * {@inheritdoc}
     */
    public function getConsoleBanner(AdapterInterface $console)
    {
        return __NAMESPACE__.' Command Line Interface '. $this->version;
    }
}
