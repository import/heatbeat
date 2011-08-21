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
 * @package     Heatbeat\Definition
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Definition\Template;

use Heatbeat\Definition\AbstractDefinition;

/**
 * Iterator for RRA definition
 *
 * @category    Heatbeat
 * @package     Heatbeat\Definition
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class RraDefinition extends AbstractDefinition {

    const CF = 'cf';
    
    public function current() {
        $this->mapConsolidationFunction(parent::current());
        $node = new \Heatbeat\Parser\Template\Node\RraNode(parent::current());
        $node->validate();
        return $node;
    }
    
    private function mapConsolidationFunction($array) {
        if (array_key_exists(self::CF, $array) AND is_array($array[self::CF])) {
            foreach ($array[self::CF] as $value) {
                parent::push(array_merge($array, array(self::CF => $value)));
            }
            parent::next();
        }
    }

}