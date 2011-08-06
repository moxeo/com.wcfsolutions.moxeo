<?php
// wsis imports
require_once(WSIS_DIR.'lib/acp/form/NewsItemAddForm.class.php');

/**
 * Shows the news item edit form.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.form
 * @category	Infinite Site
 */
class NewsItemEditForm extends NewsItemAddForm {
	// system
	public $activeMenuItem = 'wsis.acp.menu.link.content.newsItem';
	public $neededPermissions = 'admin.site.canEditNewsItem';
	
	/**
	 * news item id
	 * 
	 * @var	integer
	 */
	public $newsItemID = 0;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		ACPForm::readParameters();
		
		// get news item
		if (isset($_REQUEST['newsItemID'])) $this->newsItemID = intval($_REQUEST['newsItemID']);
		$this->newsItem = new NewsItemEditor($this->newsItemID);
		if (!$this->newsItem->newsItemID) {
			throw new IllegalLinkException();
		}
		
		// get news archive
		$this->newsArchive = new NewsArchiveEditor($this->newsItem->newsArchiveID);
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		if (!count($_POST)) {
			// get values
			$this->title = $this->newsItem->title;
			$this->newsItemAlias = $this->newsItem->newsItemAlias;
			$this->teaser = $this->newsItem->teaser;
			$this->text = $this->newsItem->text;
			$this->cssID = $this->newsItem->cssID;
			$this->cssClasses = $this->newsItem->cssClasses;
			
			// username
			$user = new UserSession($this->newsItem->userID);
			if ($user->userID) {
				$this->username = $user->username;
			}
			
			// publishing start time
			if ($this->newsItem->publishingStartTime) {
				$this->publishingStartTimeDay = intval(DateUtil::formatDate('%e', $this->newsItem->publishingStartTime, false, true));
				$this->publishingStartTimeMonth = intval(DateUtil::formatDate('%m', $this->newsItem->publishingStartTime, false, true));
				$this->publishingStartTimeYear = DateUtil::formatDate('%Y', $this->newsItem->publishingStartTime, false, true);
				$this->publishingStartTimeHour = DateUtil::formatDate('%H', $this->newsItem->publishingStartTime, false, true);
				$this->publishingStartTimeMinutes = DateUtil::formatDate('%M', $this->newsItem->publishingStartTime, false, true);
			}
			
			// publishing end time
			if ($this->newsItem->publishingEndTime) {
				$this->publishingEndTimeDay = intval(DateUtil::formatDate('%e', $this->newsItem->publishingEndTime, false, true));
				$this->publishingEndTimeMonth = intval(DateUtil::formatDate('%m', $this->newsItem->publishingEndTime, false, true));
				$this->publishingEndTimeYear = DateUtil::formatDate('%Y', $this->newsItem->publishingEndTime, false, true);
				$this->publishingEndTimeHour = DateUtil::formatDate('%H', $this->newsItem->publishingEndTime, false, true);
				$this->publishingEndTimeMinutes = DateUtil::formatDate('%M', $this->newsItem->publishingEndTime, false, true);
			}
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		ACPForm::save();
		
		// update news item
		$this->newsItem->update($this->userID, $this->title, $this->newsItemAlias, $this->teaser, $this->text, $this->cssID, $this->cssClasses, $this->publishingStartTime, $this->publishingEndTime);
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
			'newsItemID' => $this->newsItemID,
			'newsItem' => $this->newsItem
		));
	}
}
?>