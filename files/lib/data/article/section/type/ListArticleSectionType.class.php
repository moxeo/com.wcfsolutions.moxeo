<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/HeadlineArticleSectionType.class.php');

/**
 * Represents a list article section type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
class ListArticleSectionType extends HeadlineArticleSectionType {
	/**
	 * @see	HeadlineArticleSectionType::$requireHeadline
	 */
	public $requireHeadline = false;
	
	/**
	 * list of list style type options
	 * 
	 * @var	array
	 */
	public $listStyleTypeOptions = array('none', 'decimal', 'lower-roman', 'upper-roman', 'lower-alpha', 'upper-alpha', 'disc', 'circle', 'square');
	
	// display methods
	/**
	 * @see	ArticleSectionType::getContent()
	 */	
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		WCF::getTPL()->assign(array(
			'listItems' => ArrayUtil::trim(explode("\n", StringUtil::trim(StringUtil::unifyNewlines($articleSection->listItems)))),
			'listTag' => (($articleSection->listStyleType == 'none' || $articleSection->listStyleType == 'circle' || $articleSection->listStyleType == 'square' || $articleSection->listStyleType == 'disc') ? 'ul' : 'ol')
		));
		return WCF::getTPL()->fetch('listArticleSectionType');
	}
	
	// form methods
	/**
	 * @see	ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		$this->formData['listItems'] = '';
		$this->formData['listStyleType'] = 'none';
		
		if (isset($_POST['listItems'])) $this->formData['listItems'] = StringUtil::trim($_POST['listItems']);
		if (isset($_POST['listStyleType'])) $this->formData['listStyleType'] = StringUtil::trim($_POST['listStyleType']);
	}
	
	/**
	 * @see	ArticleSectionType::validate()
	 */
	public function validate() {
		parent::validate();
		
		// list items
		if (empty($this->formData['listItems'])) {
			throw new UserInputException('listItems');				
		}
		
		// list style type
		if (!in_array($this->formData['listStyleType'], $this->listStyleTypeOptions)) {
			throw new UserInputException('listStyleType');				
		}		
	}
	
	/**
	 * @see	ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'listItems' => (isset($this->formData['listItems']) ? $this->formData['listItems'] : ''),
			'listStyleType' => (isset($this->formData['listStyleType']) ? $this->formData['listStyleType'] : 'none'),
			'listStyleTypeOptions' => $this->listStyleTypeOptions
		));
	}
	
	/**
	 * @see	ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'listArticleSectionType';
	}
}
?>