<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/content/ContentItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');

/**
 * Shows a content item.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	page
 * @category	Infinite Site
 */
class ContentItemPage extends AbstractPage {
	// system
	public $templateName = 'contentItem';
	
	/**
	 * content item object
	 * 
	 * @var	ContentItem
	 */
	public $contentItem = null;
	
	/**
	 * additional theme module data
	 * 
	 * @var	array
	 */
	public $additionalThemeModuleData = array();
	
	/**
	 * custom page title
	 * 
	 * @var	string
	 */
	public static $customPageTitle = '';
	
	/**
	 * custom meta description
	 * 
	 * @var	string
	 */
	public static $customMetaDescription = '';
	
	/**
	 * custom meta keywords
	 * 
	 * @var	string
	 */
	public static $customMetaKeywords = '';
	
	/**
	 * Creates a new ContentItemPage object.
	 * 
	 * @param	ContentItem	$contentItem
	 */
	public function __construct(ContentItem $contentItem) {
		$this->contentItem = $contentItem;
		$this->additionalThemeModuleData = array('contentItem' => $this->contentItem);
		parent::__construct();
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// cache theme modules
		WSISCore::getThemeLayout()->cacheModules($this->additionalThemeModuleData);
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'contentItem' => $this->contentItem,
			'additionalThemeModuleData' => $this->additionalThemeModuleData,
			'pageTitle' => (self::$customPageTitle ? self::$customPageTitle : $this->contentItem->getPageTitle()),
			'metaDescription' => (self::$customMetaDescription ? self::$customMetaDescription : $this->contentItem->metaDescription),
			'metaKeywords' => (self::$customMetaKeywords ? self::$customMetaKeywords : $this->contentItem->metaKeywords)
		));
	}
	
	/**
	 * @see	Page::show()
	 */
	public function show() {
		// enter content item		
		$this->contentItem->enter();
		
		// redirect to external url
		if ($this->contentItem->isExternalLink()) {
			// forward
			HeaderUtil::redirect($this->contentItem->externalURL, false);
			exit;
		}
		
		// change theme layout
		if ($this->contentItem->themeLayoutID) {
			require_once(WCF_DIR.'lib/system/theme/ThemeLayoutManager.class.php');
			ThemeLayoutManager::changeThemeLayout($this->contentItem->themeLayoutID);
		}
		
		parent::show();
	}
	
	/**
	 * Sets the custom page title.
	 * 
	 * @param	string		$pageTitle
	 */
	public static function setCustomPageTitle($pageTitle) {
		self::$customPageTitle = $pageTitle;
	}
	
	/**
	 * Sets the custom meta description.
	 * 
	 * @param	string		$metaDescription
	 */
	public static function setCustomMetaDescription($metaDescription) {
		self::$customMetaDescription = $metaDescription;
	}
	
	/**
	 * Sets the custom meta keywords.
	 * 
	 * @param	string		$metaKeywords
	 */
	public static function setCustomMetaKeywords($metaKeywords) {
		self::$customMetaKeywords = $metaKeywords;
	}		
}
?>