<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/acp/form/ContentItemAddForm.class.php');

/**
 * Shows the content item edit form.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.form
 * @category	Moxeo Open Source CMS
 */
class ContentItemEditForm extends ContentItemAddForm {
	// system
	public $activeMenuItem = 'moxeo.acp.menu.link.content.contentItem';
	//public $neededPermissions = 'admin.moxeo.canEditContentItem';

	/**
	 * content item id
	 *
	 * @var	integer
	 */
	public $contentItemID = 0;

	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		// get content item
		if (isset($_REQUEST['contentItemID'])) $this->contentItemID = intval($_REQUEST['contentItemID']);
		$this->contentItem = new ContentItemEditor($this->contentItemID);

		// check permission
		$this->contentItem->checkAdminPermission('canEditContentItem');
	}

	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();

		if (!count($_POST)) {
			// get values
			$this->languageID = $this->contentItem->languageID;
			$this->parentID = $this->contentItem->parentID;
			$this->title = $this->contentItem->title;
			$this->contentItemAlias = $this->contentItem->contentItemAlias;
			$this->description = $this->contentItem->description;
			$this->pageTitle = $this->contentItem->pageTitle;
			$this->metaDescription = $this->contentItem->metaDescription;
			$this->metaKeywords = $this->contentItem->metaKeywords;
			$this->contentItemType = $this->contentItem->contentItemType;
			$this->externalURL = $this->contentItem->externalURL;
			$this->themeLayoutID = $this->contentItem->themeLayoutID;
			$this->cssClasses = $this->contentItem->cssClasses;
			$this->robots = $this->contentItem->robots;
			$this->showOrder = $this->contentItem->showOrder;
			$this->invisible = $this->contentItem->invisible;
			$this->addSecurityToken = $this->contentItem->addSecurityToken;

			// publishing start time
			if ($this->contentItem->publishingStartTime) {
				$this->publishingStartTimeDay = intval(DateUtil::formatDate('%e', $this->contentItem->publishingStartTime, false, true));
				$this->publishingStartTimeMonth = intval(DateUtil::formatDate('%m', $this->contentItem->publishingStartTime, false, true));
				$this->publishingStartTimeYear = DateUtil::formatDate('%Y', $this->contentItem->publishingStartTime, false, true);
				$this->publishingStartTimeHour = DateUtil::formatDate('%H', $this->contentItem->publishingStartTime, false, true);
				$this->publishingStartTimeMinutes = DateUtil::formatDate('%M', $this->contentItem->publishingStartTime, false, true);
			}

			// publishing end time
			if ($this->contentItem->publishingEndTime) {
				$this->publishingEndTimeDay = intval(DateUtil::formatDate('%e', $this->contentItem->publishingEndTime, false, true));
				$this->publishingEndTimeMonth = intval(DateUtil::formatDate('%m', $this->contentItem->publishingEndTime, false, true));
				$this->publishingEndTimeYear = DateUtil::formatDate('%Y', $this->contentItem->publishingEndTime, false, true);
				$this->publishingEndTimeHour = DateUtil::formatDate('%H', $this->contentItem->publishingEndTime, false, true);
				$this->publishingEndTimeMinutes = DateUtil::formatDate('%M', $this->contentItem->publishingEndTime, false, true);
			}

			// get permissions
			$sql = "		(SELECT		user_permission.*, user.userID AS id, 'user' AS type, user.username AS name
						FROM		moxeo".MOXEO_N."_content_item_to_user user_permission
						LEFT JOIN	wcf".WCF_N."_user user
						ON		(user.userID = user_permission.userID)
						WHERE		contentItemID = ".$this->contentItemID.")
				UNION
						(SELECT		group_permission.*, usergroup.groupID AS id, 'group' AS type, usergroup.groupName AS name
						FROM		moxeo".MOXEO_N."_content_item_to_group group_permission
						LEFT JOIN	wcf".WCF_N."_group usergroup
						ON		(usergroup.groupID = group_permission.groupID)
						WHERE		contentItemID = ".$this->contentItemID.")
				ORDER BY	name";
			$result = WCF::getDB()->sendQuery($sql);
			while ($row = WCF::getDB()->fetchArray($result)) {
				if (empty($row['id'])) continue;
				$permission = array('name' => $row['name'], 'type' => $row['type'], 'id' => $row['id']);
				unset($row['name'], $row['userID'], $row['groupID'], $row['contentItemID'], $row['id'], $row['type']);
				foreach ($row as $key => $value) {
					if (!in_array($key, $this->permissionSettings)) unset($row[$key]);
				}
				$permission['settings'] = $row;
				$this->permissions[] = $permission;
			}

			// get admins
			$sql = "SELECT		admin.*, IFNULL(user.username, usergroup.groupName) AS name, user.userID, usergroup.groupID
				FROM		moxeo".MOXEO_N."_content_item_admin admin
				LEFT JOIN	wcf".WCF_N."_user user
				ON		(user.userID = admin.userID)
				LEFT JOIN	wcf".WCF_N."_group usergroup
				ON		(usergroup.groupID = admin.groupID)
				WHERE		contentItemID = ".$this->contentItemID."
				ORDER BY	name";
			$result = WCF::getDB()->sendQuery($sql);
			while ($row = WCF::getDB()->fetchArray($result)) {
				if (empty($row['userID']) && empty($row['groupID'])) continue;
				$admin = array('name' => $row['name'], 'type' => ($row['userID'] ? 'user' : 'group'), 'id' => ($row['userID'] ? $row['userID'] : $row['groupID']));
				unset($row['name'], $row['userID'], $row['groupID'], $row['contentItemID']);
				foreach ($row as $key => $value) {
					if (!in_array($key, $this->adminSettings)) unset($row[$key]);
				}
				$admin['settings'] = $row;
				$this->admins[] = $admin;
			}
		}

		// get content item options
		$this->contentItemOptions = ContentItem::getContentItemSelect(array(), array('canAddContentItem'), array(), array($this->contentItemID));
	}

	/**
	 * @see	ContentItemAddForm::validateParentID()
	 */
	protected function validateParentID() {
		parent::validateParentID();

		if ($this->parentID) {
			if ($this->contentItemID == $this->parentID || ContentItem::searchChildren($this->contentItemID, $this->parentID)) {
				$this->parentID = 0;
			}
		}
	}

	/**
	 * @see	Form::save()
	 */
	public function save() {
		AbstractForm::save();

		// update content item
		$this->contentItem->update($this->languageID, $this->parentID, $this->title, $this->contentItemAlias, $this->description, $this->contentItemType, $this->externalURL, $this->pageTitle,
		$this->metaDescription, $this->metaKeywords, $this->publishingStartTime, $this->publishingEndTime, $this->themeLayoutID, $this->cssClasses, $this->robots, $this->showOrder, $this->invisible, $this->addSecurityToken);

		// save permissions
		$this->permissions = ContentItemEditor::getCleanedPermissions($this->permissions);
		$this->contentItem->removePermissions();
		$this->contentItem->addPermissions($this->permissions, $this->permissionSettings);

		// save admins
		if (WCF::getUser()->getPermission('admin.moxeo.isContentItemAdmin')) {
			$this->admins = ContentItemEditor::getCleanedPermissions($this->admins);
			$this->contentItem->removeAdmins();
			$this->contentItem->addAdmins($this->admins, $this->adminSettings);
		}

		// reset cache
		ContentItemEditor::resetCache();

		// reset sessions
		Session::resetSessions(array(), true, false);
		$this->saved();

		// show success message
		WCF::getTPL()->assign('success', true);
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'action' => 'edit',
			'contentItemID' => $this->contentItemID,
			'contentItem' => $this->contentItem,
			'contentItemQuickJumpOptions' => ContentItem::getContentItemSelect(array(), array('canEditContentItem'))
		));
	}
}
?>