<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * utf8::trim
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://kohanaphp.com/license
 */
function _trim($str, $charlist = NULL)
{
	if ($charlist === NULL)
		return trim($str);

	return utf8::ltrim(utf8::rtrim($str, $charlist), $charlist);
}