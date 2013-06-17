<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/AbstractArticleSectionType.class.php');

/**
 * Represents a viewable article section type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
abstract class ViewableArticleSectionType extends AbstractArticleSectionType {
	/**
	 * list of page elements
	 *
	 * @var	array<PageElement>
	 */
	public $pageElements = array();

	/**
	 * page element
	 *
	 * @var	string
	 */
	public $pageElement = '';

	/**
	 * page element type (page/form/action)
	 *
	 * @var	string
	 */
	public $pageElementType = 'page';

	/**
	 * @see	ArticleSectionType::cache()
	 */
	public function cache(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		$className = ucfirst($this->pageElement).ucfirst($this->pageElementType).'Element';
		$path = MOXEO_DIR.'lib/'.$this->pageElementType.'/element/'.$className.'.class.php';

		// include class file
		if (!class_exists($className)) {
			if (!file_exists($path)) {
				throw new SystemException("Unable to find class file '".$path."'", 11000);
			}
			require_once($path);
		}

		$this->pageElements[$articleSection->articleSectionID] = new $className($articleSection, $article, $contentItem);
	}

	/**
	 * @see	ArticleSectionType::getContent()
	 */
	public function hasContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		if ($this->pageElementType != 'action' && $this->pageElements[$articleSection->articleSectionID]->getContent()) {
			return true;
		}
		return false;
	}

	/**
	 * @see	ArticleSectionType::getContent()
	 */
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		if ($this->pageElementType != 'action') {
			return $this->pageElements[$articleSection->articleSectionID]->getContent();
		}
		return '';
	}
}
?>