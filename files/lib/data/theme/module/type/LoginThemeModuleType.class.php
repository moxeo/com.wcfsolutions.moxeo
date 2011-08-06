<?php
// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/ViewableThemeModuleType.class.php');

/**
 * Represents the login theme module type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.theme.module.type
 * @category	Infinite Site
 */
class LoginThemeModuleType extends ViewableThemeModuleType {
	/**
	 * @see	ViewableThemeModuleType::$pageElement
	 */
	public $pageElement = 'login';
	
	/**
	 * @see	ViewableThemeModuleType::$pageElementType
	 */
	public $pageElementType = 'form';
	
	/**
	 * @see	ViewableThemeModuleType::$pageElementDir
	 */
	public $pageElementDir = WSIS_DIR;
}
?>