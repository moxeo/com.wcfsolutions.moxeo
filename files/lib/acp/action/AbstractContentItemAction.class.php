<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItemEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

/**
 * Provides default implementations for content item actions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.action
 * @category	Moxeo Open Source CMS
 */
abstract class AbstractContentItemAction extends AbstractAction {
	/**
	 * content item id
	 * 
	 * @var	integer
	 */
	public $contentItemID = 0;
	
	/**
	 * content item editor object
	 * 
	 * @var	ContentItemEditor
	 */
	public $contentItem = null;
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get content item
		if (isset($_REQUEST['contentItemID'])) $this->contentItemID = intval($_REQUEST['contentItemID']);
		$this->contentItem = new ContentItemEditor($this->contentItemID);
	}
}
?>