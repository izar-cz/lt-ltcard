<?php
/**
 * <card> Syntax Component of the LT Card plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Anika Henke <anika@selfthinker.org>
 * @author     Izar <izar.cz@gmail.com>
 */

if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_ltcard_base extends DokuWiki_Syntax_Plugin {
	protected $entry_pattern  = null;
	protected $exit_pattern   = null;
	protected $content_label  = '';
	protected $content_label_en = '';

	function getType() { return 'formatting';}
	function getAllowedTypes() { return array('container', 'formatting', 'substition', 'protected', 'disabled', 'paragraphs'); }
	function getPType() { return 'stack';}
	function getSort() { return 196; }

	/**
	 * Connect pattern to lexer
	 */
	function connectTo($mode) {
		$this->Lexer->addEntryPattern($this->entry_pattern,$mode,'plugin_ltcard_'.$this->getPluginComponent());
	}

	function postConnect() {
		$this->Lexer->addExitPattern($this->exit_pattern, 'plugin_ltcard_'.$this->getPluginComponent());
	}

	/**
	 * Handle the match
	 */
	function handle($match, $state, $pos, Doku_Handler $handler){
		global $conf;
		switch ($state) {
			case DOKU_LEXER_ENTER:
				$this->blockState = null;
				$data = strtolower(trim(substr($match,strpos($match,' '),-1)," \t\n"));
				return array($state, $data);

			case DOKU_LEXER_UNMATCHED:
				$handler->_addCall('cdata', array($match), $pos);
				break;

			case DOKU_LEXER_EXIT:
				return array($state, $this->blockState);
		}
		return false;
	}

	/**
	 * Create output
	 */
	function render($mode, Doku_Renderer $renderer, $indata) {
		if (empty($indata)) return false;
		list($state, $data) = $indata;

		if($mode == 'xhtml'){
			/** @var Doku_Renderer_xhtml $renderer */
			switch ($state) {
				case DOKU_LEXER_ENTER:
					$cls = 'ltcard_panel ltcard_'.$this->getPluginComponent();
					if ($data) {
						$cls .= ' ltcard__'.$data;
					}
					$label = $this->_getLabel();
					if ($label) {
						$label = '<span class="ltcard_label">'.$label.'</span>'; // TODO escape
					}
					$renderer->doc .= '<div class="'.$cls.'">'.$label;
					break;

				case DOKU_LEXER_EXIT:
					$renderer->doc .= $this->beforeClose($data);
					$renderer->doc .= '</div>';
					break;
			}
			return true;
		}
		return false;
	}
	function _getLabel() {
		if ($this->content_label_en) {
			$helper = plugin_load('helper', 'translation');
			global $ID;
			if ($helper) {
				$lang = $helper->getLangPart($ID);
				if ($lang === 'en') {
					return $this->content_label_en;
				}
			}
		}
		return $this->content_label;
	}
	function beforeClose($data) {
		return '';
	}
}


class syntax_plugin_ltcard_card extends syntax_plugin_ltcard_base {
	protected $entry_pattern  = '<card\b.*?'.'>(?=.*?</card>)'; // split into two strings not to confuse syntax highlighters
	protected $exit_pattern   = '</card>';
	protected $content_label  = '';

	function postConnect() {
		parent::postConnect();
		$this->Lexer->addPattern('<name>[^<]*</name>', 'plugin_ltcard_'.$this->getPluginComponent());
	}

	/**
	 * Handle the match
	 */
	function handle($match, $state, $pos, Doku_Handler $handler){
		global $conf;
		if ($state === DOKU_LEXER_MATCHED) {
			$this->blockState = true; // note that the name is explicitely given
			$start  = strpos($match,'>') + 1;
			$length = strrpos($match,'<') - $start;
			$name = trim(substr($match, $start, $length)); // strip <name></name> tags
			return array($state, $name);
		}
		return parent::handle($match, $state, $pos, $handler);
	}

	/**
	 * Create output
	 */
	function render($mode, Doku_Renderer $renderer, $indata) {
		if (empty($indata)) return false;
		list($state, $data) = $indata;

		if ($mode === 'xhtml' && $state === DOKU_LEXER_MATCHED) {
			$renderer->doc .= $this->renderName($data);
			return true;
		}
		return parent::render($mode, $renderer, $indata);
	}
	
	function beforeClose($data) {
		global $ID;
		if ($data) { // => $this->blockState === true; there is an explicit <name>..</name>
			return '';
		}
		return $this->renderName(p_get_first_heading($ID));
	}

	private function renderName($name) {
		return '<div class="ltcard_panel ltcard_name">' . $name . '</div>';
	}
}
