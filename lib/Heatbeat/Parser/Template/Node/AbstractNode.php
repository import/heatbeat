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
 * @package     Heatbeat\Parser\Template\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Parser\Template\Node;

use Heatbeat\Exception\NodeValidationException;

/**
 * Abstract class for template nodes
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser\Template\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
abstract class AbstractNode extends \ArrayObject {

    private $validTypes = array(
        'GAUGE',
        'COUNTER',
        'DERIVE',
        'ABSOLUTE'
    );
    private $validCfs = array(
        'AVERAGE',
        'MIN',
        'MAX',
        'LAST'
    );
    private $validGraphTypes = array(
        'AREA',
        'LINE',
        'STACK'
    );

    /**
     * Checks is given parameter was defined
     * 
     * @param string $key
     * @return bool 
     * @throws NodeValidationException
     */
    protected function isDefined($key) {
        if (!$this->offsetExists($key)) {
            throw new NodeValidationException(sprintf('%s, %s argument is not defined.', $this->getClassName(), $key));
        }
        return true;
    }

    /**
     * Checks given parameter is a valid DS type
     * 
     * @param string $key
     * @return bool 
     * @throws NodeValidationException
     */
    protected function isValidType($key) {
        if (!in_array(strtoupper($this->offsetGet($key)), $this->validTypes)) {
            throw new NodeValidationException(sprintf("%s, %s argument must be one of these : %s.", $this->getClassName(), $key, implode(', ', $this->validTypes)));
        };
        return true;
    }

    /**
     * Checks given parameters is a valid graph element type
     * 
     * @param string $key
     * @return bool 
     * @throws NodeValidationException
     */
    protected function isValidGraphType($key) {
        if (!in_array(strtoupper($this->offsetGet($key)), $this->validGraphTypes)) {
            throw new NodeValidationException(sprintf("%s, %s argument must be one of these : %s.", $this->getClassName(), $key, implode(', ', $this->validGraphTypes)));
        };
        return true;
    }

    /**
     * Checks given parameter is a valid consolidation function
     * 
     * @param string $key
     * @return bool 
     * @throws NodeValidationException
     */
    protected function isValidCf($key) {
        if (!in_array(strtoupper($this->offsetGet($key)), $this->validCfs)) {
            throw new NodeValidationException(sprintf("%s, %s argument must be one of these : %s.", $this->getClassName(), $key, implode(', ', $this->validCfs)));
        };
        return true;
    }

    /**
     * Checks given parameter is an integer
     * 
     * @param string $key
     * @return bool 
     * @throws NodeValidationException
     */
    protected function isValidInt($key) {
        if (!is_int($this->offsetGet($key))) {
            throw new NodeValidationException(sprintf('%s, %s argument is not an integer.', $this->getClassName(), $key));
        }
        return true;
    }

    /**
     * Checks given parameter is a valid XFiles factor
     * 
     * @param string $key
     * @return bool 
     * @throws NodeValidationException
     */
    protected function isValidXff($key) {
        if ((($this->offsetGet($key)) < 0) OR (($this->offsetGet($key)) > 1)) {
            throw new NodeValidationException(sprintf("%s, %s parameter must be between of 0 and 1.", $this->getClassName(), $key));
        }
        return true;
    }

    /**
     * Checks given parameters is a valid hex value
     * 
     * @param string $key
     * @return bool 
     * @throws NodeValidationException
     */
    protected function isHex($key) {
        if (preg_match('/[^0-9a-fA-F]/', $this->offsetGet($key))) {
            throw new NodeValidationException(sprintf("%s, %s parameter must be a HEX value.", $this->getClassName(), $key));
        }
        return true;
    }

    /**
     * Checks given parameter is a valid source plugin name
     * 
     * @param string $key
     * @return bool 
     * @throws NodeValidationException
     */
    protected function isValidSource($key) {
        $namespaced = str_replace('_', "\\", $this->offsetGet($key));
        $class_name = '\\Heatbeat\\Source\\Plugin\\' . $namespaced;
        if (!class_exists($class_name)) {
            throw new NodeValidationException(sprintf("source-name %s is not valid.", $key));
        }
        return true;
    }

    private function getClassName() {
        $name = get_class($this);
        $len = strlen(__NAMESPACE__) + 1;
        return substr($name, $len);
    }

}