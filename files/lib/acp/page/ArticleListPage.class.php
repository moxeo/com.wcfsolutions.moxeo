<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/ArticleList.class.php');
require_once(MOXEO_DIR.'lib/data/content/ACPContentItemList.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/MultipleLinkPage.class.php');

/**
 * Shows a list of all articles.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.page
 * @category	Moxeo Open Source CMS
 */
class ArticleListPage extends MultipleLinkPage {
	// system
	public $templateName = 'articleList';

	/**
	 * content item id
	 *
	 * @var	integer
	 */
	public $contentItemID = 0;

	/**
	 * content item editor object
	 *
	 * @var	ContentItemEditor
	 */
	public $contentItem = null;

	/**
	 * content item list object
	 *
	 * @var	ContentItemList
	 */
	public $contentItemList = null;

	/**
	 * article list object
	 *
	 * @var	ArticleList
	 */
	public $articleList = null;

	/**
	 * deleted article id
	 *
	 * @var	integer
	 */
	public $deletedArticleID = 0;

	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		if (isset($_REQUEST['deletedArticleID'])) $this->deletedArticleID = intval($_REQUEST['deletedArticleID']);

		// get content item
		if (isset($_REQUEST['contentItemID'])) $this->contentItemID = intval($_REQUEST['contentItemID']);
		if ($this->contentItemID) {
			$this->contentItem = new ContentItem($this->contentItemID);
			$this->contentItem->checkAdminPermission(array('canEditArticle', 'canDeleteArticle'));

			// init article list
			$this->articleList = new ArticleList();
			$this->articleList->sqlConditions = "article.contentItemID = ".$this->contentItemID;
		}
		else {
			WCF::getUser()->checkPermission(array('admin.moxeo.canEditArticle', 'admin.moxeo.canDeleteArticle'));

			// init content item list
			$this->contentItemList = new ACPContentItemList();
		}
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function readData() {
		parent::readData();

		if ($this->contentItemID) {
			// read articles
			$this->articleList->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
			$this->articleList->sqlLimit = $this->itemsPerPage;
			$this->articleList->sqlOrderBy = 'article.showOrder ASC';
			$this->articleList->readObjects();
		}
		else {
			// read content items
			$this->contentItemList->readContentItems();
		}
	}

	/**
	 * @see	MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();

		if ($this->articleList !== null) {
			return $this->articleList->countObjects();
		}
		return 0;
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'contentItemID' => $this->contentItemID,
			'contentItem' => $this->contentItem,
			'articles' => ($this->articleList !== null ? $this->articleList->getObjects() : null),
			'contentItems' => ($this->contentItemList !== null ? $this->contentItemList->getContentItemList() : null),
			'deletedArticleID' => $this->deletedArticleID
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