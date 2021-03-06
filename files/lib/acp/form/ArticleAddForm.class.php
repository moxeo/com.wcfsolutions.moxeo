<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/ArticleEditor.class.php');
require_once(MOXEO_DIR.'lib/data/content/ContentItemEditor.class.php');
require_once(MOXEO_DIR.'lib/data/content/ACPContentItemList.class.php');

// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');
require_once(WCF_DIR.'lib/data/theme/layout/ThemeLayout.class.php');

/**
 * Shows the article add form.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.form
 * @category	Moxeo Open Source CMS
 */
class ArticleAddForm extends ACPForm {
	// system
	public $templateName = 'articleAdd';
	public $activeMenuItem = 'moxeo.acp.menu.link.content.article.add';

	/**
	 * content item id
	 *
	 * @var	integer
	 */
	public $contentItemID = 0;

	/**
	 * content item editor object
	 *
	 * @var	ContentItemEditor
	 */
	public $contentItem = null;

	/**
	 * content item list object
	 *
	 * @var	ContentItemList
	 */
	public $contentItemList = null;

	/**
	 * article editor object
	 *
	 * @var	ArticleEditor
	 */
	public $article = null;

	// parameters
	public $themeModulePosition = 'main';
	public $title = '';
	public $cssID = '';
	public $cssClasses = '';
	public $showOrder = 0;

	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		if (isset($_REQUEST['contentItemID'])) $this->contentItemID = intval($_REQUEST['contentItemID']);
		if ($this->contentItemID) {
			$this->contentItem = new ContentItemEditor($this->contentItemID);
			if ($this->contentItem->isRoot() || $this->contentItem->isExternalLink()) {
				throw new IllegalLinkException();
			}
			$this->contentItem->checkAdminPermission('canAddArticle');
		}
		else {
			// init content item list
			$this->contentItemList = new ACPContentItemList();
		}
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function readData() {
		parent::readData();

		if ($this->contentItemList !== null) {
			// read content items
			$this->contentItemList->readContentItems();
		}
	}

	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		if (isset($_POST['themeModulePosition'])) $this->themeModulePosition = StringUtil::trim($_POST['themeModulePosition']);
		if (isset($_POST['title'])) $this->title = StringUtil::trim($_POST['title']);
		if (isset($_POST['cssID'])) $this->cssID = StringUtil::trim($_POST['cssID']);
		if (isset($_POST['cssClasses'])) $this->cssClasses = StringUtil::trim($_POST['cssClasses']);
		if (isset($_POST['showOrder'])) $this->showOrder = intval($_POST['showOrder']);
	}

	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		ACPForm::validate();

		// title
		if (empty($this->title)) {
			throw new UserInputException('title');
		}

		// theme module position
		if (!in_array($this->themeModulePosition, ThemeLayout::$themeModulePositions)) {
			throw new UserInputException('themeModulePosition');
		}
	}

	/**
	 * @see	Form::save()
	 */
	public function save() {
		ACPForm::save();

		// create article
		$this->article = ArticleEditor::create($this->contentItemID, $this->themeModulePosition, $this->title, $this->cssID, $this->cssClasses, $this->showOrder);

		// reset cache
		WCF::getCache()->clearResource('contentItemArticles');
		$this->saved();

		// reset values
		$this->title = $this->cssID = $this->cssClasses = '';
		$this->themeModulePosition = 'main';
		$this->showOrder = 0;

		// show success message
		WCF::getTPL()->assign('success', true);
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'action' => 'add',
			'themeModulePositions' => ThemeLayout::$themeModulePositions,
			'contentItemID' => $this->contentItemID,
			'contentItem' => $this->contentItem,
			'themeModulePosition' => $this->themeModulePosition,
			'title' => $this->title,
			'cssID' => $this->cssID,
			'cssClasses' => $this->cssClasses,
			'showOrder' => $this->showOrder,
			'contentItems' => ($this->contentItemList !== null ? $this->contentItemList->getContentItemList() : null)
		));
	}
}
?>