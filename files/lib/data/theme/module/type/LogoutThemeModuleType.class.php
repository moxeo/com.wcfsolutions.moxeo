<?php
// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/ViewableThemeModuleType.class.php');

/**
 * Represents the logout theme module type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.theme.module.type
 * @category	Moxeo Open Source CMS
 */
class LogoutThemeModuleType extends ViewableThemeModuleType {
	/**
	 * @see	ViewableThemeModuleType::$pageElement
	 */
	public $pageElement = 'logout';
	
	/**
	 * @see	ViewableThemeModuleType::$pageElementType
	 */
	public $pageElementType = 'action';
	
	/**
	 * @see	ViewableThemeModuleType::$pageElementDir
	 */
	public $pageElementDir = MOXEO_DIR;
}
?>