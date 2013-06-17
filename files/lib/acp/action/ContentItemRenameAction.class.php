<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/acp/action/AbstractContentItemAction.class.php');

/**
 * Renames a content item.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.action
 * @category	Moxeo Open Source CMS
 */
class ContentItemRenameAction extends AbstractContentItemAction {
	/**
	 * new title
	 *
	 * @var string
	 */
	public $title = '';

	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		if (isset($_POST['title'])) {
			$this->title = $_POST['title'];
			if (CHARSET != 'UTF-8') $this->title = StringUtil::convertEncoding('UTF-8', CHARSET, $this->title);
		}
	}

	/**
	 * @see	Action::execute();
	 */
	public function execute() {
		parent::execute();

		// check permission
		WCF::getUser()->checkPermission('admin.moxeo.isContentItemAdmin');
		WCF::getUser()->checkPermission('admin.moxeo.canEditContentItem');

		// update title
		$this->contentItem->updateTitle($this->title);

		// reset cache
		ContentItemEditor::resetCache();
		$this->executed();
	}
}
?>