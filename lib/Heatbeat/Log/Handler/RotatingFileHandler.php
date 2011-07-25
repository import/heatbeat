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
 * @package     Heatbeat\Log\Handler
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Log\Handler;

use Heatbeat\Autoloader;

/**
 * Handler for daily rotating file
 *
 * @category    Heatbeat
 * @package     Heatbeat\Log\Handler
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class RotatingFileHandler extends AbstractLogHandler implements LogHandlerInterface {

    protected function handle() {
        return file_put_contents($this->getFilename(), $this->getMessage(), FILE_APPEND | LOCK_EX);
    }

    protected function isHandling() {
        return \is_writable($this->getLogFolder() . \DIRECTORY_SEPARATOR);
    }

    protected function format() {
        return $this->setMessage(sprintf("%s %s \r\n", time(), (string) $this->getMessage()));
    }

    protected function getFilename() {
        return $this->getLogFolder() . \DIRECTORY_SEPARATOR . strftime('%Y-%m-%d') . '.log';
    }

    protected function getLogFolder() {
        return Autoloader::getInstance()->getPath(Autoloader::FOLDER_LOG);
    }

}