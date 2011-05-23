<?php

namespace Rosso\Command;

/**
 * Shared
 *
 * Common methods for commands
 *
 * @package    Rosso
 * @subpackage Rosso\Command
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/rosso
 */
use \Rosso\Command;

abstract class Shared extends Command {
	const SEPERATOR = ':';
	const EXECUTABLE = 'rrdtool';

	public function __construct() {
		$this->setCommand(self::EXECUTABLE);
		$this->setSubCommand(self::SUBCOMMAND);
	}

	public function setFilename($filename) {
		$this->addArgument($filename);
	}

}