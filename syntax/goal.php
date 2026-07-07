<?php
/**
 * <goal> element for the LT Card plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Izar <izar.cz@gmail.com>
 */

require_once(dirname(__FILE__).'/card.php');

class syntax_plugin_ltcard_goal extends syntax_plugin_ltcard_base {

	protected $entry_pattern   = '<goal\b.*?>(?=.*?</goal>)';
	protected $exit_pattern    = '</goal>';
	protected $content_label   = 'Cíl';
	protected $content_label_en = 'Goal';
}

