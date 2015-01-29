<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/HeadlineArticleSectionType.class.php');

/**
 * Represents a you tube article section type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
class YouTubeArticleSectionType extends HeadlineArticleSectionType {
	/**
	 * @see	HeadlineArticleSectionType::requireHeadline()
	 */
	public function requireHeadline() {
		return false;
	}

	// display methods
	/**
	 * Returns the video html code of the article section.
	 *
	 * @param	ArticleSection	$articleSection
	 * @param	int		$width
	 * @param	int		$height
	 * @return	string
	 */
	protected function getVideoHTML(ArticleSection $articleSection, $width = 425, $height = 344) {
		// get video id
		$videoID = $articleSection->videoID;
		if (preg_match('!(?:watch\?|&amp;)v=([a-z0-9_\-]+)!i', $videoID, $match)) $videoID = $match[1];

		// return video html
		return '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$videoID.'&amp;hl='.WCF::getLanguage()->getLanguageCode().'"><param name="movie" value="http://www.youtube.com/v/'.$videoID.'&amp;hl='.WCF::getLanguage()->getLanguageCode().'" /><param name="wmode" value="transparent" /></object>';
	}

	/**
	 * @see	ArticleSectionType::getContent()
	 */
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		// get headline
		$headline = '';
		if ($articleSection->headline) {
			WCF::getTPL()->assign('articleSection', $articleSection);
			$headline = WCF::getTPL()->fetch('headlineArticleSectionType');
		}

		// get video html
		$video = $this->getVideoHTML($articleSection);

		// return content
		return $headline.$video;
	}

	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		// get headline
		$headline = parent::getPreviewHTML($articleSection, $article, $contentItem);

		// prepare video preview
		$video = $this->getVideoHTML($articleSection);

		// return preview
		return $headline.$video;
	}

	// form methods
	/**
	 * @see	ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		$this->formData['videoID'] = '';
		if (isset($_POST['videoID'])) $this->formData['videoID'] = StringUtil::trim($_POST['videoID']);
	}

	/**
	 * @see	ArticleSectionType::validate()
	 */
	public function validate() {
		parent::validate();

		// videoID
		if (empty($this->formData['videoID'])) {
			throw new UserInputException('videoID');
		}
	}

	/**
	 * @see	ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'videoID' => (isset($this->formData['videoID']) ? $this->formData['videoID'] : '')
		));
	}

	/**
	 * @see	ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'youTubeArticleSectionType';
	}
}
?>