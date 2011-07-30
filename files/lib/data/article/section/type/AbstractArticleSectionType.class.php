<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/section/ArticleSection.class.php');
require_once(WSIS_DIR.'lib/data/article/section/type/ArticleSectionType.class.php');

/**
 * Provides default implementations for article section types.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.article.section.type
 * @category	Infinite Site
 */
abstract class AbstractArticleSectionType implements ArticleSectionType {
	/**
	 * article section form data
	 * 
	 * @var	array
	 */
	public $formData = array();
	
	// display methods
	/**
	 * @see	ArticleSectionType::cache()
	 */
	public function cache(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {}
	
	/**
	 * @see	ArticleSectionType::hasContent()
	 */	
	public function hasContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return true;
	}
	
	/**
	 * @see	ArticleSectionType::getContent()
	 */	
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return '';
	}
	
	/**
	 * @see	ArticleSectionType::getSearchableContent()
	 */	
	public function getSearchableContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return '';
	}
	
	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */	
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return '### '.WCF::getLanguage()->get('wsis.article.section.type.'.$articleSection->articleSectionType).' ###';
	}
	
	// form methods
	/**
	 * @see	ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {}
	
	/**
	 * @see	ArticleSectionType::validate()
	 */
	public function validate() {}
	
	/**
	 * @see	ArticleSectionType::getFormData()
	 */
	public function getFormData() {
		return $this->formData;
	}
	
	/**
	 * @see	ArticleSectionType::readFormData()
	 */
	public function setFormData($data) {
		$this->formData = $data;
	}
	
	/**
	 * @see	ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {}
	
	/**
	 * @see	ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return '';
	}	
}
?>