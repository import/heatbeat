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

/**
 * DEF node of template
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser\Template\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class DefNode extends AbstractNode implements NodeInterface {
    const PREFIX = 'DEF';
    private $validCfs = array(
        'AVERAGE',
        'MIN',
        'MAX',
        'LAST'
    );

    public function getAsString() {
        return implode(self::SEPERATOR, array(
            self::PREFIX,
            $this->offsetGet('name') . self::EQUAL,
            $this->offsetGet('filename'),
            $this->offsetGet('datastore-name'),
            strtoupper($this->offsetGet('cf'))
        ));
    }

    public function validate() {
        if (!$this->offsetExists('name')) {
            throw new \Heatbeat\Exception\NodeValidationException('Def name is not defined');
        }
        if (!$this->offsetExists('filename')) {
            throw new \Heatbeat\Exception\NodeValidationException('Def filename is not defined');
        }
        if (!$this->offsetExists('datastore-name')) {
            throw new \Heatbeat\Exception\NodeValidationException('Def datastore-name is not defined');
        }
        if (!in_array(strtoupper($this->offsetGet('cf')), $this->validCfs)) {
            throw new NodeValidationException(sprintf("Def CF parameter must be one of these : %s", implode(', ', $this->validCfs)));
        };
        return true;
    }

}