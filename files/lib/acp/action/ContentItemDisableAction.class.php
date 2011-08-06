<?php
// wsis imports
require_once(WSIS_DIR.'lib/acp/action/AbstractContentItemAction.class.php');

/**
 * Disables a content item.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.action
 * @category	Infinite Site
 */
class ContentItemDisableAction extends AbstractContentItemAction {	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// check permission
		$this->contentItem->checkAdminPermission('canEnableContentItem');
		
		// disable content item
		$this->contentItem->disable();
		
		// reset cache
		ContentItemEditor::resetCache();
		$this->executed();
		
		// forward to list page
		HeaderUtil::redirect('index.php?page=ContentItemList&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>