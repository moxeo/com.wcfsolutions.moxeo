<?php
// wsis imports
require_once(WSIS_DIR.'lib/acp/form/ArticleSectionAddForm.class.php');

/**
 * Shows the article section edit form.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.form
 * @category	Infinite Site
 */
class ArticleSectionEditForm extends ArticleSectionAddForm {	
	/**
	 * article section id
	 * 
	 * @var	integer
	 */
	public $articleSectionID = 0;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		ACPForm::readParameters();
		
		// get article section
		if (isset($_REQUEST['articleSectionID'])) $this->articleSectionID = intval($_REQUEST['articleSectionID']);
		$this->articleSection = new ArticleSectionEditor($this->articleSectionID);
		if (!$this->articleSection->articleSectionID) {
			throw new IllegalLinkException();
		}
		
		// get article
		$this->article = new ArticleEditor($this->articleSection->articleID);
		
		// get content item
		$this->contentItem = new ContentItemEditor($this->article->contentItemID);
		$this->contentItem->checkAdminPermission('canEditArticle');
		
		// get available article section types
		$this->availableArticleSectionTypes = ArticleSection::getAvailableArticleSectionTypes();
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// default values
		if (!count($_POST)) {
			$this->articleSectionType = $this->articleSection->articleSectionType;
			$this->cssID = $this->articleSection->cssID;
			$this->cssClasses = $this->articleSection->cssClasses;
			$this->showOrder = $this->articleSection->showOrder;
			
			// article section type object
			$this->articleSectionTypeObject = $this->availableArticleSectionTypes[$this->articleSectionType];
			$this->articleSectionTypeObject->setFormData(unserialize($this->articleSection->articleSectionData));
		}
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'action' => 'edit',
			'articleSectionID' => $this->articleSectionID
		));
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		AbstractForm::save();
		
		// update box tob
		$this->articleSection->update($this->articleSectionType, $this->articleSectionTypeObject->getFormData(), $this->cssID, $this->cssClasses, $this->showOrder);
		
		// refresh searchable content
		$this->contentItem->refreshSearchableContent();
		$this->saved();
		
		// show success message
		WCF::getTPL()->assign('success', true);
	}
}
?>