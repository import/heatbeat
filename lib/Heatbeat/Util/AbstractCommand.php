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
 * Abstract class for implementing shell commands.
 *
 * @category    Heatbeat
 * @package     Heatbeat\Util
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
abstract class AbstractCommand {

    /**
     * Command name
     * 
     * @var string 
     */
    private $command;
    
    /**
     * Subcommand name of command
     * 
     * @var string 
     */
    private $subCommand;
    
    /**
     * Arguments of command
     * 
     * @var array 
     */
    private $arguments = array();
    
    /**
     * Options of command
     * 
     * @var array 
     */
    private $options = array();

    /**
     * Sets base command name
     * 
     * @param string $command
     */
    public function setCommand($command) {
        $this->command = $command;
    }

    /**
     * Sets subcommand of command
     * 
     * @param string $subCommand
     */
    public function setSubCommand($subCommand) {
        $this->subCommand = $subCommand;
    }

    /**
     * Sets and overrides given arguments as command args
     * 
     * @param array $arguments
     */
    public function setArguments(array $arguments) {
        $this->arguments = $arguments;
    }

    /**
     * Pushes an argument to command args
     * 
     * @param string $value
     */
    public function addArgument($value) {
        $this->arguments[] = $value;
    }

    /**
     * Sets and overrides command options
     * 
     * @param array $options
     */
    public function setOptions(array $options) {
        $this->options = $options;
    }

    /**
     * Pushes an option to command options
     * 
     * @param string $name
     * @param bool|string $value
     */
    public function setOption($name, $value = true) {
        $this->options[$name] = $value;
    }

    /**
     * Returns base command name
     * 
     * @return string
     */
    public function getCommand() {
        return $this->command;
    }

    /**
     * Returns subcommand of command
     * 
     * @return string
     */
    public function getSubCommand() {
        return $this->subCommand;
    }

    /**
     * Returns all command arguments as array
     * 
     * @return array
     */
    public function getArguments() {
        return $this->arguments;
    }

    /**
     * Returns all options as array
     * 
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }

}

?>
