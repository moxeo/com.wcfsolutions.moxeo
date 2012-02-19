<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');
require_once(MOXEO_DIR.'lib/data/news/archive/NewsArchiveEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');

/**
 * Shows the news archive add form.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.form
 * @category	Moxeo Open Source CMS
 */
class NewsArchiveAddForm extends ACPForm {
	// system
	public $templateName = 'newsArchiveAdd';
	public $activeMenuItem = 'moxeo.acp.menu.link.content.newsArchive.add';
	public $neededPermissions = 'admin.site.canAddNewsArchive';
		
	/**
	 * news archive editor object
	 * 
	 * @var	NewsArchiveEditor
	 */
	public $newsArchive = null;
	
	/**
	 * list of available content items
	 * 
	 * @var	array
	 */
	public $contentItemOptions = array();
		
	// parameters
	public $title = '';
	public $contentItemID = 0;
		
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		$this->contentItemOptions = ContentItem::getContentItemSelect(array());
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['title'])) $this->title = StringUtil::trim($_POST['title']);
		if (isset($_POST['contentItemID'])) $this->contentItemID = intval($_POST['contentItemID']);
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// title
		if (empty($this->title)) {
			throw new UserInputException('title');
		}
		
		// content item id
		try {
			ContentItem::getContentItem($this->contentItemID);
		}
		catch (IllegalLinkException $e) {
			throw new UserInputException('contentItemID', 'invalid');
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		// save news archive
		$this->newsArchive = NewsArchiveEditor::create($this->title, $this->contentItemID);
		
		// reset cache
		NewsArchiveEditor::resetCache();
		$this->saved();
		
		// reset values
		$this->contentItemID = 0;
		$this->title = '';
		
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
			'contentItemOptions' => $this->contentItemOptions,
			'title' => $this->title,
			'contentItemID' => $this->contentItemID
		));
	}
}
?>