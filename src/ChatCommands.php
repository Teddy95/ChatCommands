<?php
/**
 * @author	Andre Sieverding https://github.com/Teddy95
 * @license	MIT http://opensource.org/licenses/MIT
 * 
 * The MIT License (MIT)
 * 
 * Copyright (c) 2014 Andre Sieverding
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Teddy95\ChatCommands;

/**
 * Command class
 */
class cmd
{

	/**
	 * Parameters for functions.
	 */
	private static $commandCharacter = '/';
	private static $commands = false;

	/**
	 * @param string	$character
	 *
	 * @return array	Returns FALSE on failure
	 */
	public static function set_character ($character = '/')
	{

		if (isset($character) === true) {
			self::$commandCharacter = $character;

			return;
		} else {
			return false;
		}
		
	}

	/**
	 * @param array		$commands
	 *
	 * @return array	Returns FALSE on failure
	 */
	public static function set_commands ($commands)
	{

		if (isset($commands) === true && is_array($commands) === true) {
			self::$commands = $commands;

			return;
		} else {
			return false;
		}
		
	}

	/**
	 * @param string	$command
	 * @param string	$msg
	 *
	 * @return array	Returns TRUE on success or FALSE on failure
	 */
	public static function check ($command, $msg)
	{

		if (isset($msg) === true && isset($command) === true && substr($msg, 0, strlen(self::$commandCharacter)) == self::$commandCharacter) {
			$msg = substr($msg, strlen(self::$commandCharacter), strlen($msg)-strlen(self::$commandCharacter));

			if (substr($msg, 0, strlen($command)) == $command) {
				$check = true;
			} else {
				$check = false;
			}

			return $check;
		} else {
			return false;
		}
		
	}

	/**
	 * @param string	$msg
	 *
	 * @return array	Returns an array with the active command on success or FALSE on failure
	 */
	public static function get ($msg)
	{

		if (isset($msg) === true && substr($msg, 0, strlen(self::$commandCharacter)) == self::$commandCharacter && self::$commands !== false) {
			$msg = substr($msg, strlen(self::$commandCharacter), strlen($msg)-strlen(self::$commandCharacter));
			$get = array();

			foreach (self::$commands as $command) {
				if (substr($msg, 0, strlen($command)) == $command) {
					$get['command'] = $command;
				}
			}

			if (isset($get['command']) === false) {
				return false;
			}

			if (strpos($msg, ' ') == true) {
				$msg = explode(' ', $msg, 2);
				$get['text'] = $msg[1];
			} else {
				$msg .= ' #';
				$msg = explode(' ', $msg, 2);
				$get['text'] = false;
			}

			if (strpos($msg[0], '*') == true) {
				$msg = explode('*', $msg[0], 2);
				$get['duration'] = intval($msg[1]);
			} else {
				$get['duration'] = false;
			}

			return $get;
		} else {
			return false;
		}
		
	}
	
}
?>
