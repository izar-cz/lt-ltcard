<?php
/**
 * <ability> element for the LT Card plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Izar <izar.cz@gmail.com>
 */

require_once(dirname(__FILE__).'/card.php');

class syntax_plugin_ltcard_ability extends syntax_plugin_ltcard_base {

	protected $entry_pattern   = '<ability\b.*?>(?=.*?</ability>)';
	protected $exit_pattern    = '</ability>';
	protected $content_label   = 'Schopnost';
	protected $content_label_en = 'Ability';
}

