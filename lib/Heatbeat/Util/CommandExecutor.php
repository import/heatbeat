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
 * @package     Heatbeat\Util
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Util;

/**
 * Class for executing shell commands.
 *
 * @category    Heatbeat
 * @package     Heatbeat\Util
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class CommandExecutor {

    private $commandObject;
    private $commandString;
    private $isSuccess;
    private $errorString;
    private $result;

    public function getCommandObject() {
        return $this->commandObject;
    }

    public function setCommandObject($commandObject) {
        $this->commandObject = $commandObject;
    }

    public function getCommandString() {
        return $this->commandString;
    }

    public function setCommandString($commandString) {
        $this->commandString = $commandString;
    }

    public function getIsSuccess() {
        return $this->isSuccess;
    }

    public function setIsSuccess($isSuccess) {
        $this->isSuccess = $isSuccess;
    }

    public function getErrorString() {
        return $this->errorString;
    }

    public function setErrorString($errorString) {
        $this->errorString = $errorString;
    }

    public function getResult() {
        return $this->result;
    }

    public function setResult($result) {
        $this->result = $result;
    }

    /**
     * Prepares command for execution
     *
     * @return string
     */
    public function prepare() {
        $result = new \ArrayObject();
        $result->append($this->getCommandObject()->getCommand());
        $result->append($this->getCommandObject()->getSubCommand());
        foreach ($this->getCommand()->getOptions() as $key => $option) {
            if ($option === false) {
                continue;
            }
            $result->append(self::LONG_OPTION . $key);
            if ($option !== true) {
                $result->append(\escapeshellarg($option));
            }
        }
        foreach ($this->getCommandObject()->getArguments() as $argument) {
            $result->append(\escapeshellarg($argument));
        }
        $this->setCommandString(\implode(\chr(32), \iterator_to_array($result)));
    }

    public function execute() {
        $output = false;
        $return_var = false;
        \exec($this->getCommandString(), $output, $return_var);
        if ($return_var > 0) {
            $this->setIsSuccess(false);
            $this->setErrorString(implode(PHP_EOL, $output));
        }
        $this->setIsSuccess(true);
        $this->setResult(implode(PHP_EOL, $output));
    }

}