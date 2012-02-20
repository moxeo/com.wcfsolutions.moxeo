<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/acp/action/AbstractContentItemAction.class.php');
require_once(MOXEO_DIR.'lib/data/content/ContentItemEditor.class.php');

/**
 * Deletes a content item.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.action
 * @category	Moxeo Open Source CMS
 */
class ContentItemDeleteAction extends AbstractContentItemAction {
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();

		// check permission
		$this->contentItem->checkAdminPermission('canDeleteContentItem');

		// delete content item
		$this->contentItem->delete();

		// reset cache
		ContentItemEditor::resetCache();
		$this->executed();

		// forward to list page
		HeaderUtil::redirect('index.php?page=ContentItemList&deletedContentItemID='.$this->contentItemID.'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>