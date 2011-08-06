<?php
/**
 * All article section type classes should implement this interface. 
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.article.section.type
 * @category	Infinite Site
 */
interface ArticleSectionType {
	// display methods
	/**
	 * Caches all necessary article section data to save performance.
	 *
	 * @param	ArticleSection		$articleSection
	 * @param	Article			$article
	 * @param	ContentItem		$contentItem
	 */
	public function cache(ArticleSection $articleSection, Article $article, ContentItem $contentItem);
	
	/**
	 * Returns true, if the given article section object has content.
	 * 
	 * @param	ArticleSection		$articleSection
	 * @param	Article			$article
	 * @param	ContentItem		$contentItem
	 * @return	boolean
	 */
	public function hasContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem);
	
	/**
	 * Returns the content of the given article section object (html code).
	 * 
	 * @param	ArticleSection		$articleSection
	 * @param	Article			$article
	 * @param	ContentItem		$contentItem
	 * @return	string
	 */
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem);
	
	/**
	 * Returns the searchable content of the given article section object.
	 * 
	 * @param	ArticleSection		$articleSection
	 * @param	Article			$article
	 * @param	ContentItem		$contentItem
	 * @return	string
	 */
	public function getSearchableContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem);
	
	/**
	 * Returns the preview html code of the given article section object.
	 * 
	 * @param	ArticleSection		$articleSection
	 * @param	Article			$article
	 * @param	ContentItem		$contentItem
	 * @return	string
	 */
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem);
	
	// form methods
	/**
	 * Reads the given form parameters.
	 */
	public function readFormParameters();
	
	/**
	 * Validates form inputs.
	 */
	public function validate();
	
	/**
	 * Returns the form data of this article section type.
	 * 
	 * @return	array
	 */
	public function getFormData();
	
	/**
	 * Sets the default form data of this article section type. 
	 *
	 * @param	array		$data
	 */
	public function setFormData($data);
	
	/**
	 * Assigns form variables to the template engine.
	 */
	public function assignVariables();
	
	/**
	 * Returns the name of the template.
	 * 
	 * @return	string
	 */
	public function getFormTemplateName();
}
?>