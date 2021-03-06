<?php
// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/ViewableThemeModuleType.class.php');

/**
 * Represents the search theme module type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.theme.module.type
 * @category	Moxeo Open Source CMS
 */
class SearchThemeModuleType extends ViewableThemeModuleType {
	/**
	 * @see	ViewableThemeModuleType::getPageElement()
	 */
	public function getPageElement() {
		return 'search';
	}

	/**
	 * @see	ViewableThemeModuleType::getPageElementDir()
	 */
	public function getPageElementDir() {
		return MOXEO_DIR;
	}

	// form methods
	/**
	 * @see	ThemeModuleType::readFormParameters()
	 */
	public function readFormParameters() {
		$this->formData['itemsPerPage'] = 10;
		if (isset($_POST['itemsPerPage'])) $this->formData['itemsPerPage'] = intval($_POST['itemsPerPage']);
	}

	/**
	 * @see	ThemeModuleType::assignVariables()
	 */
	public function assignVariables() {
		WCF::getTPL()->assign(array(
			'itemsPerPage' => (isset($this->formData['itemsPerPage']) ? $this->formData['itemsPerPage'] : 10)
		));
	}

	/**
	 * @see	ThemeModuleType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'searchThemeModuleType';
	}
}
?>