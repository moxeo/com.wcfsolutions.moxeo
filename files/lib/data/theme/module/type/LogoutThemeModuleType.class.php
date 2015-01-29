<?php
// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/ViewableThemeModuleType.class.php');

/**
 * Represents the logout theme module type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.theme.module.type
 * @category	Moxeo Open Source CMS
 */
class LogoutThemeModuleType extends ViewableThemeModuleType {
	/**
	 * @see	ViewableThemeModuleType::getPageElement()
	 */
	public function getPageElement() {
		return 'logout';
	}

	/**
	 * @see	ViewableThemeModuleType::getPageElementType()
	 */
	public function getPageElementType() {
		return 'action';
	}

	/**
	 * @see	ViewableThemeModuleType::getPageElementDir()
	 */
	public function getPageElementDir() {
		return MOXEO_DIR;
	}
}
?>