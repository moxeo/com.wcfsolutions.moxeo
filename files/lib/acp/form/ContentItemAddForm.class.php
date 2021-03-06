<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItemEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');
require_once(WCF_DIR.'lib/data/theme/layout/ThemeLayout.class.php');
require_once(WCF_DIR.'lib/system/session/UserSession.class.php');

/**
 * Shows the content item add form.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.form
 * @category	Moxeo Open Source CMS
 */
class ContentItemAddForm extends ACPForm {
	// system
	public $templateName = 'contentItemAdd';
	public $activeMenuItem = 'moxeo.acp.menu.link.content.contentItem.add';
	public $activeTabMenuItem = 'data';

	/**
	 * content item editor object
	 *
	 * @var	ContentItemEditor
	 */
	public $contentItem = null;

	/**
	 * list of available parent content items
	 *
	 * @var	array
	 */
	public $contentItemOptions = array();

	/**
	 * list of available theme layouts
	 *
	 * @var	array
	 */
	public $themeLayoutOptions = array();

	/**
	 * list of available languages
	 *
	 * @var	array
	 */
	public $languages = array();

	/**
	 * list of available permisions
	 *
	 * @var	array
	 */
	public $permissionSettings = array();

	/**
	 * list of available admin permissions
	 *
	 * @var	array
	 */
	public $adminSettings = array();

	/**
	 * publishing start time
	 *
	 * @var	integer
	 */
	public $publishingStartTime = 0;

	/**
	 * publishing end time
	 *
	 * @var	integer
	 */
	public $publishingEndTime = 0;

	// parameters
	public $languageID = 0;
	public $parentID = 0;
	public $title = '';
	public $contentItemAlias = '';
	public $description = '';
	public $contentItemType = 0;
	public $externalURL = '';
	public $pageTitle = '';
	public $metaDescription = '';
	public $metaKeywords = '';
	public $publishingStartTimeDay = '';
	public $publishingStartTimeMonth = '';
	public $publishingStartTimeYear = '';
	public $publishingStartTimeHour = '';
	public $publishingStartTimeMinutes = '';
	public $publishingEndTimeDay = '';
	public $publishingEndTimeMonth = '';
	public $publishingEndTimeYear = '';
	public $publishingEndTimeHour = '';
	public $publishingEndTimeMinutes = '';
	public $themeLayoutID = 0;
	public $cssClasses = '';
	public $robots = 'index,follow';
	public $showOrder = 0;
	public $invisible = 0;
	public $addSecurityToken = 0;
	public $permissions = array();
	public $admins = array();

	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		if (isset($_REQUEST['parentID'])) $this->parentID = intval($_REQUEST['parentID']);
		if ($this->parentID) {
			ContentItem::getContentItem($this->parentID)->checkAdminPermission('canAddContentItem');
		}
		else {
			WCF::getUser()->checkPermission('admin.moxeo.canAddContentItem');
		}

		// get permission settings
		$this->permissionSettings = ContentItem::getPermissionSettings();

		// get admin settings
		$this->adminSettings = ContentItem::getAdminSettings();

		// get language id
		$this->languageID = WCF::getLanguage()->getLanguageID();
	}

	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();

		$this->contentItemOptions = ContentItem::getContentItemSelect(array(), array('canAddContentItem'));
		$this->themeLayoutOptions = ThemeLayout::getThemeLayouts();

		// get all available languages
		$this->languages = Language::getLanguageCodes();
	}

	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		$this->invisible = $this->addSecurityToken = 0;

		if (isset($_POST['languageID'])) $this->languageID = intval($_POST['languageID']);
		if (isset($_POST['title'])) $this->title = StringUtil::trim($_POST['title']);
		if (isset($_POST['contentItemAlias'])) $this->contentItemAlias = StringUtil::trim($_POST['contentItemAlias']);
		if (isset($_POST['description'])) $this->description = StringUtil::trim($_POST['description']);
		if (isset($_POST['contentItemType'])) $this->contentItemType = intval($_POST['contentItemType']);
		if (isset($_POST['externalURL'])) $this->externalURL = StringUtil::trim($_POST['externalURL']);
		if (isset($_POST['pageTitle'])) $this->pageTitle = StringUtil::trim($_POST['pageTitle']);
		if (isset($_POST['metaDescription'])) $this->metaDescription = StringUtil::trim($_POST['metaDescription']);
		if (isset($_POST['metaKeywords'])) $this->metaKeywords = StringUtil::trim($_POST['metaKeywords']);
		if (isset($_POST['themeLayoutID'])) $this->themeLayoutID = intval($_POST['themeLayoutID']);
		if (isset($_POST['cssClasses'])) $this->cssClasses = StringUtil::trim($_POST['cssClasses']);
		if (isset($_POST['robots'])) $this->robots = StringUtil::trim($_POST['robots']);
		if (isset($_POST['showOrder'])) $this->showOrder = intval($_POST['showOrder']);
		if (isset($_POST['invisible'])) $this->invisible = intval($_POST['invisible']);
		if (isset($_POST['addSecurityToken'])) $this->addSecurityToken = intval($_POST['addSecurityToken']);
		if (isset($_POST['permission']) && is_array($_POST['permission'])) $this->permissions = $_POST['permission'];
		if (isset($_POST['admin']) && is_array($_POST['admin'])) $this->admins = $_POST['admin'];
		if (isset($_POST['activeTabMenuItem'])) $this->activeTabMenuItem = $_POST['activeTabMenuItem'];

		// publishing start time
		if (isset($_POST['publishingStartTimeDay'])) $this->publishingStartTimeDay = intval($_POST['publishingStartTimeDay']);
		if (isset($_POST['publishingStartTimeMonth'])) $this->publishingStartTimeMonth = intval($_POST['publishingStartTimeMonth']);
		if (!empty($_POST['publishingStartTimeYear'])) $this->publishingStartTimeYear = intval($_POST['publishingStartTimeYear']);
		if (isset($_POST['publishingStartTimeHour'])) $this->publishingStartTimeHour = intval($_POST['publishingStartTimeHour']);
		if (isset($_POST['publishingStartTimeMinutes'])) $this->publishingStartTimeMinutes = intval($_POST['publishingStartTimeMinutes']);

		// publishing end time
		if (isset($_POST['publishingEndTimeDay'])) $this->publishingEndTimeDay = intval($_POST['publishingEndTimeDay']);
		if (isset($_POST['publishingEndTimeMonth'])) $this->publishingEndTimeMonth = intval($_POST['publishingEndTimeMonth']);
		if (!empty($_POST['publishingEndTimeYear'])) $this->publishingEndTimeYear = intval($_POST['publishingEndTimeYear']);
		if (isset($_POST['publishingEndTimeHour'])) $this->publishingEndTimeHour = intval($_POST['publishingEndTimeHour']);
		if (isset($_POST['publishingEndTimeMinutes'])) $this->publishingEndTimeMinutes = intval($_POST['publishingEndTimeMinutes']);
	}

	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();

		// language id
		if ($this->contentItemType == -1) {
			if (!Language::getLanguage($this->languageID)) {
				// use default language
				$this->languageID = Language::getDefaultLanguageID();
			}
		}
		else {
			$this->languageID = 0;
		}

		// content item type
		if ($this->contentItemType < -1 || $this->contentItemType > 3) {
			$this->contentItemType = 0;
		}

		// parent id
		$this->validateParentID();

		// title
		if (empty($this->title)) {
			throw new UserInputException('title');
		}

		// alias
		if (empty($this->contentItemAlias) && $this->contentItemType != -1) {
			$this->contentItemAlias = $this->title;
		}
		$this->contentItemAlias = SEOUtil::formatString($this->contentItemAlias);

		// external url
		if ($this->contentItemType == 1 && empty($this->externalURL)) {
			throw new UserInputException('externalURL');
		}

		// publishing start time
		$this->validatePublishingTime('publishingStartTime', array(
			'day' => $this->publishingStartTimeDay,
			'month' => $this->publishingStartTimeMonth,
			'year' => $this->publishingStartTimeYear,
			'hour' => $this->publishingStartTimeHour,
			'minutes' => $this->publishingStartTimeMinutes
		));

		// publishing end time
		$this->validatePublishingTime('publishingEndTime', array(
			'day' => $this->publishingEndTimeDay,
			'month' => $this->publishingEndTimeMonth,
			'year' => $this->publishingEndTimeYear,
			'hour' => $this->publishingEndTimeHour,
			'minutes' => $this->publishingEndTimeMinutes
		));

		// robots
		switch ($this->robots) {
			case 'index,follow':
			case 'index,nofollow':
			case 'noindex,follow':
			case 'noindex,nofollow': break;
			default: $this->robots = 'index,follow';
		}

		// meta keywords
		$this->metaKeywords = implode(',', ArrayUtil::trim(explode(',', $this->metaKeywords)));

		// permissions
		$this->validatePermissions($this->permissions, $this->permissionSettings);

		// admins
		$this->validatePermissions($this->admins, $this->adminSettings);
	}

	/**
	 * Validates the parent id.
	 */
	protected function validateParentID() {
		if ($this->contentItemType != -1) {
			if ($this->parentID) {
				try {
					ContentItem::getContentItem($this->parentID);
				}
				catch (IllegalLinkException $e) {
					throw new UserInputException('parentID');
				}
			}
			else {
				throw new UserInputException('parentID');
			}
		}
		else {
			$this->parentID = 0;
		}
	}

	/**
	 * Validates the publishing time with the given name and the given time options.
	 *
	 * @param	string		$name
	 * @param	array		$options
	 */
	protected function validatePublishingTime($name, $options) {
		if ($options['day'] || $options['month'] || $options['year'] || $options['hour'] || $options['minutes']) {
			$time = @gmmktime($options['hour'], $options['minutes'], 0, $options['month'], $options['day'], $options['year']);
			// since php5.1.0 mktime returns false on failure
			if ($time === false || $time === -1) {
				throw new UserInputException($name, 'invalid');
			}

			// get utc time
			$time = DateUtil::getUTC($time);
			if ($this->contentItem === null && $time <= TIME_NOW) {
				throw new UserInputException($name, 'invalid');
			}

			$this->$name = $time;
		}
	}

	/**
	 * Validates the given permissions.
	 *
	 * @param	array		$permissions
	 * @param	array		$permissionSettings
	 */
	public function validatePermissions($permissions, $permissionSettings) {
		$settings = array_flip($permissionSettings);
		foreach ($permissions as $permission) {
			// type
			if (!isset($permission['type']) || ($permission['type'] != 'user' && $permission['type'] != 'group')) {
				throw new UserInputException();
			}

			// id
			if (!isset($permission['id'])) {
				throw new UserInputException();
			}
			if ($permission['type'] == 'user') {
				$user = new User(intval($permission['id']));
				if (!$user->userID) throw new UserInputException();
			}
			else {
				$group = new Group(intval($permission['id']));
				if (!$group->groupID) throw new UserInputException();
			}

			// settings
			if (!isset($permission['settings']) || !is_array($permission['settings'])) {
				throw new UserInputException();
			}

			// find invalid settings
			foreach ($permission['settings'] as $key => $value) {
				if (!isset($settings[$key]) || ($value != -1 && $value != 0 && $value =! 1)) {
					throw new UserInputException();
				}
			}

			// find missing settings
			foreach ($settings as $key => $value) {
				if (!isset($permission['settings'][$key])) {
					throw new UserInputException();
				}
			}
		}
	}

	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();

		// save content item
		$this->contentItem = ContentItemEditor::create($this->languageID, $this->parentID, $this->title, $this->contentItemAlias, $this->description, $this->contentItemType, $this->externalURL, $this->pageTitle,
		$this->metaDescription, $this->metaKeywords, $this->publishingStartTime, $this->publishingEndTime, $this->themeLayoutID, $this->cssClasses, $this->robots, $this->showOrder, $this->invisible, $this->addSecurityToken);

		// save permissions
		$this->permissions = ContentItemEditor::getCleanedPermissions($this->permissions);
		$this->contentItem->addPermissions($this->permissions, $this->permissionSettings);

		// save admins
		if (WCF::getUser()->getPermission('admin.moxeo.isContentItemAdmin')) {
			$this->admins = ContentItemEditor::getCleanedPermissions($this->admins);
			$this->contentItem->addAdmins($this->admins, $this->adminSettings);
		}

		// reset cache
		ContentItemEditor::resetCache();

		// reset sessions
		Session::resetSessions(array(), true, false);
		$this->saved();

		// reset values
		$this->parentID = $this->contentItemType = $this->themeLayoutID = $this->showOrder = $this->invisible = $this->addSecurityToken = 0;
		$this->title = $this->contentItemAlias = $this->description = $this->externalURL = $this->pageTitle = $this->metaDescription = $this->metaKeywords = $this->cssClasses =
		$this->publishingStartTimeDay = $this->publishingStartTimeMonth = $this->publishingStartTimeYear = $this->publishingStartTimeHour = $this->publishingStartTimeMinutes =
		$this->publishingEndTimeDay = $this->publishingEndTimeMonth = $this->publishingEndTimeYear = $this->publishingEndTimeHour = $this->publishingEndTimeMinutes = '';
		$this->robots = 'index,follow';
		$this->permissions = $this->admins = array();
		$this->languageID = WCF::getLanguage()->getLanguageID();

		// show success message
		WCF::getTPL()->assign('success', true);
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		require_once(WCF_DIR.'lib/page/util/InlineCalendar.class.php');
		InlineCalendar::assignVariables();

		WCF::getTPL()->assign(array(
			'action' => 'add',
			'contentItemOptions' => $this->contentItemOptions,
			'themeLayoutOptions' => $this->themeLayoutOptions,
			'permissions' => $this->permissions,
			'admins' => $this->admins,
			'permissionSettings' => $this->permissionSettings,
			'adminSettings' => $this->adminSettings,
			'languages' => $this->languages,
			'languageID' => $this->languageID,
			'parentID' => $this->parentID,
			'title' => $this->title,
			'contentItemAlias' => $this->contentItemAlias,
			'description' => $this->description,
			'contentItemType' => $this->contentItemType,
			'externalURL' => $this->externalURL,
			'contentItemPageTitle' => $this->pageTitle,
			'metaDescription' => $this->metaDescription,
			'metaKeywords' => $this->metaKeywords,
			'publishingStartTimeDay' => $this->publishingStartTimeDay,
			'publishingStartTimeMonth' => $this->publishingStartTimeMonth,
			'publishingStartTimeYear' => $this->publishingStartTimeYear,
			'publishingStartTimeHour' => $this->publishingStartTimeHour,
			'publishingStartTimeMinutes' => $this->publishingStartTimeMinutes,
			'publishingEndTimeDay' => $this->publishingEndTimeDay,
			'publishingEndTimeMonth' => $this->publishingEndTimeMonth,
			'publishingEndTimeYear' => $this->publishingEndTimeYear,
			'publishingEndTimeHour' => $this->publishingEndTimeHour,
			'publishingEndTimeMinutes' => $this->publishingEndTimeMinutes,
			'themeLayoutID' => $this->themeLayoutID,
			'cssClasses' => $this->cssClasses,
			'robots' => $this->robots,
			'showOrder' => $this->showOrder,
			'invisible' => $this->invisible,
			'addSecurityToken' => $this->addSecurityToken,
			'activeTabMenuItem' => $this->activeTabMenuItem
		));
	}
}
?>