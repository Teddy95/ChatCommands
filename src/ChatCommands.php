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

namespace ChatCommands;

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
	 * @access public
	 *
	 * @uses			$commandCharacter
	 * @uses			$commands
	 */
	public function __construct ($character = '/', $commands = false)
	{

		if (isset($character) === true) {
			self::$commandCharacter = $character;
		}

		if (isset($commands) === true && is_array($commands) === true) {
			self::$commands = $commands;
		}

		return;
		
	}

	/**
	 * @param string	$character
	 *
	 * @access public
	 *
	 * @uses			$commandCharacter
	 *
	 * @return bool		Returns FALSE on failure
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
	 * @access public
	 *
	 * @uses			$commandCharacter
	 *
	 * @return string	Returns a string with the command character
	 */
	public static function get_character ()
	{

		return self::$commandCharacter;
		
	}

	/**
	 * @param array		$commands
	 *
	 * @access public
	 *
	 * @uses			$commands
	 *
	 * @return bool		Returns FALSE on failure
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
	 * @access public
	 *
	 * @uses			$commands
	 *
	 * @return array	Returns an array with the commands on success or FALSE on failure
	 */
	public static function get_commands ()
	{

		return self::$commands;
		
	}

	/**
	 * @param string	$command
	 * @param string	$msg
	 *
	 * @access public
	 *
	 * @uses			$commandCharacter
	 *
	 * @return bool		Returns TRUE on success or FALSE on failure
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
	 * @param string	$text_split
	 *
	 * @access public
	 *
	 * @uses			$commandCharacter
	 * @uses			$commands
	 *
	 * @return array	Returns an array with the active command on success or FALSE on failure
	 */
	public static function get ($msg, $text_split = false)
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

				if (isset($text_split) === true && is_null($text_split) == false && $text_split !== false && strpos($msg[1], $text_split) == true) {
					$get['text'] = explode($text_split, $msg[1]);

					for ($i = 0; $i < count($get['text']); $i++) {
						$get['text'][$i] = trim($get['text'][$i]);
					}
				} else {
					$get['text'] = $msg[1];
				}
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

	/**
	 * @param string	$command
	 *
	 * @access public
	 *
	 * @uses			$commands
	 *
	 * @return bool		Returns FALSE on failure
	 */
	public static function add_command ($command)
	{

		if (isset($command) === true && in_array($command, self::$commands) == false) {
			if (self::$commands === false) {
				self::$commands = array();
			}

			self::$commands[] = $command;
		} else {
			return false;
		}

		return;
		
	}

	/**
	 * @param array		$commands
	 *
	 * @access public
	 *
	 * @uses			$commands
	 *
	 * @return bool		Returns FALSE on failure
	 */
	public static function add_commands ($commands)
	{

		if (isset($commands) === true) {
			if (self::$commands === false) {
				self::$commands = array();
			}

			foreach ($commands as $command) {
				if (in_array($command, self::$commands) == false) {
					self::$commands[] = $command;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}

		return;
		
	}

	/**
	 * @param string	$command
	 *
	 * @access public
	 *
	 * @uses			$commands
	 *
	 * @return bool		Returns FALSE on failure
	 */
	public static function remove_command ($command)
	{

		if (isset($command) === true && is_array(self::$commands) == true && in_array($command, self::$commands) == true) {
			unset(self::$commands[array_search($command, self::$commands)]);
			$i = 0;
			$newCommands = array();

			foreach (self::$commands as $command) {
				$newCommands[] = $command;
			}

			self::$commands = $newCommands;
		} else {
			return false;
		}

		return;
		
	}

	/**
	 * @param array		$commands
	 *
	 * @access public
	 *
	 * @uses			$commands
	 *
	 * @return bool		Returns FALSE on failure
	 */
	public static function remove_commands ($commands)
	{

		if (isset($commands) === true && is_array(self::$commands) == true) {
			foreach ($commands as $command) {
				if (in_array($command, self::$commands) == true) {
					unset(self::$commands[array_search($command, self::$commands)]);
				} else {
					return false;
				}
			}

			$i = 0;
			$newCommands = array();

			foreach (self::$commands as $command) {
				$newCommands[] = $command;
			}

			self::$commands = $newCommands;
		} else {
			return false;
		}

		return;
		
	}
	
}
?>
