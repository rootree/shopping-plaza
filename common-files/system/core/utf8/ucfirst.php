<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * utf8::ucfirst
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://kohanaphp.com/license
 */
function _ucfirst($str)
{
	if (utf8::is_ascii($str))
		return ucfirst($str);

	preg_match('/^(.?)(.*)$/us', $str, $matches);
	return utf8::strtoupper($matches[1]).$matches[2];
}