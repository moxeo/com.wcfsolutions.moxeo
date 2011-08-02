<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/section/type/HeadlineArticleSectionType.class.php');

/**
 * Represents a text article section type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.article.section.type
 * @category	Infinite Site
 */
class TextArticleSectionType extends HeadlineArticleSectionType {
	/**
	 * @see	HeadlineArticleSectionType::$requireHeadline
	 */
	public $requireHeadline = false;
	
	// display methods
	/**
	 * @see	ArticleSectionType::getContent()
	 */	
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		WCF::getTPL()->assign('articleSection', $articleSection);
		return WCF::getTPL()->fetch('textArticleSectionType');
	}
	
	/**
	 * @see	ArticleSectionType::getSearchableContent()
	 */	
	public function getSearchableContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return parent::getSearchableContent($articleSection, $article, $contentItem).' '.StringUtil::stripHTML($articleSection->code);
	}
	
	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */	
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return parent::getPreviewHTML($articleSection, $article, $contentItem).$articleSection->code;
	}
	
	// form methods
	/**
	 * @see	ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		$this->formData['code'] = $this->formData['thumbnail'] = $this->formData['thumbnailCaption'] = $this->formData['thumbnailAlternativeTitle'] = $this->formData['thumbnailURL'] = '';
		$this->formData['enableThumbnail'] = $this->formData['thumbnailEnableFullsize'] = 0;
		
		if (isset($_POST['code'])) $this->formData['code'] = StringUtil::trim($_POST['code']);
		if (isset($_POST['enableThumbnail'])) $this->formData['enableThumbnail'] = intval($_POST['enableThumbnail']);
		if (isset($_POST['thumbnail'])) $this->formData['thumbnail'] = StringUtil::trim($_POST['thumbnail']);
		if (isset($_POST['thumbnailCaption'])) $this->formData['thumbnailCaption'] = StringUtil::trim($_POST['thumbnailCaption']);
		if (isset($_POST['thumbnailAlternativeTitle'])) $this->formData['thumbnailAlternativeTitle'] = StringUtil::trim($_POST['thumbnailAlternativeTitle']);
		if (isset($_POST['thumbnailURL'])) $this->formData['thumbnailURL'] = StringUtil::trim($_POST['thumbnailURL']);
		if (isset($_POST['thumbnailEnableFullsize'])) $this->formData['thumbnailEnableFullsize'] = intval($_POST['thumbnailEnableFullsize']);
	}
	
	/**
	 * @see	ArticleSectionType::validate()
	 */
	public function validate() {
		parent::validate();			
		
		// code
		if (empty($this->formData['code'])) {
			throw new UserInputException('code');
		}
		
		// thumbnail
		if ($this->formData['enableThumbnail']) {
			if (empty($this->formData['thumbnail'])) {
				throw new UserInputException('thumbnail');
			}			
		}
	}
	
	/**
	 * @see	ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'code' => (isset($this->formData['code']) ? $this->formData['code'] : ''),
			'enableThumbnail' => (isset($this->formData['enableThumbnail']) ? $this->formData['enableThumbnail'] : 0),
			'thumbnail' => (isset($this->formData['thumbnail']) ? $this->formData['thumbnail'] : ''),
			'thumbnailCaption' => (isset($this->formData['thumbnailCaption']) ? $this->formData['thumbnailCaption'] : ''),
			'thumbnailAlternativeTitle' => (isset($this->formData['thumbnailAlternativeTitle']) ? $this->formData['thumbnailAlternativeTitle'] : ''),
			'thumbnailURL' => (isset($this->formData['thumbnailURL']) ? $this->formData['thumbnailURL'] : ''),
			'thumbnailEnableFullsize' => (isset($this->formData['thumbnailEnableFullsize']) ? $this->formData['thumbnailEnableFullsize'] : 0)
		));
	}
	
	/**
	 * @see	ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'textArticleSectionType';
	}
}
?>