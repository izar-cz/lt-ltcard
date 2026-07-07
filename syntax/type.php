<?php
/**
 * <type> element for the LT Card plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Izar <izar.cz@gmail.com>
 */

require_once(dirname(__FILE__).'/card.php');

class syntax_plugin_ltcard_type extends syntax_plugin_ltcard_base {

	protected $entry_pattern   = '<type\b.*?>(?=.*?</type>)';
	protected $exit_pattern    = '</type>';
	protected $content_label   = 'Typ';
	protected $content_label_en = 'Type';
}

