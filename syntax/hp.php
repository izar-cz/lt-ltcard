<?php
/**
 * <hp> element for the LT Card plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Izar <izar.cz@gmail.com>
 */

require_once(dirname(__FILE__).'/card.php');

class syntax_plugin_ltcard_hp extends syntax_plugin_ltcard_base {

	protected $entry_pattern   = '<hp\b.*?>(?=.*?</hp>)';
	protected $exit_pattern    = '</hp>';
	protected $content_label   = 'Počet životů';
	protected $content_label_en = 'Hitpoints';
}

