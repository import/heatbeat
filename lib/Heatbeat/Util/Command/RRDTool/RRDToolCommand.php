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
 * @package     Heatbeat\Util\Command\RRDTool
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Util\Command\RRDTool;

use Heatbeat\Util\AbstractCommand as Command,
    Heatbeat\Autoloader as Autoloader;

/**
 * Common methods for rrdtool commands
 *
 * @category    Heatbeat
 * @package     Heatbeat\Util\Command\RRDTool
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
abstract class RRDToolCommand extends Command {
    const SEPERATOR = ':';

    /**
     * Executable / command name of rrdtool
     */
    const EXECUTABLE = 'rrdtool';

    /**
     * Extension of rrd files
     */
    const RRD_EXT = '.rrd';
    
    /**
     * Extension of png files
     */
    const PNG_EXT = '.png';    

    public function __construct() {
        $this->setCommand(self::EXECUTABLE);
        $this->setSubCommand($this->subCommand);
        $this->init();
    }

    /**
     * Sets filename of rrd file based on RRD folder
     * 
     * @param string $filename 
     */
    public function setFilename($filename) {
        $this->addArgument(self::getRRDFilePath($filename));
    }

    /**
     * Method for initializing command, works when constructing object
     */
    public function init() {
        
    }

    public static function getRRDFilePath($filename) {
        return Autoloader::getInstance()->getPath(Autoloader::FOLDER_RRD) . \DIRECTORY_SEPARATOR . $filename . self::RRD_EXT;
    }
    
    public static function getGraphFilePath($filename) {
        return Autoloader::getInstance()->getPath(Autoloader::FOLDER_GRAPH) . \DIRECTORY_SEPARATOR . $filename . self::PNG_EXT;
    }    
    
    
}