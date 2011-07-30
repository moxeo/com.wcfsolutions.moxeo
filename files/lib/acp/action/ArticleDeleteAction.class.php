<?php
// wsis imports
require_once(WSIS_DIR.'lib/acp/action/AbstractArticleAction.class.php');

/**
 * Deletes an article.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.action
 * @category	Infinite Site
 */
class ArticleDeleteAction extends AbstractArticleAction {
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// check permission
		$this->contentItem->checkAdminPermission('canDeleteArticle');
		
		// delete article
		$this->article->delete();
		
		// reset cache
		WCF::getCache()->clearResource('contentItemArticles');
		$this->executed();
		
		// forward to list page
		HeaderUtil::redirect('index.php?page=ArticleList&contentItemID='.$this->article->contentItemID.'&deletedArticleID='.$this->articleID.'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>