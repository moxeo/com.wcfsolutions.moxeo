<?php
// wsis imports
require_once(WSIS_DIR.'lib/acp/action/AbstractArticleSectionAction.class.php');

/**
 * Sorts the structure of article sections.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.action
 * @category	Infinite Site
 */
class ArticleSectionSortAction extends AbstractArticleSectionAction {
	/**
	 * new show order
	 *
	 * @var integer
	 */
	public $showOrder = 0;
	
	/**
	 * @see Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get show order
		if (isset($_REQUEST['showOrder'])) $this->showOrder = intval($_REQUEST['showOrder']);
	}
	
	/**
	 * @see Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// check permission
		$this->contentItem->checkAdminPermission('canEditArticle');
		
		// update show order
		$this->articleSection->updateShowOrder($this->showOrder);
		$this->executed();
		exit;
	}
}
?>