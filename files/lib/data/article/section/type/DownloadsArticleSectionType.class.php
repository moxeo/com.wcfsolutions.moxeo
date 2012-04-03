<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/HeadlineArticleSectionType.class.php');

/**
 * Represents a downloads article section type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
class DownloadsArticleSectionType extends HeadlineArticleSectionType {
	/**
	 * @see	HeadlineArticleSectionType::$requireHeadline
	 */
	public $requireHeadline = false;

	// display methods
	/**
	 * @see	ArticleSectionType::getContent()
	 */
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		$files = array();

		// get files
		foreach ($articleSection->files as $file) {
			$path = FileManagerUtil::getPath($file);
			$files[] = array(
				'path' => $file,
				'info' => FileManagerUtil::getFileInfo($path)
			);
		}

		WCF::getTPL()->assign(array(
			'files' => $files
		));
		return WCF::getTPL()->fetch('downloadsArticleSectionType');
	}

	// form methods
	/**
	 * @see	ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		$this->formData['files'] = array();
		if (isset($_POST['files']) && is_array($_POST['files'])) $this->formData['files'] = $_POST['files'];
	}

	/**
	 * @see	ArticleSectionType::validate()
	 */
	public function validate() {
		parent::validate();

		if (!count($this->formData['files'])) {
			throw new UserInputException('files');
		}

		// validate files
		$errors = array();
		foreach ($this->formData['files'] as $file) {
			try {
				$path = FileManagerUtil::getPath($file);

				if (!file_exists($path) || !is_file($path)) {
					throw new UserInputException('files', 'invalid');
				}
			}
			catch (UserInputException $e) {
				$errors[] = array('errorType' => $e->getType(), 'filename' => basename($file));
			}
		}

		// show error message
		if (count($errors)) {
			throw new UserInputException('files', $errors);
		}
	}

	/**
	 * @see	ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'files' => (isset($this->formData['files']) ? $this->formData['files'] : array())
		));
	}

	/**
	 * @see	ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'downloadsArticleSectionType';
	}
}
?>