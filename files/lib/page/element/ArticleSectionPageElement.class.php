<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/ArticleSection.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/element/AbstractPageElement.class.php');

/**
 * Provides default implementations for article section page elements.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
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
}
?>