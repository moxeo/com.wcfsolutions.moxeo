<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/HeadlineArticleSectionType.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/ThemeModule.class.php');

/**
 * Represents a theme module article section type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
class ThemeModuleArticleSectionType extends HeadlineArticleSectionType {
	/**
	 * @see	HeadlineArticleSectionType::$requireHeadline
	 */
	public $requireHeadline = false;

	/**
	 * list of theme modules
	 *
	 * @var	array<ThemeModule>
	 */
	public $themeModules = array();

	/**
	 * @see	ArticleSectionType::cache()
	 */
	public function cache(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		if (!isset($this->themeModules[$articleSection->themeModuleID])) {
			$this->themeModules[$articleSection->themeModuleID] = ThemeModule::getThemeModule($articleSection->themeModuleID);
		}
		$themeModule = $this->themeModules[$articleSection->themeModuleID];
		$themeModule->getThemeModuleType()->cache($themeModule, $article->themeModulePosition, array('contentItem' => $contentItem));
	}

	/**
	 * @see	ArticleSectionType::hasContent()
	 */
	public function hasContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		$themeModule = $this->themeModules[$articleSection->themeModuleID];
		return $themeModule->getThemeModuleType()->hasContent($themeModule, $article->themeModulePosition, array('contentItem' => $contentItem));
	}

	/**
	 * @see	ArticleSectionType::getContent()
	 */
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		WCF::getTPL()->assign(array(
			'articleSection' => $articleSection,
			'themeModule' => $this->themeModules[$articleSection->themeModuleID],
			'additionalData' => array('contentItem' => $contentItem)
		));
		return WCF::getTPL()->fetch('themeModuleArticleSectionType');
	}

	/**
	 * @see	ArticleSectionType::getSearchableContent()
	 */
	public function getSearchableContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		$themeModule = ThemeModule::getThemeModule($articleSection->themeModuleID);
		return $themeModule->getThemeModuleType()->getSearchableContent($themeModule, $article->themeModulePosition, array('contentItem' => $contentItem));
	}

	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		$themeModule = ThemeModule::getThemeModule($articleSection->themeModuleID);
		return $themeModule->getThemeModuleType()->getPreviewHTML($themeModule);
	}

	// form methods
	/**
	 * @see	ThemeModuleType::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		$this->formData['themeModuleID'] = 0;
		if (isset($_POST['themeModuleID'])) $this->formData['themeModuleID'] = intval($_POST['themeModuleID']);
	}

	/**
	 * @see	ThemeModuleType::validate()
	 */
	public function validate() {
		parent::validate();

		try {
			$themeModule = ThemeModule::getThemeModule($this->formData['themeModuleID']);
		}
		catch (IllegalLinkException $e) {
			throw new UserInputException('themeModuleID', 'invalid');
		}

		if ($themeModule->themeModuleType == 'article') {
			throw new UserInputException('themeModuleID', 'invalid');
		}
	}

	/**
	 * @see	ThemeModuleType::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'themeModuleID' => (isset($this->formData['themeModuleID']) ? $this->formData['themeModuleID'] : 0),
			'themeModuleOptions' => ThemeModule::getThemeModuleOptions(0, array('article'))
		));
	}

	/**
	 * @see	ThemeModuleType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'themeModuleArticleSectionType';
	}
}
?>