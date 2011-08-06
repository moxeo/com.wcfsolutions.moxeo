<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/ArticleEditor.class.php');
require_once(WSIS_DIR.'lib/data/article/section/ArticleSectionEditor.class.php');
require_once(WSIS_DIR.'lib/data/content/ContentItemEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

/**
 * Provides default implementations for article section actions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.action
 * @category	Infinite Site
 */
abstract class AbstractArticleSectionAction extends AbstractAction {
	/**
	 * article section id
	 * 
	 * @var	integer
	 */
	public $articleSectionID = 0;
	
	/**
	 * article section editor object
	 * 
	 * @var	ArticleSectionEditor
	 */
	public $articleSection = null;
	
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
		
		// get article section
		if (isset($_REQUEST['articleSectionID'])) $this->articleSectionID = intval($_REQUEST['articleSectionID']);
		$this->articleSection = new ArticleSectionEditor($this->articleSectionID);
		if (!$this->articleSection->articleSectionID) {
			throw new IllegalLinkException();
		}
		
		// get article
		$this->article = new ArticleEditor($this->articleSection->articleID);
		
		// get content item
		$this->contentItem = new ContentItemEditor($this->article->contentItemID);
	}
}
?>