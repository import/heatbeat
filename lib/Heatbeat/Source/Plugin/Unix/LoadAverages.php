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
 * @package     Heatbeat\Source\Plugin\Unix
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Source\Plugin\Unix;

use Heatbeat\Source\AbstractSource,
    Heatbeat\Source\SourceOutput,
    Heatbeat\Exception\SourceException;

/**
 * Class for fetching Unix system load values
 *
 * @category    Heatbeat
 * @package     Heatbeat\Source\Plugin\Unix
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class LoadAverages extends AbstractSource {

    public function perform() {
        if (function_exists('sys_getloadavg')) {
            list ($load1min, $load5min, $load15min) = sys_getloadavg();
        } else {
            throw new SourceException('Unable to fetch system load averages');
        }
        $output = new SourceOutput();
        $output->setValue('1min', $load1min);
        $output->setValue('5min', $load5min);
        $output->setValue('15min', $load15min);
        $this->setOutput($output);
    }

}