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
 * Item node of template
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser\Template\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class ItemNode extends AbstractNode implements NodeInterface {

    private $validTypes = array(
        'AREA',
        'LINE'
    );

    public function getAsString() {
        return implode(self::SEPERATOR, array(
            $this->offsetGet('type'),
            $this->offsetGet('definition-name') . $this->offsetGet('color'),
            $this->offsetGet('legend')
        ));
    }

    public function validate() {
        if (!in_array(strtoupper($this->offsetGet('type')), $this->validTypes)) {
            throw new NodeValidationException(sprintf("Type parameter in template must be one of these : %s", implode(', ', $this->validTypes)));
        };
        if (!$this->offsetExists('definition-name')) {
            throw new \Heatbeat\Exception\NodeValidationException('Item definition-name is not defined');
        }
        if (!$this->offsetExists('color')) {
            throw new \Heatbeat\Exception\NodeValidationException('Item color is not defined');
        }        
        if (!$this->offsetExists('legend')) {
            throw new \Heatbeat\Exception\NodeValidationException('Item legend is not defined');
        }
    }

}