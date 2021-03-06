<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/AbstractArticleSectionType.class.php');

/**
 * Represents a headline article section type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
class HeadlineArticleSectionType extends AbstractArticleSectionType {
	/**
	 * Returns whether the headline should be shown.
	 *
	 * @return	boolean		True, if the headline should be shown.
	 */
	public function requireHeadline() {
		return true;
	}

	// display methods
	/**
	 * @see	ArticleSectionType::getContent()
	 */
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		WCF::getTPL()->assign('articleSection', $articleSection);
		return WCF::getTPL()->fetch('headlineArticleSectionType');
	}

	/**
	 * @see	ArticleSectionType::getSearchableContent()
	 */
	public function getSearchableContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return $articleSection->headline;
	}

	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return ($articleSection->headline ? '<h3>'.StringUtil::encodeHTML($articleSection->headline).'</h3>' : '');
	}

	// form methods
	/**
	 * @see	ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {
		$this->formData['headline'] = '';
		$this->formData['headlineSize'] = 1;

		if (isset($_POST['headline'])) $this->formData['headline'] = StringUtil::trim($_POST['headline']);
		if (isset($_POST['headlineSize'])) $this->formData['headlineSize'] = intval($_POST['headlineSize']);
	}

	/**
	 * @see	ArticleSectionType::validate()
	 */
	public function validate() {
		// headline
		if ($this->requireHeadline()) {
			if (empty($this->formData['headline'])) {
				throw new UserInputException('headline');
			}
		}

		// headline size
		if ($this->formData['headlineSize'] < 1 || $this->formData['headlineSize'] > 6) {
			throw new UserInputException('headlineSize');
		}
	}

	/**
	 * @see	ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {
		WCF::getTPL()->assign(array(
			'headline' => (isset($this->formData['headline']) ? $this->formData['headline'] : ''),
			'headlineSize' => (isset($this->formData['headlineSize']) ? $this->formData['headlineSize'] : 1)
		));
	}

	/**
	 * @see	ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'headlineArticleSectionType';
	}
}
?>