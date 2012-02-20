<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/acp/action/AbstractNewsItemAction.class.php');

/**
 * Enables a news item.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.action
 * @category	Moxeo Open Source CMS
 */
class NewsItemEnableAction extends AbstractNewsItemAction {
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();

		// check permission
		WCF::getUser()->checkPermission('admin.moxeo.canEnableNewsItem');

		// enable news item
		$this->newsItem->enable();
		$this->executed();

		// forward to list page
		HeaderUtil::redirect('index.php?page=NewsItemList&newsArchiveID='.$this->newsItem->newsArchiveID.'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>