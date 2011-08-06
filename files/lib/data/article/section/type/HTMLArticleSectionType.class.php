<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/section/type/AbstractArticleSectionType.class.php');

/**
 * Represents a html article section type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.article.section.type
 * @category	Infinite Site
 */
class HTMLArticleSectionType extends AbstractArticleSectionType {
	// display methods
	/**
	 * @see	ArticleSectionType::getContent()
	 */	
	public function getContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		if ($articleSection->dynamicCode) {
			return WCF::getTPL()->fetchString($articleSection->dynamicCode);
		}
		return $articleSection->code;
	}
	
	/**
	 * @see	ArticleSectionType::getSearchableContent()
	 */	
	public function getSearchableContent(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		$code = $this->getContent($articleSection);
		return StringUtil::stripHTML($code);
	}

	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */	
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return $articleSection->code;
	}
	
	// form methods
	/**
	 * @see	ArticleSectionType::readFormParameters()
	 */
	public function readFormParameters() {
		$this->formData['code'] = '';
		if (isset($_POST['code'])) $this->formData['code'] = StringUtil::trim($_POST['code']);
	}
	
	/**
	 * @see	ArticleSectionType::validate()
	 */
	public function validate() {
		// code
		if (empty($this->formData['code'])) {
			throw new UserInputException('code');
		}
		
		// compile dynamic code
		$this->formData['dynamicCode'] = '';
		if (strpos($this->formData['code'], '{') !== false) {
			require_once(WCF_DIR.'lib/system/template/TemplateScriptingCompiler.class.php');
			$scriptingCompiler = new TemplateScriptingCompiler(WCF::getTPL());
			try {
				$this->formData['dynamicCode'] = $scriptingCompiler->compileString('htmlArticleSectionType', $this->formData['code']);
			}
			catch (SystemException $e) {
				throw new UserInputException('code', 'syntaxError');
			}
		}
	}
	
	/**
	 * @see	ArticleSectionType::assignVariables()
	 */
	public function assignVariables() {
		WCF::getTPL()->assign(array(
			'code' => (isset($this->formData['code']) ? $this->formData['code'] : '')
		));
	}
	
	/**
	 * @see	ArticleSectionType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'htmlArticleSectionType';
	}
}
?>