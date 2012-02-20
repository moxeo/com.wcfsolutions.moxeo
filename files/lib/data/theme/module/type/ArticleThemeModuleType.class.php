<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/Article.class.php');
require_once(MOXEO_DIR.'lib/data/article/section/ArticleSection.class.php');
require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/AbstractThemeModuleType.class.php');

/**
 * Represents an article theme module type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.theme.module.type
 * @category	Moxeo Open Source CMS
 */
class ArticleThemeModuleType extends AbstractThemeModuleType {
	/**
	 * list of articles
	 *
	 * @var	array
	 */
	public $articles = null;

	/**
	 * list of article sections
	 *
	 * @var	array
	 */
	public $articleSections = null;

	// display methods
	/**
	 * @see	ThemeModuleType::cache()
	 */
	public function cache(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return;
		$contentItem = $additionalData['contentItem'];

		if ($this->articles === null) {
			$this->articles = $this->articleSections = array();

			// get required article ids of ALL theme module positions
			$cache = WCF::getCache()->get('contentItemArticles');
			$articleIDs = '';
			foreach ($cache[$contentItem->contentItemID] as $themeModulePosition => $articleIDArray) {
				if (!empty($articleIDs)) $articleIDs .= ',';
				$articleIDs .= implode(',', $articleIDArray);
			}

			if ($articleIDs) {
				// get article sections
				$sql = "SELECT		*
					FROM		moxeo".MOXEO_N."_article_section
					WHERE		articleID IN (".$articleIDs.")
					ORDER BY	articleID, showOrder";
				$result = WCF::getDB()->sendQuery($sql);
				while ($row = WCF::getDB()->fetchArray($result)) {
					if (!isset($this->articleSections[$row['articleID']])) {
						$this->articleSections[$row['articleID']] = array();
					}
					$this->articleSections[$row['articleID']][] = new ArticleSection(null, $row);
				}

				// get articles
				$sql = "SELECT		*
					FROM		moxeo".MOXEO_N."_article
					WHERE		articleID IN (".$articleIDs.")
					ORDER BY	themeModulePosition, showOrder";
				$result = WCF::getDB()->sendQuery($sql);
				while ($row = WCF::getDB()->fetchArray($result)) {
					$article = new Article(null, $row);

					if (!isset($this->articles[$row['themeModulePosition']])) {
						$this->articles[$row['themeModulePosition']] = array();
					}
					$this->articles[$row['themeModulePosition']][] = $article;

					// cache article section data
					if (isset($this->articleSections[$row['articleID']])) {
						foreach ($this->articleSections[$row['articleID']] as $articleSection) {
							$articleSection->getArticleSectionType()->cache($articleSection, $article, $contentItem);
						}
					}
				}
			}
		}
	}

	/**
	 * @see	ThemeModuleType::getContent()
	 */
	public function getContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return '';
		$contentItem = $additionalData['contentItem'];

		WCF::getTPL()->assign(array(
			'contentItem' => $contentItem,
			'articles' => (isset($this->articles[$themeModulePosition]) ? $this->articles[$themeModulePosition] : array()),
			'articleSections' => $this->articleSections
		));
		return WCF::getTPL()->fetch('articleThemeModuleType');
	}
}
?>