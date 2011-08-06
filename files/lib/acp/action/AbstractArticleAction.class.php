<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/ArticleEditor.class.php');
require_once(WSIS_DIR.'lib/data/content/ContentItemEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

/**
 * Provides default implementations for article actions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.action
 * @category	Infinite Site
 */
abstract class AbstractArticleAction extends AbstractAction {
	/**
	 * article id
	 * 
	 * @var	integer
	 */
	public $articleID = 0;
	
	/**
	 * article editor object
	 * 
	 * @var	ArticleEditor
	 */
	public $article = null;
	
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
		
		// get article
		if (isset($_REQUEST['articleID'])) $this->articleID = intval($_REQUEST['articleID']);
		$this->article = new ArticleEditor($this->articleID);
		if (!$this->article->articleID) {
			throw new IllegalLinkException();
		}
		
		// get content item
		$this->contentItem = new ContentItemEditor($this->article->contentItemID);
	}
}
?>