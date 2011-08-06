<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/news/archive/NewsArchive.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/ViewableThemeModuleType.class.php');

/**
 * Represents the news item list theme module type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.theme.module.type
 * @category	Infinite Site
 */
class NewsItemListThemeModuleType extends ViewableThemeModuleType {
	/**
	 * @see	ViewableThemeModuleType::$pageElement
	 */
	public $pageElement = 'newsItemList';
	
	/**
	 * @see	ViewableThemeModuleType::$pageElementDir
	 */
	public $pageElementDir = WSIS_DIR;
	
	// form methods
	/**
	 * @see	ThemeModuleType::readFormParameters()
	 */
	public function readFormParameters() {
		// news archive ids
		$this->formData['newsArchiveIDs'] = array();
		if (isset($_POST['newsArchiveIDs'])) $this->formData['newsArchiveIDs'] = ArrayUtil::toIntegerArray($_POST['newsArchiveIDs']);
		
		// display type
		$this->formData['displayType'] = 'short';
		if (isset($_POST['displayType'])) $this->formData['displayType'] = $_POST['displayType'];
		
		// news items per page
		$this->formData['newsItemsPerPage'] = 10;
		if (isset($_POST['newsItemsPerPage'])) $this->formData['newsItemsPerPage'] = intval($_POST['newsItemsPerPage']);
	}
	
	/**
	 * @see	ThemeModuleType::validate()
	 */
	public function validate() {
		// news archive ids
		foreach ($this->formData['newsArchiveIDs'] as $key => $newsArchiveID) {
			try {
				$newsArchive = new NewsArchive($newsArchiveID);
			}
			catch (IllegalLinkException $e) {
				unset($this->formData['newsArchiveIDs'][$key]);
			}
		}
		if (!count($this->formData['newsArchiveIDs'])) {
			throw new UserInputException('newsArchiveIDs');
		}
		
		// display type
		switch ($this->formData['displayType']) {
			case 'full':
			case 'short': break;
			default: $this->formData['displayType'] = 'short';
		}
	}
	
	/**
	 * @see	ThemeModuleType::assignVariables()
	 */
	public function assignVariables() {
		WCF::getTPL()->assign(array(
			'newsArchiveOptions' => NewsArchive::getNewsArchives(),
			'newsArchiveIDs' => (isset($this->formData['newsArchiveIDs']) ? $this->formData['newsArchiveIDs'] : array()),
			'displayType' => (isset($this->formData['displayType']) ? $this->formData['displayType'] : 'short'),
			'newsItemsPerPage' => (isset($this->formData['newsItemsPerPage']) ? $this->formData['newsItemsPerPage'] : 10)
		));
	}
	
	/**
	 * @see	ThemeModuleType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'newsItemListThemeModuleType';
	}
}
?>