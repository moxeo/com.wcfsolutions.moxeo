<?php
// wsis imports
require_once(WSIS_DIR.'lib/acp/action/AbstractArticleAction.class.php');

/**
 * Sorts the structure of articles.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.action
 * @category	Infinite Site
 */
class ArticleSortAction extends AbstractArticleAction {
	/**
	 * new show order
	 *
	 * @var integer
	 */
	public $showOrder = 0;
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get show order
		if (isset($_REQUEST['showOrder'])) $this->showOrder = intval($_REQUEST['showOrder']);
	}
	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// check permission
		$this->contentItem->checkAdminPermission('canEditArticle');
		
		// update show order
		$this->article->updateShowOrder($this->showOrder);
		$this->executed();
		exit;
	}
}
?>