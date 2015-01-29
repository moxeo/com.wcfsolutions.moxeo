<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/ArticleSection.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/element/AbstractPageElement.class.php');

/**
 * Provides default implementations for article section page elements.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	page.element
 * @category	Moxeo Open Source CMS
 */
abstract class ArticleSectionPageElement extends AbstractPageElement {
	/**
	 * article section object
	 *
	 * @var	ArticleSection
	 */
	private $articleSection = null;

	/**
	 * article object
	 *
	 * @var	Article
	 */
	private $article = null;

	/**
	 * content item object
	 *
	 * @var	ContentItem
	 */
	private $contentItem = null;

	/**
	 * Creates a new ArticleSectionPageElement object.
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
	 * @see	PageElement::getIdentifier()
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

	/**
	 * Returns the article section object of this page element.
	 *
	 * @return	ArticleSection		The article section object of this page element.
	 */
	public function getArticleSection() {
		return $this->articleSection;
	}

	/**
	 * Returns the article object of this page element.
	 *
	 * @return	Article			The article object of this page element.
	 */
	public function getArticle() {
		return $this->article;
	}

	/**
	 * Returns content item object of this page element.
	 *
	 * @return	ContentItem		The content item object of this page element.
	 */
	public function getContentItem() {
		return $this->contentItem;
	}
}
?>