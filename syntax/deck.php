<?php
/**
 * <deck> element for the LT Card plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Izar <izar.cz@gmail.com>
 */

require_once(dirname(__FILE__).'/card.php');

class syntax_plugin_ltcard_deck extends syntax_plugin_ltcard_base {

	protected $entry_pattern   = '<deck\b.*?>(?=.*?</deck>)';
	protected $exit_pattern    = '</deck>';
	protected $content_label   = 'Balíček';
	protected $content_label_en = 'Deck';
}

