<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/acp/form/ArticleAddForm.class.php');

/**
 * Shows the article edit form.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.form
 * @category	Moxeo Open Source CMS
 */
class ArticleEditForm extends ArticleAddForm {
	// system
	public $activeMenuItem = 'moxeo.acp.menu.link.content.article';

	/**
	 * article id
	 *
	 * @var	integer
	 */
	public $articleID = 0;

	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		ACPForm::readParameters();

		// get article
		if (isset($_REQUEST['articleID'])) $this->articleID = intval($_REQUEST['articleID']);
		$this->article = new ArticleEditor($this->articleID);
		if (!$this->article->articleID) {
			throw new IllegalLinkException();
		}

		// get content item
		$this->contentItem = new ContentItemEditor($this->article->contentItemID);
		if ($this->contentItem->isRoot() || $this->contentItem->isExternalLink()) {
			throw new IllegalLinkException();
		}
		$this->contentItem->checkAdminPermission('canEditArticle');
	}

	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();

		// default values
		if (!count($_POST)) {
			$this->themeModulePosition = $this->article->themeModulePosition;
			$this->title = $this->article->title;
			$this->cssID = $this->article->cssID;
			$this->cssClasses = $this->article->cssClasses;
			$this->showOrder = $this->article->showOrder;
		}
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'action' => 'edit',
			'articleID' => $this->articleID
		));
	}

	/**
	 * @see	Form::save()
	 */
	public function save() {
		AbstractForm::save();

		// update article
		$this->article->update($this->themeModulePosition, $this->title, $this->cssID, $this->cssClasses, $this->showOrder);
		$this->saved();

		// show success message
		WCF::getTPL()->assign('success', true);
	}
}
?>