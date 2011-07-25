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
 * @package     Heatbeat\Parser\Config\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Parser\Config\Node;

use Heatbeat\Exception\NodeValidationException,
    Heatbeat\Parser\Validator;

/**
 * Abstract class for config nodes
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser\Config\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
abstract class AbstractNode extends \ArrayObject {

    private $validator;

    public function __construct($input) {
        parent::__construct($input);
        $this->validator = new Validator();
    }

    /**
     * Returns validator object
     *
     * @return Validator
     */
    public function getValidator() {
        return $this->validator;
    }

    /**
     * Checks is given parameter was defined
     *
     * @param string $key
     * @return bool
     * @throws NodeValidationException
     */
    protected function isDefined($key) {
        if (!($this->offsetExists($key) AND $this->getValidator()->isNotBlank($this->offsetGet($key)))) {
            throw new NodeValidationException(sprintf('%s, %s argument is not defined.', $this->getClassName(), $key));
        }
        return true;
    }

    /**
     * Returns class name without namespace
     * @return string
     */
    private function getClassName() {
        $name = get_class($this);
        $len = strlen(__NAMESPACE__) + 1;
        return substr($name, $len);
    }

}