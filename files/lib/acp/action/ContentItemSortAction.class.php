<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/content/ContentItemEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

/**
 * Sorts the structure of content items.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.action
 * @category	Infinite Site
 */
class ContentItemSortAction extends AbstractAction {
	/**
	 * new positions
	 * 
	 * @var array
	 */
	public $positions = array();
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_POST['contentItemListPositions']) && is_array($_POST['contentItemListPositions'])) $this->positions = ArrayUtil::toIntegerArray($_POST['contentItemListPositions']);
	}
	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// check permission
		WCF::getUser()->checkPermission('admin.site.isContentItemAdmin');
		WCF::getUser()->checkPermission('admin.site.canEditContentItem');
		
		// update postions
		foreach ($this->positions as $contentItemID => $data) {
			foreach ($data as $parentID => $position) {
				ContentItemEditor::updatePosition(intval($contentItemID), intval($parentID), $position);
			}
		}
		
		// reset cache
		ContentItemEditor::resetCache();
		$this->executed();
		
		// forward to list page
		HeaderUtil::redirect('index.php?page=ContentItemList&successfulSorting=1&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>