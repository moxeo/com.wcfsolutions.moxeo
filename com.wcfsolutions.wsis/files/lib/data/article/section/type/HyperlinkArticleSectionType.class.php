<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/section/type/HeadlineArticleSectionType.class.php');

/**
 * Represents a hyperlink article section type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.article.section.type
 * @category	Infinite Site
 */
class HyperlinkArticleSectionType extends HeadlineArticleSectionType {
	/**
	 * @see	HeadlineArticleSectionType::$requireHeadline
	 */
	public $requireHeadline = false;
	
	// display methods
	/**
	 * @see	ArticleSectionType::getContent()
	 */	
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		WCF::getTPL()->assign(array(
			'articleSection' => $articleSection
		));
		return WCF::getTPL()->fetch('hyperlinkArticleSectionType');
	}
	
	// form methods
	/**
	 * @see ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		$this->formData['url'] = 'http://';
		$this->formData['caption'] = '';
		
		if (isset($_POST['url'])) $this->formData['url'] = StringUtil::trim($_POST['url']);
		if (isset($_POST['caption'])) $this->formData['caption'] = StringUtil::trim($_POST['caption']);
	}
	
	/**
	 * @see ArticleSectionType::validate()
	 */
	public function validate() {
		parent::validate();
		
		if (empty($this->formData['url'])) {
			throw new UserInputException('url');
		}
		
		if (!FileUtil::isURL($this->formData['url'])) {
			throw new UserInputException('url');
		}
	}
	
	/**
	 * @see ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'url' => (isset($this->formData['url']) ? $this->formData['url'] : 'http://'),
			'caption' => (isset($this->formData['caption']) ? $this->formData['caption'] : '')
		));
	}
	
	/**
	 * @see ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'hyperlinkArticleSectionType';
	}
}
?>