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
 * @package     Heatbeat\Source\Plugin\System
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Source\Plugin\System;

use Heatbeat\Source\AbstractSource,
    Heatbeat\Source\SourceInterface,
    Heatbeat\Source\AbstractInputOutput,
    Heatbeat\Source\SourceOutput,
    Heatbeat\Exception\SourceException,
    Heatbeat\Util\CommandExecutor;

/**
 * Class for fetching currently logged user count
 *
 * @category    Heatbeat
 * @package     Heatbeat\Source\Plugin\System
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class LoggedUsers extends AbstractSource implements SourceInterface {

    public function perform() {
        $command = 'who | grep -c :';
        $object = new CommandExecutor();
        $object->setCommandString($command);
        try {
            $result = $object->execute();
        } catch (\Exception $exc) {
            throw new SourceException($exc->getMessage());
        }
        $output = new SourceOutput();
        $output->setValue('users', (int) $result->getOutput());
        $this->setOutput($output);
        return true;
    }

}