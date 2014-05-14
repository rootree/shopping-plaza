<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Loads and displays Kohana view files. Can also handle output of some binary
 * files, such as image, Javascript, and CSS files.
 *
 * $Id: ViewMod.php 4072 2009-03-13 17:20:38Z jheathco $
 *
 * @package    Core
 * @author     Ivan Chura
 * @copyright  (c) 2010-2013 Ivan Chura
 * @license    http://shopping-plaza.ru/license.html
 */
class ViewMod_Core extends View_Core {

    /**
     * Attempts to load a view and pre-load view data.
     *
     *
     * @param   string  type of file: html, css, js, etc.
     *
     * @return \ViewMod_Core
     */
	public function __construct($name = null) {
        
        $session = new Session();
        $firm = $session->get("firm");
        parent::__construct($name);

	}

} // End View