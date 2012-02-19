<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/HeadlineArticleSectionType.class.php');

/**
 * Represents a you tube article section type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
class YouTubeArticleSectionType extends HeadlineArticleSectionType {
	/**
	 * @see	HeadlineArticleSectionType::$requireHeadline
	 */
	public $requireHeadline = false;
	
	// display methods
	/**
	 * @see	ArticleSectionType::getContent()
	 */	
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		// get video id
		$videoID = $articleSection->videoID;
		if (preg_match('!(?:watch\?|&amp;)v=([a-z0-9_\-]+)!i', $videoID, $match)) $videoID = $match[1];
		
		// get dimensions
		$width = 425;
		$height = 344;
		
		return '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$videoID.'&amp;hl='.WCF::getLanguage()->getLanguageCode().'"><param name="movie" value="http://www.youtube.com/v/'.$videoID.'&amp;hl='.WCF::getLanguage()->getLanguageCode().'" /><param name="wmode" value="transparent" /></object>';
	}
	
	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */	
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return $articleSection->videoID;
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