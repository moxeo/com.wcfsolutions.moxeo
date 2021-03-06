<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/HeadlineArticleSectionType.class.php');

/**
 * Represents a file article section type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
class DownloadArticleSectionType extends HeadlineArticleSectionType {
	/**
	 * @see	HeadlineArticleSectionType::requireHeadline()
	 */
	public function requireHeadline() {
		return false;
	}

	// display methods
	/**
	 * @see	ArticleSectionType::getContent()
	 */
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		$path = FileManagerUtil::getPath($articleSection->file);
		WCF::getTPL()->assign(array(
			'articleSection' => $articleSection,
			'file' => FileManagerUtil::getFileInfo($path)
		));
		return WCF::getTPL()->fetch('downloadArticleSectionType');
	}

	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		// get headline
		$headline = parent::getPreviewHTML($articleSection, $article, $contentItem);

		// get filename
		$filename = basename($articleSection->file);

		// return preview
		return $headline.$filename;
	}

	// form methods
	/**
	 * @see	ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		$this->formData['file'] = $this->formData['caption'] = '';

		if (isset($_POST['file'])) $this->formData['file'] = StringUtil::trim($_POST['file']);
		if (isset($_POST['caption'])) $this->formData['caption'] = StringUtil::trim($_POST['caption']);
	}

	/**
	 * @see	ArticleSectionType::validate()
	 */
	public function validate() {
		parent::validate();

		if (empty($this->formData['file'])) {
			throw new UserInputException('file');
		}

		$path = FileManagerUtil::getPath($this->formData['file']);
		if (!file_exists($path) || !is_file($path)) {
			throw new UserInputException('file', 'invalid');
		}
	}

	/**
	 * @see	ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'file' => (isset($this->formData['file']) ? $this->formData['file'] : ''),
			'caption' => (isset($this->formData['caption']) ? $this->formData['caption'] : '')
		));
	}

	/**
	 * @see	ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'downloadArticleSectionType';
	}
}
?>