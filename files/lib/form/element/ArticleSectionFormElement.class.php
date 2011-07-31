<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/section/ArticleSection.class.php');

// wcf imports
require_once(WCF_DIR.'lib/form/element/AbstractFormElement.class.php');

/**
 * Provides default implementations for article section form elements.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	form.element
 * @category	Infinite Site
 */
abstract class ArticleSectionFormElement extends AbstractFormElement {
	/**
	 * article section object
	 * 
	 * @var	ArticleSection
	 */
	public $articleSection = null;
	
	/**
	 * article object
	 * 
	 * @var	Article
	 */
	public $article = null;
	
	/**
	 * content item object
	 * 
	 * @var	ContentItem
	 */
	public $contentItem = null;
	
	/**
	 * Creates a new ArticleSectionFormElement object.
	 * 
	 * @param	ArticleSection		$articleSection
	 */
	public function __construct(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		$this->articleSection = $articleSection;
		$this->article = $article;
		$this->contentItem = $contentItem;
		parent::__construct();
	}
	
	/**
	 * @see	AbstractFormElement::getIdentifier()
	 */	
	public function getIdentifier() {
		return $this->articleSection->articleSectionID;
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		// assign parameters
		WCF::getTPL()->assign(array(
			'articleSection' => $this->articleSection,
			'article' => $this->article,
			'contentItem' => $this->contentItem
		));
	}
}
?>