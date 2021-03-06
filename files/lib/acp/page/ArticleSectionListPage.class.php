<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/Article.class.php');
require_once(MOXEO_DIR.'lib/data/article/section/ArticleSectionList.class.php');
require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/MultipleLinkPage.class.php');

/**
 * Shows a list of all article sections.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.page
 * @category	Moxeo Open Source CMS
 */
class ArticleSectionListPage extends MultipleLinkPage {
	// system
	public $templateName = 'articleSectionList';

	/**
	 * article id
	 *
	 * @var	integer
	 */
	public $articleID = 0;

	/**
	 * article object
	 *
	 * @var	Article
	 */
	public $article = null;

	/**
	 * content item editor object
	 *
	 * @var	ContentItemEditor
	 */
	public $contentItem = null;

	/**
	 * article section list object
	 *
	 * @var	ArticleSectionList
	 */
	public $articleSectionList = null;

	/**
	 * deleted article id
	 *
	 * @var	integer
	 */
	public $deletedArticleSectionID = 0;

	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		if (isset($_REQUEST['deletedArticleSectionID'])) $this->deletedArticleSectionID = intval($_REQUEST['deletedArticleSectionID']);

		// get article
		if (isset($_REQUEST['articleID'])) $this->articleID = intval($_REQUEST['articleID']);
		$this->article = new Article($this->articleID);
		if (!$this->article->articleID) {
			throw new IllegalLinkException();
		}

		// get content item
		$this->contentItem = new ContentItem($this->article->contentItemID);
		$this->contentItem->checkAdminPermission('canEditArticle');

		// init article section list
		$this->articleSectionList = new ArticleSectionList();
		$this->articleSectionList->sqlConditions = "article_section.articleID = ".$this->articleID;
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function readData() {
		parent::readData();

		// read article sections
		$this->articleSectionList->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
		$this->articleSectionList->sqlLimit = $this->itemsPerPage;
		$this->articleSectionList->sqlOrderBy = 'article_section.showOrder ASC';
		$this->articleSectionList->readObjects();
	}

	/**
	 * @see	MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();

		return $this->articleSectionList->countObjects();
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'articleID' => $this->articleID,
			'article' => $this->article,
			'contentItem' => $this->contentItem,
			'articleSections' => $this->articleSectionList->getObjects(),
			'deletedArticleSectionID' => $this->deletedArticleSectionID
		));
	}

	/**
	 * @see	Page::show()
	 */
	public function show() {
		// enable menu item
		WCFACP::getMenu()->setActiveMenuItem('moxeo.acp.menu.link.content.article.view');

		parent::show();
	}
}
?>