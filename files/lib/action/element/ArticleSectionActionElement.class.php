<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/ArticleSection.class.php');

// wcf imports
require_once(WCF_DIR.'lib/action/AbstractSecureAction.class.php');

/**
 * Provides default implementations for article section action elements.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	action.element
 * @category	Moxeo Open Source CMS
 */
abstract class ArticleSectionActionElement extends AbstractSecureAction {
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
	 * Creates a new ArticleSectionActionElement object.
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
	 * Returns the article section object of this action element.
	 *
	 * @return	ArticleSection		The article section object of this action element.
	 */
	public function getArticleSection() {
		return $this->articleSection;
	}

	/**
	 * Returns the article object of this action element.
	 *
	 * @return	Article			The article object of this action element.
	 */
	public function getArticle() {
		return $this->article;
	}

	/**
	 * Returns content item object of this action element.
	 *
	 * @return	ContentItem		The content item object of this action element.
	 */
	public function getContentItem() {
		return $this->contentItem;
	}
}
?>