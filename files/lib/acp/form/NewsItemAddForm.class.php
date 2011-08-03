<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/news/NewsItemEditor.class.php');
require_once(WSIS_DIR.'lib/data/news/archive/NewsArchiveEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');

/**
 * Shows the news item add form.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.form
 * @category	Infinite Site
 */
class NewsItemAddForm extends ACPForm {
	// system
	public $templateName = 'newsItemAdd';
	public $activeMenuItem = 'wsis.acp.menu.link.content.newsItem.add';
	public $neededPermissions = 'admin.site.canAddNewsItem';
	
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
	 * news item editor object
	 * 
	 * @var	NewsItemEditor
	 */
	public $newsItem = null;
	
	/**
	 * user id
	 * 
	 * @var	integer
	 */
	public $userID = 0;
	
	/**
	 * publishing start time
	 * 
	 * @var	integer
	 */
	public $publishingStartTime = 0;
	
	/**
	 * publishing end time
	 * 
	 * @var	integer
	 */
	public $publishingEndTime = 0;
	
	// parameters
	public $username = '';
	public $title = '';
	public $newsItemAlias = '';
	public $teaser = '';
	public $text = '';
	public $cssID = '';
	public $cssClasses = '';
	public $publishingStartTimeDay = '';
	public $publishingStartTimeMonth = '';
	public $publishingStartTimeYear = '';
	public $publishingStartTimeHour = '';
	public $publishingStartTimeMinutes = '';
	public $publishingEndTimeDay = '';
	public $publishingEndTimeMonth = '';
	public $publishingEndTimeYear = '';
	public $publishingEndTimeHour = '';
	public $publishingEndTimeMinutes = '';
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get news archive
		if (isset($_REQUEST['newsArchiveID'])) $this->newsArchiveID = intval($_REQUEST['newsArchiveID']);
		if ($this->newsArchiveID) {
			$this->newsArchive = new NewsArchiveEditor($this->newsArchiveID);
		}
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// default values
		if (!count($_POST)) {
			$this->username = WCF::getUser()->username;
		}
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['username'])) $this->username = StringUtil::trim($_POST['username']);
		if (isset($_POST['title'])) $this->title = StringUtil::trim($_POST['title']);
		if (isset($_POST['newsItemAlias'])) $this->newsItemAlias = StringUtil::trim($_POST['newsItemAlias']);
		if (isset($_POST['teaser'])) $this->teaser = StringUtil::trim($_POST['teaser']);
		if (isset($_POST['text'])) $this->text = StringUtil::trim($_POST['text']);
		if (isset($_POST['cssID'])) $this->cssID = StringUtil::trim($_POST['cssID']);
		if (isset($_POST['cssClasses'])) $this->cssClasses = StringUtil::trim($_POST['cssClasses']);
		
		// publishing start time
		if (isset($_POST['publishingStartTimeDay'])) $this->publishingStartTimeDay = intval($_POST['publishingStartTimeDay']);
		if (isset($_POST['publishingStartTimeMonth'])) $this->publishingStartTimeMonth = intval($_POST['publishingStartTimeMonth']);
		if (!empty($_POST['publishingStartTimeYear'])) $this->publishingStartTimeYear = intval($_POST['publishingStartTimeYear']);
		if (isset($_POST['publishingStartTimeHour'])) $this->publishingStartTimeHour = intval($_POST['publishingStartTimeHour']);
		if (isset($_POST['publishingStartTimeMinutes'])) $this->publishingStartTimeMinutes = intval($_POST['publishingStartTimeMinutes']);
		
		// publishing end time
		if (isset($_POST['publishingEndTimeDay'])) $this->publishingEndTimeDay = intval($_POST['publishingEndTimeDay']);
		if (isset($_POST['publishingEndTimeMonth'])) $this->publishingEndTimeMonth = intval($_POST['publishingEndTimeMonth']);
		if (!empty($_POST['publishingEndTimeYear'])) $this->publishingEndTimeYear = intval($_POST['publishingEndTimeYear']);
		if (isset($_POST['publishingEndTimeHour'])) $this->publishingEndTimeHour = intval($_POST['publishingEndTimeHour']);
		if (isset($_POST['publishingEndTimeMinutes'])) $this->publishingEndTimeMinutes = intval($_POST['publishingEndTimeMinutes']);
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// username
		if (empty($this->username)) {
			throw new UserInputException('username');
		}
		
		$user = new UserSession(null, null, $this->username);
		if (!$user->userID) {
			throw new UserInputException('username', 'notFound');
		}
		$this->userID = $user->userID;
		
		// title
		if (empty($this->title)) {
			throw new UserInputException('title');
		}
		
		// alias
		if (!$this->newsItemAlias) $this->newsItemAlias = $this->title;
		$this->newsItemAlias = SEOUtil::formatString($this->newsItemAlias);
		
		// teaser
		if (empty($this->teaser)) {
			throw new UserInputException('teaser');
		}
		
		// text
		if (empty($this->text)) {
			throw new UserInputException('text');
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		// save news item
		$this->newsItem = NewsItemEditor::create($this->newsArchiveID, $this->userID, $this->title, $this->newsItemAlias, $this->teaser, $this->text, $this->cssID, $this->cssClasses, $this->publishingStartTime, $this->publishingEndTime);
		$this->saved();
		
		// reset values
		$this->title = $this->newsItemAlias = $this->teaser = $this->text = $this->cssID = $this->cssClasses =
		$this->publishingStartTimeDay = $this->publishingStartTimeMonth = $this->publishingStartTimeYear = $this->publishingStartTimeHour = $this->publishingStartTimeMinutes =
		$this->publishingEndTimeDay = $this->publishingEndTimeMonth = $this->publishingEndTimeYear = $this->publishingEndTimeHour = $this->publishingEndTimeMinutes = '';
		$this->username = WCF::getUser()->username;
		
		// show success message
		WCF::getTPL()->assign('success', true);
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		require_once(WCF_DIR.'lib/page/util/InlineCalendar.class.php');
		InlineCalendar::assignVariables();
		
		WCF::getTPL()->assign(array(
			'action' => 'add',
			'newsArchiveID' => $this->newsArchiveID,
			'newsArchive' => $this->newsArchive,
			'username' => $this->username,
			'title' => $this->title,
			'newsItemAlias' => $this->newsItemAlias,
			'teaser' => $this->teaser,
			'text' => $this->text,
			'cssID' => $this->cssID,
			'cssClasses' => $this->cssClasses,
			'publishingStartTimeDay' => $this->publishingStartTimeDay,
			'publishingStartTimeMonth' => $this->publishingStartTimeMonth,
			'publishingStartTimeYear' => $this->publishingStartTimeYear,
			'publishingStartTimeHour' => $this->publishingStartTimeHour,
			'publishingStartTimeMinutes' => $this->publishingStartTimeMinutes,
			'publishingEndTimeDay' => $this->publishingEndTimeDay,
			'publishingEndTimeMonth' => $this->publishingEndTimeMonth,
			'publishingEndTimeYear' => $this->publishingEndTimeYear,
			'publishingEndTimeHour' => $this->publishingEndTimeHour,
			'publishingEndTimeMinutes' => $this->publishingEndTimeMinutes,
			'newsArchiveOptions' => NewsArchive::getNewsArchives()
		));
	}
}
?>