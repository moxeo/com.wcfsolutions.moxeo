<?php
// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/ViewableThemeModuleType.class.php');

/**
 * Represents the search theme module type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.theme.module.type
 * @category	Infinite Site
 */
class SearchThemeModuleType extends ViewableThemeModuleType {
	/**
	 * @see	ViewableThemeModuleType::$pageElement
	 */
	public $pageElement = 'search';
	
	/**
	 * @see	ViewableThemeModuleType::$pageElementDir
	 */
	public $pageElementDir = WSIS_DIR;
	
	// form methods
	/**
	 * @see ThemeModuleType::readFormParameters()
	 */
	public function readFormParameters() {
		$this->formData['itemsPerPage'] = 10;
		if (isset($_POST['itemsPerPage'])) $this->formData['itemsPerPage'] = intval($_POST['itemsPerPage']);
	}
	
	/**
	 * @see ThemeModuleType::assignVariables()
	 */
	public function assignVariables() {
		WCF::getTPL()->assign(array(
			'itemsPerPage' => (isset($this->formData['itemsPerPage']) ? $this->formData['itemsPerPage'] : 10)
		));
	}
	
	/**
	 * @see ThemeModuleType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'searchThemeModuleType';
	}
}
?>