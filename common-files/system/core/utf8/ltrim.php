<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * utf8::ltrim
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://kohanaphp.com/license
 */
function _ltrim($str, $charlist = NULL)
{
	if ($charlist === NULL)
		return ltrim($str);

	if (utf8::is_ascii($charlist))
		return ltrim($str, $charlist);

	$charlist = preg_replace('#[-\[\]:\\\\^/]#', '\\\\$0', $charlist);

	return preg_replace('/^['.$charlist.']+/u', '', $str);
}