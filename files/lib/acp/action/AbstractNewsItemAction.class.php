<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/news/NewsItemEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

/**
 * Provides default implementations for news item actions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.action
 * @category	Moxeo Open Source CMS
 */
abstract class AbstractNewsItemAction extends AbstractAction {
	/**
	 * news item id
	 * 
	 * @var	integer
	 */
	public $newsItemID = 0;
	
	/**
	 * news item editor object
	 * 
	 * @var	NewsItemEditor
	 */
	public $newsItem = null;
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get news item
		if (isset($_REQUEST['newsItemID'])) $this->newsItemID = intval($_REQUEST['newsItemID']);
		$this->newsItem = new NewsItemEditor($this->newsItemID);
		if (!$this->newsItem->newsItemID) {
			throw new IllegalLinkException();
		}
	}
}
?>