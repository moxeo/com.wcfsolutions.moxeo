<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/acp/action/AbstractArticleSectionAction.class.php');

/**
 * Deletes an article section.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.action
 * @category	Moxeo Open Source CMS
 */
class ArticleSectionDeleteAction extends AbstractArticleSectionAction {
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// check permission
		$this->contentItem->checkAdminPermission('canEditArticle');
		
		// delete article section
		$this->articleSection->delete();
		$this->executed();
		
		// forward to list page
		HeaderUtil::redirect('index.php?page=ArticleSectionList&articleID='.$this->articleSection->articleID.'&deletedArticleSectionID='.$this->articleSectionID.'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>