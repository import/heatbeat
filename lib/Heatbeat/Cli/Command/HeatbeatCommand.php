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
 * @package     Heatbeat\Cli\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Cli\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Heatbeat\Autoloader,
    Heatbeat\Executor\Executor,
    Heatbeat\Parser\Template\TemplateParser as Template,
    Heatbeat\Parser\Config\ConfigParser as Config,
    Heatbeat\Command\AbstractCommand,
    Heatbeat\Log\Logger as Logger,
    Heatbeat\Exception\SourceException;

/**
 * Shared methods for commands
 *
 * @category    Heatbeat
 * @package     Heatbeat\Cli\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class HeatbeatCommand extends Command {

    private $processStartTime;

    /**
     * Initializes template and command object
     *
     */
    protected function initialize(InputInterface $input, OutputInterface $output) {
        $this->setProcessStartTime();
    }

    public function getConfig() {
        $configObject = new Config();
        $configObject->setFilepath(Autoloader::getInstance()->getRootPath());
        $configObject->setFilename(Config::FILENAME);
        $configObject->parse();
        return $configObject;
    }

    public function getTemplate($name) {
        $templateObject = new Template();
        $templateObject->setFilepath(Autoloader::getInstance()->getFolderPath('templates'));
        $templateObject->setFilename($name);
        $templateObject->parse();
        return $templateObject;
    }

    /**
     * Sets actual time as float
     */
    private function setProcessStartTime() {
        $this->processStartTime = microtime(true);
    }

    /**
     * Returns command execution time
     *
     * @return float
     */
    private function getExecutionTime() {
        return microtime(true) - $this->processStartTime;
    }

    /**
     * Executes given command object and sends output to console
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param AbstractCommand $commandObject
     * @param string $successMessage
     */
    public function executeCommand(InputInterface $input, OutputInterface $output, AbstractCommand $commandObject, $successMessage) {
        $commandString = $commandObject->prepare()
                ->getCommandString();

        if ($input->getOption('verbose')) {
            $output->writeln($commandString);
        }

        $executor = new Executor();
        $executor->setCommand($commandString)
                ->run();

        if ($executor->isSuccess()) {
            $this->renderSuccess($successMessage, $output);
        } else {
            $this->renderError($executor->getErrorOutput(), $output);
        }
    }

    /**
     * Returns instance of given plugin name
     *
     * @param string $source
     * @return AbstractSource
     */
    public function getSourceInstance($source) {
        $namespaced = str_replace('_', "\\", $source);
        $class_name = '\\Heatbeat\\Source\\' . $namespaced;
        if (!class_exists($class_name)) {
            throw new SourceException(sprintf('Unable to find source %s', $source));
        }
        return new $class_name;
    }

    /**
     * Returns execution time and memory usage of script
     *
     * @return string
     */
    public function getSummary() {
        return sprintf(
                        '<comment>Time: %4.2f sec, Memory: %4.2fMb</comment>', number_format($this->getExecutionTime(), 2), memory_get_peak_usage(TRUE) / 1048576
        );
    }

    /**
     * Renders error message of given exception to console
     * 
     * @param \Exception $e
     * @param OutputInterface $output 
     */
    protected function renderError($message, OutputInterface $output) {
        $output->writeln(sprintf("<error>Error\t</error> %s", $message));
    }

    /**
     * Renders given success message to console
     *
     * @param string $message
     * @param OutputInterface $output
     */
    protected function renderSuccess($message, OutputInterface $output) {
        $output->writeln(sprintf("<info>Success\t</info> %s", $message));
    }

    /**
     * Logs message of exception to rotating file 
     *
     * @param Exception $e 
     * @return bool
     */
    protected function logError($e) {
        $logger = new Logger();
        return $logger->setMessage($e->getMessage())
                        ->log();
    }

}