<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/HeadlineArticleSectionType.class.php');

/**
 * Represents a image article section type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
class ImageArticleSectionType extends HeadlineArticleSectionType {
	/**
	 * @see	HeadlineArticleSectionType::$requireHeadline
	 */
	public $requireHeadline = false;

	// display methods
	/**
	 * @see	ArticleSectionType::getContent()
	 */
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		$path = FileManagerUtil::getPath($articleSection->image);
		WCF::getTPL()->assign(array(
			'articleSection' => $articleSection,
			'file' => FileManagerUtil::getFileInfo($path)
		));
		return WCF::getTPL()->fetch('imageArticleSectionType');
	}

	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		// get headline
		$headline = parent::getPreviewHTML($articleSection, $article, $contentItem);

		// prepare image preview
		$image = '<img src="'.RELATIVE_MOXEO_DIR.'files/'.$articleSection->image.'" alt="'.$articleSection->alternativeTitle.'" />';

		// return preview
		return $headline.$image;
	}

	// form methods
	/**
	 * @see	ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		$this->formData['image'] = $this->formData['caption'] = $this->formData['alternativeTitle'] = $this->formData['url'] = '';
		$this->formData['enableFullsize'] = 0;

		if (isset($_POST['image'])) $this->formData['image'] = StringUtil::trim($_POST['image']);
		if (isset($_POST['caption'])) $this->formData['caption'] = StringUtil::trim($_POST['caption']);
		if (isset($_POST['alternativeTitle'])) $this->formData['alternativeTitle'] = StringUtil::trim($_POST['alternativeTitle']);
		if (isset($_POST['url'])) $this->formData['url'] = StringUtil::trim($_POST['url']);
		if (isset($_POST['enableFullsize'])) $this->formData['enableFullsize'] = intval($_POST['enableFullsize']);
	}

	/**
	 * @see	ArticleSectionType::validate()
	 */
	public function validate() {
		parent::validate();

		if (empty($this->formData['image'])) {
			throw new UserInputException('image');
		}

		$path = FileManagerUtil::getPath($this->formData['image']);

		// check image content
		if (!ImageUtil::checkImageContent($path)) {
			throw new UserInputException('images', 'badImage');
		}

		// get image data
		if (($imageData = @getImageSize($path)) === false) {
			throw new UserInputException('images', 'badImage');
		}

		// get image size
		$width = $imageData[0];
		$height = $imageData[1];
		if (!$width || !$height) {
			throw new UserInputException('images', 'badImage');
		}
	}

	/**
	 * @see	ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'image' => (isset($this->formData['image']) ? $this->formData['image'] : ''),
			'caption' => (isset($this->formData['caption']) ? $this->formData['caption'] : ''),
			'alternativeTitle' => (isset($this->formData['alternativeTitle']) ? $this->formData['alternativeTitle'] : ''),
			'url' => (isset($this->formData['url']) ? $this->formData['url'] : ''),
			'enableFullsize' => (isset($this->formData['enableFullsize']) ? $this->formData['enableFullsize'] : 0)
		));
	}

	/**
	 * @see	ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'imageArticleSectionType';
	}
}
?>