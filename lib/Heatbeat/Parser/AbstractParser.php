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
 * @package     Heatbeat\Parser
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Parser;

/**
 * Class for parsing/passing YAML templates.
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
use Symfony\Component\Yaml\Yaml,
    Heatbeat\Exception\HeatbeatException;

abstract class AbstractParser {

    /**
     *
     * @var string
     */
    private $filename;

    /**
     *
     * @var string
     */
    protected $filepath;
    /**
     *
     * @var ArrayIterator
     */
    protected $values;

    CONST YAML_EXT = '.yml';

    /**
     * Returns filename of yaml file
     *
     * @return string
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * Sets filename of yaml
     *
     * @param string $filename
     */
    public function setFilename($filename) {
        $this->filename = $filename;
    }

    /**
     * Sets path of yaml file
     *
     * @param string $filepath
     */
    public function setFilepath($filepath) {
        $this->filepath = $filepath;
    }

    /**
     * Returns path of yaml file
     *
     * @return string
     */
    public function getFilepath() {
        return $this->filepath;
    }

    /**
     * Returns full path of yaml file including file extension
     *
     * @return string
     */
    public function getFullPath() {
        return $this->getFilepath() . DIRECTORY_SEPARATOR . $this->getFilename() . self::YAML_EXT;
    }

    /**
     * Parses and sets values of yaml file.
     */
    public function parse() {
        $this->setValues(Yaml::parse($this->getFullPath()));
    }

    /**
     * Returns parsed yaml values
     *
     * @return ArrayIterator
     */
    public function getValues() {
        return $this->values;
    }

    /**
     * Sets parsed yaml values
     *
     * @param type $values
     */
    public function setValues($values) {
        if ((!is_array($values)) OR (count($values) == 0)) {
            throw new HeatbeatException(sprintf('No values parsed in %s', $this->getFullPath()));
        }
        $this->values = new \ArrayIterator($values);
    }

}

?>
