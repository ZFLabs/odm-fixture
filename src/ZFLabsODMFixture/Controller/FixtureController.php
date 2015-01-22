<?php

namespace ZFLabsODMFixture\Controller;

use Zend\Console\ColorInterface;
use Zend\Mvc\Controller\AbstractConsoleController;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\MongoDBExecutor;
use Doctrine\Common\DataFixtures\Purger\MongoDBPurger;

class FixtureController extends AbstractConsoleController
{
    public function indexAction()
    {
        /**
         * @var $console \Zend\Console\Adapter\Posix
         * @var $entityManager \Doctrine\ODM\MongoDB\DocumentManager
         */
        $console = $this->getServiceLocator()->get('console');
        $fixtures_path = $this->getServiceLocator()->get('config');
        $entityManager =  $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
        $request = $this->getRequest();

        $loader = new Loader();

        switch ($request) {
            case $request->getParam('load'):

                $console->writeLine('Aplicando Fixtures', ColorInterface::RED);

                $purger = new MongoDBPurger();
                $executor = new MongoDBExecutor($entityManager , $purger);

                foreach($fixtures_path['zflabs-odm-fixture'] as $key => $path){

                    $loader->loadFromDirectory($path);
                    $fixtures = $loader->getFixtures();

                    foreach($fixtures as  $value){

                        if($request->getParam('purge')) $executor->purge();
                        $executor->load($entityManager, $value);

                        $console->write(get_class($value), ColorInterface::BLUE);
                        $console->writeLine('[OK]', ColorInterface::BLUE);
                    }

                }

                break;
            case $request->getParam('check'):

                foreach($fixtures_path['zflabs-odm-fixture'] as $key => $path){

                    $loader->loadFromDirectory($path);
                    $fixtures = $loader->getFixtures();

                    foreach($fixtures as $value){
                        $console->writeLine(get_class($value), ColorInterface::BLUE);
                    }

                }

                break;
        }

    }
}
