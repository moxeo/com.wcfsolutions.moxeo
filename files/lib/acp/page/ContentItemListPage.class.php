<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/content/ACPContentItemList.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');

/**
 * Shows a list of all content items.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.page
 * @category	Infinite Site
 */
class ContentItemListPage extends AbstractPage {
	// system
	public $templateName = 'contentItemList';
	public $neededPermissions = array('admin.site.canEditContentItem', 'admin.site.canDeleteContentItem');
	
	/**
	 * content item list object
	 * 
	 * @var	ContentItemList
	 */
	public $contentItemList = null;
	
	/**
	 * deleted content item id
	 * 
	 * @var	integer
	 */
	public $deletedContentItemID = 0;
	
	/**
	 * True, if the list was sorted successfully.
	 *
	 * @var boolean
	 */
	public $successfulSorting = false;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['deletedContentItemID'])) $this->deletedContentItemID = intval($_REQUEST['deletedContentItemID']);
		if (isset($_REQUEST['successfulSorting'])) $this->successfulSorting = true;
		
		// init content item list
		$this->contentItemList = new ACPContentItemList();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function readData() {
		parent::readData();
		
		// read content items
		$this->contentItemList->readContentItems();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'contentItems' => $this->contentItemList->getContentItemList(),
			'deletedContentItemID' => $this->deletedContentItemID,
			'successfulSorting' => $this->successfulSorting
		));
	}
	
	/**
	 * @see	Page::show()
	 */
	public function show() {
		// enable menu item
		WCFACP::getMenu()->setActiveMenuItem('wsis.acp.menu.link.content.contentItem.view');
		
		parent::show();
	}
}
?>