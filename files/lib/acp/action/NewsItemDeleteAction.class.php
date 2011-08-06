<?php
// wsis imports
require_once(WSIS_DIR.'lib/acp/action/AbstractNewsItemAction.class.php');

/**
 * Deletes a news item.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.action
 * @category	Infinite Site
 */
class NewsItemDeleteAction extends AbstractNewsItemAction {	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// check permission
		WCF::getUser()->checkPermission('admin.site.canDeleteNewsItem');
		
		// delete news item
		$this->newsItem->delete();
		$this->executed();
		
		// forward to list page
		HeaderUtil::redirect('index.php?page=NewsItemList&newsArchiveID='.$this->newsItem->newsArchiveID.'&deletedNewsItemID='.$this->newsItemID.'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>