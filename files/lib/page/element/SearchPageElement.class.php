<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/news/NewsItem.class.php');
require_once(WSIS_DIR.'lib/data/news/archive/NewsArchive.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/element/ThemeModulePageElement.class.php');

/**
 * Represents a search page element.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	page.element
 * @category	Infinite Site
 */
class SearchPageElement extends ThemeModulePageElement {
	// system
	public $templateName = 'search';
	
	/**
	 * given search query
	 * 
	 * @var	string
	 */
	public $query = '';
	
	/**
	 * list of results
	 * 
	 * @var	array
	 */
	public $result = array();
	
	/**
	 * content item object
	 * 
	 * @var	ContentItem
	 */
	public $contentItem = null;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['q'])) $this->query = StringUtil::trim($_REQUEST['q']);
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// get content item
		if (!isset($this->additionalData['contentItem'])) {
			throw new SystemException('no content item given');
		}
		$this->contentItem = $this->additionalData['contentItem'];
		
		// search
		if ($this->query) {
			$this->result = ContentItem::search($this->query, $this->itemsPerPage, ($this->pageNo - 1) * $this->itemsPerPage);
		}
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'contentItem' => $this->contentItem,
			'result' => $this->result,
			'query' => $this->query
		));
	}
}
?>