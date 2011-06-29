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
 * @package     Heatbeat\CommandLine
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\CommandLine;

use Symfony\Component\Console\Application,
    Heatbeat\Commandline\Callback\Create,
    Heatbeat\Commandline\Callback\Update,
    Heatbeat\CommandLine\Callback\TestSource,
    Heatbeat\CommandLine\Callback\Graph;

/**
 * Application class for Heatbeat CLI interface.
 *
 * @category    Heatbeat
 * @package     Heatbeat\CommandLine
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Runner extends Application {

    public function __construct() {
        parent::__construct('Welcome to Heatbeat Graphing Tool', '1.0');

        $this->addCommands(array(
            new Create,
            new Update(),
            new TestSource(),
            new Graph()
        ));
    }

}
