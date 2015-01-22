<?php

$env = (isset($_SERVER['APPLICATION_ENV'])) ? $_SERVER['APPLICATION_ENV'] : 'development';

define('ENV', $env);

/**
 * ZF2 command line tool
 *
 * @link      http://github.com/zendframework/ZFLabsODMFixture for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
$basePath = getcwd();
ini_set('user_agent', 'ZFLabsODMFixture - Zend Framework 2 command line tool');
// load autoloader
if (file_exists("$basePath/vendor/autoload.php")) {
    require_once "$basePath/vendor/autoload.php";
} elseif (file_exists("$basePath/init_autoload.php")) {
    require_once "$basePath/init_autoload.php";
} elseif (\Phar::running()) {
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    echo 'Error: I cannot find the autoloader of the application.' . PHP_EOL;
    echo "Check if $basePath contains a valid ZF2 application." . PHP_EOL;
    exit(2);
}
if (file_exists("$basePath/config/application.config.php")) {
    $appConfig = require "$basePath/config/application.config.php";
    if (!isset($appConfig['modules']['ZFLabsODMFixture'])) {
        $appConfig['modules'][] = 'ZFLabsODMFixture';
        $appConfig['module_listener_options']['module_paths']['ZFLabsODMFixture'] = __DIR__;
    }
} else {
    $appConfig = array(
        'modules' => array(
            'ZFLabsODMFixture',
        ),
        'module_listener_options' => array(
            'config_glob_paths'    => array(
                'config/autoload/{,*.}{global,local}.php',
            ),
            'module_paths' => array(
                '.',
                './vendor',
            ),
        ),
    );
}
Zend\Mvc\Application::init($appConfig)->run();