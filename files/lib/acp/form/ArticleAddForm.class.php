<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/ArticleEditor.class.php');
require_once(WSIS_DIR.'lib/data/content/ContentItemEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');
require_once(WCF_DIR.'lib/data/theme/layout/ThemeLayout.class.php');

/**
 * Shows the article add form.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.form
 * @category	Infinite Site
 */
class ArticleAddForm extends ACPForm {
	// system
	public $templateName = 'articleAdd';
	public $activeMenuItem = 'wsis.acp.menu.link.content.article.add';
	
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
			$this->contentItem->checkAdminPermission('canAddArticle');
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
			'contentItemOptions' => ContentItem::getContentItemSelect(array(), array('canAddArticle')),
		));
	}
}
?>