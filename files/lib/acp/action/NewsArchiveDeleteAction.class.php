<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/news/archive/NewsArchiveEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

/**
 * Deletes a news archive.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.action
 * @category	Infinite Site
 */
class NewsArchiveDeleteAction extends AbstractAction {
	/**
	 * news archive id
	 * 
	 * @var	integer
	 */
	public $newsArchiveID = 0;
	
	/**
	 * news archive editor object
	 * 
	 * @var	NewsArchiveEditor
	 */
	public $newsArchive = null;
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get news archive
		if (isset($_REQUEST['newsArchiveID'])) $this->newsArchiveID = intval($_REQUEST['newsArchiveID']);
		$this->newsArchive = new NewsArchiveEditor($this->newsArchiveID);
		if (!$this->newsArchive->newsArchiveID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// check permission
		WCF::getUser()->checkPermission('admin.site.canDeleteNewsArchive');
		
		// delete news archive
		$this->newsArchive->delete();
		
		// reset cache
		NewsArchiveEditor::resetCache();
		$this->executed();
		
		// forward to list page
		HeaderUtil::redirect('index.php?page=NewsArchiveList&deletedNewsArchiveID='.$this->newsArchiveID.'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>