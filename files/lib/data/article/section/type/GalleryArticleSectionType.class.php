<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/HeadlineArticleSectionType.class.php');

/**
 * Represents a gallery article section type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
class GalleryArticleSectionType extends HeadlineArticleSectionType {
	/**
	 * @see	HeadlineArticleSectionType::$requireHeadline
	 */
	public $requireHeadline = false;

	// display methods
	/**
	 * @see	ArticleSectionType::getContent()
	 */
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		$images = array();

		// get images
		foreach ($articleSection->images as $image) {
			$path = FileManagerUtil::getPath($image);
			$images[] = array(
				'path' => $image,
				'info' => FileManagerUtil::getFileInfo($path)
			);
		}

		WCF::getTPL()->assign(array(
			'images' => $images
		));
		return WCF::getTPL()->fetch('galleryArticleSectionType');
	}

	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		// get headline
		$headline = parent::getPreviewHTML($articleSection, $article, $contentItem);

		// prepare gallery preview
		$gallery = '<ul class="images">';
		foreach ($articleSection->images as $image) {
			$gallery .= '<li class="image"><img src="'.RELATIVE_MOXEO_DIR.'files/'.$image.'" alt="" /></li>';
		}
		$gallery .= '</ul>';

		// return preview
		return $headline.$gallery;
	}

	// form methods
	/**
	 * @see	ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		$this->formData['images'] = array();
		if (isset($_POST['images']) && is_array($_POST['images'])) $this->formData['images'] = $_POST['images'];
	}

	/**
	 * @see	ArticleSectionType::validate()
	 */
	public function validate() {
		parent::validate();

		if (!count($this->formData['images'])) {
			throw new UserInputException('images');
		}

		// validate images
		$errors = array();
		foreach ($this->formData['images'] as $image) {
			try {
				$path = FileManagerUtil::getPath($image);

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
			catch (UserInputException $e) {
				$errors[] = array('errorType' => $e->getType(), 'filename' => basename($image));
			}
		}

		// show error message
		if (count($errors)) {
			throw new UserInputException('images', $errors);
		}
	}

	/**
	 * @see	ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'images' => (isset($this->formData['images']) ? $this->formData['images'] : array())
		));
	}

	/**
	 * @see	ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'galleryArticleSectionType';
	}
}
?>