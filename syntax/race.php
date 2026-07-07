<?php
/**
 * <race> element for the LT Card plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Izar <izar.cz@gmail.com>
 */

require_once(dirname(__FILE__).'/card.php');

class syntax_plugin_ltcard_race extends syntax_plugin_ltcard_base {

	protected $entry_pattern   = '<race\b.*?>(?=.*?</race>)';
	protected $exit_pattern    = '</race>';
	protected $content_label   = 'Rasa';
	protected $content_label_en = 'Race';
}

