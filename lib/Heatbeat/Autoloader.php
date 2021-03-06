<?php

/**
 * Copyright 2011 Osman Ungur
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); 
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at 
 *
 *          http://www.apache.org/licenses/LICENSE-2.0 
 *
 * Unless required by applicable law or agreed to in writing, software 
 * distributed under the License is distributed on an "AS IS" BASIS, 
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. 
 * See the License for the specific language governing permissions and 
 * limitations under the License. 
 *
 * @category    Heatbeat
 * @package     Heatbeat
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat;

/**
 * Heatbeat autoloader
 *
 * @category    Heatbeat
 * @package     Heatbeat
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
use Symfony\Component\ClassLoader\UniversalClassLoader;

class Autoloader {
    const FOLDER_ROOT = 'root';
    const FOLDER_LIBRARY = 'lib';
    const FOLDER_TEMPLATE = 'templates';
    const FOLDER_EXTERNAL = 'external';
    const FOLDER_RRD = 'rrd';
    const FOLDER_VENDOR = 'vendor';
    const FOLDER_LOG = 'logs';
    const FOLDER_GRAPH = 'graphs';

    /**
     *
     * @var Autoloader
     */
    private static $instance;

    /**
     *
     * @var array
     */
    private $paths;

    /**
     * Returns instance of autoloader
     *
     * @return Autoloader
     */
    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->setPaths();
        $this->register();
        $this->setErrorExceptionHandling();
    }

    /**
     * Sets necessary path for using all around Heatbeat
     */
    private function setPaths() {
        $rootPath = realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . '..');
        $this->paths = array(
            'root' => $rootPath,
            'lib' => $rootPath . DIRECTORY_SEPARATOR . self::FOLDER_LIBRARY,
            'templates' => $rootPath . DIRECTORY_SEPARATOR . self::FOLDER_TEMPLATE,
            'external' => $rootPath . DIRECTORY_SEPARATOR . self::FOLDER_EXTERNAL,
            'rrd' => $rootPath . DIRECTORY_SEPARATOR . self::FOLDER_RRD,
            'vendor' => $rootPath . DIRECTORY_SEPARATOR . self::FOLDER_VENDOR,
            'logs' => $rootPath . DIRECTORY_SEPARATOR . self::FOLDER_LOG,
            'graphs' => $rootPath . DIRECTORY_SEPARATOR . self::FOLDER_GRAPH
        );
    }

    /**
     * Registers Heatbeat and Symfony component autoloader
     */
    private function register() {
        require_once $this->getPath('vendor') . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';
        $loader = new UniversalClassLoader();
        $loader->registerNamespaces(array(
            'Symfony' => $this->getPath('vendor'),
            'Heatbeat' => $this->getPath('lib'),
                )
        );

        $loader->register();
    }

    /**
     * Sets error and exception handling
     */
    private function setErrorExceptionHandling() {
        error_reporting(E_ALL | E_STRICT);

        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                    if (0 == error_reporting()) {
                        return false;
                    }
                    throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
                });

        set_exception_handler(function ($e) {
                    $logger = new \Heatbeat\Log\Logger();
                    $logger->setMessage($e->getMessage())
                            ->log();
                    
                    fwrite(STDERR, 'An error occured, please check your log files!.');
                });
    }

    /**
     * Returns full path of given path identifier
     *
     * @param string $path
     * @return string
     */
    public function getPath($path) {
        return $this->paths[$path];
    }

}