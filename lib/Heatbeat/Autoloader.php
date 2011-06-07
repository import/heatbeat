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
use \Symfony\Component\ClassLoader\UniversalClassLoader;

class Autoloader {
    const FOLDER_ROOT = 'root';
    const FOLDER_LIBRARY = 'lib';
    const FOLDER_TEMPLATE = 'templates';
    const FOLDER_EXTERNAL = 'external';
    const FOLDER_RRD = 'rrd';
    const FOLDER_VENDOR = 'vendor';

    private static $instance;
    private $loader;
    private $paths;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->setPaths();
        $this->register();
    }

    private function setPaths() {
        $rootPath = realpath(dirname(__DIR__) . \DIRECTORY_SEPARATOR . '..');
        $this->paths = array(
            'root' => $rootPath,
            'lib' => $rootPath . \DIRECTORY_SEPARATOR . self::FOLDER_LIBRARY,
            'templates' => $rootPath . \DIRECTORY_SEPARATOR . self::FOLDER_TEMPLATE,
            'external' => $rootPath . \DIRECTORY_SEPARATOR . self::FOLDER_EXTERNAL,
            'rrd' => $rootPath . \DIRECTORY_SEPARATOR . self::FOLDER_RRD,
            'vendor' => $rootPath . \DIRECTORY_SEPARATOR . self::FOLDER_VENDOR
        );
    }

    private function register() {
        require_once $this->getPath('vendor') . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';
        $loader = new UniversalClassLoader();
        $loader->registerNamespaces(array(
            'Symfony' => $this->getPath('vendor'),
            'Heatbeat' => $this->getPath('lib'),
                )
        );

        $loader->register();
        $this->setLoader($loader);
    }

    private function setLoader($loader) {
        $this->loader = $loader;
    }

    public function getPath($path) {
        return $this->paths[$path];
    }

}

?>
