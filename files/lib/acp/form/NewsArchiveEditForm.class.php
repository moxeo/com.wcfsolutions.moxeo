<?php
// wsis imports
require_once(WSIS_DIR.'lib/acp/form/NewsArchiveAddForm.class.php');

/**
 * Shows the news archive edit form.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.form
 * @category	Infinite Site
 */
class NewsArchiveEditForm extends NewsArchiveAddForm {
	// system
	public $activeMenuItem = 'wsis.acp.menu.link.content.newsArchive';
	public $neededPermissions = 'admin.site.canEditNewsArchive';
	
	/**
	 * news archive id
	 * 
	 * @var	integer
	 */
	public $newsArchiveID = 0;
	
	/**
	 * @see	Page::readParameters()
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
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		if (!count($_POST)) {
			// get values
			$this->title = $this->newsArchive->title;
			$this->contentItemID = $this->newsArchive->contentItemID;
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		ACPForm::save();
		
		// update news archive
		$this->newsArchive->update($this->title, $this->contentItemID);
		
		// reset cache
		NewsArchiveEditor::resetCache();
		$this->saved();
		
		// show success message
		WCF::getTPL()->assign('success', true);
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'action' => 'edit',
			'newsArchiveID' => $this->newsArchiveID,
			'newsArchive' => $this->newsArchive
		));
	}
}
?>