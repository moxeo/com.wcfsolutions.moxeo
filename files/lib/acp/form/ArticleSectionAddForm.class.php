<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/ArticleEditor.class.php');
require_once(MOXEO_DIR.'lib/data/article/section/ArticleSectionEditor.class.php');
require_once(MOXEO_DIR.'lib/data/content/ContentItemEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');

/**
 * Shows the article section add form.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.form
 * @category	Moxeo Open Source CMS
 */
class ArticleSectionAddForm extends ACPForm {
	// system
	public $templateName = 'articleSectionAdd';
	public $activeMenuItem = 'moxeo.acp.menu.link.content.article';
	
	/**
	 * article id
	 * 
	 * @var	integer
	 */
	public $articleID = 0;
	
	/**
	 * article editor object
	 * 
	 * @var	ArticleEditor
	 */
	public $article = null;
	
	/**
	 * content item editor object
	 * 
	 * @var	ContentItemEditor
	 */
	public $contentItem = null;
	
	/**
	 * list of available article section types
	 * 
	 * @var	array<ArticleSectionType>
	 */
	public $articleSectionTypes = array();
	
	/**
	 * article section type object
	 * 
	 * @var	ArticleSectionType
	 */
	public $articleSectionTypeObject = null;
	
	/**
	 * article section type id
	 * 
	 * @var	integer
	 */
	public $articleSectionTypeID = 0;
	
	/**
	 * article section editor object
	 * 
	 * @var	ArticleSectionEditor
	 */
	public $articleSection = null;
	
	/**
	 * list of available box tab types
	 * 
	 * @var	array<ArticleSectionType>
	 */
	public $availableArticleSectionTypes = array();
	
	// parameters
	public $cssID = '';
	public $cssClasses = '';
	public $showOrder = 0;
	public $articleSectionType = '';
	public $send = false;
			
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get article
		if (isset($_REQUEST['articleID'])) $this->articleID = intval($_REQUEST['articleID']);
		$this->article = new ArticleEditor($this->articleID);
		if (!$this->article->articleID) {
			throw new IllegalLinkException();
		}
		
		// get content item
		$this->contentItem = new ContentItemEditor($this->article->contentItemID);
		$this->contentItem->checkAdminPermission('canEditArticle');
		
		// get available article section types
		$this->availableArticleSectionTypes = ArticleSection::getAvailableArticleSectionTypes();
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['cssID'])) $this->cssID = StringUtil::trim($_POST['cssID']);
		if (isset($_POST['cssClasses'])) $this->cssClasses = StringUtil::trim($_POST['cssClasses']);
		if (isset($_POST['showOrder'])) $this->showOrder = intval($_POST['showOrder']);
		if (isset($_POST['articleSectionType'])) $this->articleSectionType = $_POST['articleSectionType'];
		if (isset($_POST['send'])) $this->send = (boolean) $_POST['send'];
		
		// get article section type object
		if ($this->articleSectionType && isset($this->availableArticleSectionTypes[$this->articleSectionType])) {
			$this->articleSectionTypeObject = $this->availableArticleSectionTypes[$this->articleSectionType];
		}
		//if ($this->articleSectionTypeObject !== null && $this->send) {
		if ($this->articleSectionTypeObject !== null) {
			$this->articleSectionTypeObject->readFormParameters();
		}
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// box tab type
		if (!isset($this->availableArticleSectionTypes[$this->articleSectionType])) {
			throw new UserInputException('articleSectionType');
		}
		$this->articleSectionTypeObject->validate();
	}
	
	/**
	 * @see	Form::submit()
	 */
	public function submit() {
		// call submit event
		EventHandler::fireAction($this, 'submit');
		
		$this->readFormParameters();
		
		try {
			// send message or save as draft
			if ($this->send) {
				$this->validate();
				// no errors
				$this->save();
			}
		}
		catch (UserInputException $e) {
			$this->errorField = $e->getField();
			$this->errorType = $e->getType();
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		// create article section
		$this->articleSection = ArticleSectionEditor::create($this->articleID, $this->articleSectionType, $this->articleSectionTypeObject->getFormData(), $this->cssID, $this->cssClasses, $this->showOrder);
		
		// refresh searchable content
		$this->contentItem->refreshSearchableContent();
		$this->saved();
		
		// reset values
		$this->title = $this->articleSectionType = $this->cssID = $this->cssClasses = '';
		$this->showOrder = 0;
		$this->articleSectionTypeObject = null;
		
		// show success message
		WCF::getTPL()->assign('success', true);
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		if ($this->articleSectionTypeObject !== null) {
			$this->articleSectionTypeObject->assignVariables();
		}
		WCF::getTPL()->assign(array(
			'action' => 'add',
			'availableArticleSectionTypes' => $this->availableArticleSectionTypes,
			'articleSectionTypeOptions' => ArticleSection::getArticleSectionTypeOptions(),
			'articleSectionTypeID' => $this->articleSectionTypeID,
			'articleSectionType' => $this->articleSectionType,
			'articleSectionTypeObject' => $this->articleSectionTypeObject,
			'articleID' => $this->articleID,
			'article' => $this->article,
			'contentItem' => $this->contentItem,
			'cssID' => $this->cssID,
			'cssClasses' => $this->cssClasses,
			'showOrder' => $this->showOrder
		));
	}
}
?>