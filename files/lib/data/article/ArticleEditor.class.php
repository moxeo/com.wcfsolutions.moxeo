<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/Article.class.php');

/**
 * Provides functions to manage articles.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article
 * @category	Moxeo Open Source CMS
 */
class ArticleEditor extends Article {
	/**
	 * Updates this article.
	 *
	 * @param	string		$themeModulePosition
	 * @param	string		$title
	 * @param	string		$cssID
	 * @param	string		$cssClasses
	 * @param	integer		$showOrder
	 */
	public function update($themeModulePosition, $title, $cssID, $cssClasses, $showOrder) {
		// update show order
		if ($this->showOrder != $showOrder) {
			if ($showOrder < $this->showOrder) {
				$sql = "UPDATE	moxeo".MOXEO_N."_article
					SET 	showOrder = showOrder + 1
					WHERE 	showOrder >= ".$showOrder."
						AND showOrder < ".$this->showOrder."
						AND contentItemID = ".$this->contentItemID;
				WCF::getDB()->sendQuery($sql);
			}
			else if ($showOrder > $this->showOrder) {
				$sql = "UPDATE	moxeo".MOXEO_N."_article
					SET	showOrder = showOrder - 1
					WHERE	showOrder <= ".$showOrder."
						AND showOrder > ".$this->showOrder."
						AND contentItemID = ".$this->contentItemID;
				WCF::getDB()->sendQuery($sql);
			}
		}

		// update article
		$sql = "UPDATE	moxeo".MOXEO_N."_article
			SET	themeModulePosition = '".escapeString($themeModulePosition)."',
				title = '".escapeString($title)."',
				cssID = '".escapeString($cssID)."',
				cssClasses = '".escapeString($cssClasses)."',
				showOrder = ".$showOrder."
			WHERE	articleID = ".$this->articleID;
		WCF::getDB()->sendQuery($sql);
	}

	/**
	 * Updates the show order of this article.
	 *
	 * @param	integer		$showOrder
	 */
	public function updateShowOrder($showOrder) {
		$sql = "UPDATE	moxeo".MOXEO_N."_article
			SET 	showOrder = ".$showOrder."
			WHERE 	articleID = ".$this->articleID;
		WCF::getDB()->sendQuery($sql);
	}

	/**
	 * Deletes this article.
	 */
	public function delete() {
		self::deleteAll($this->articleID);
	}

	/**
	 * Creates a new article.
	 *
	 * @param	integer		$contentItemID
	 * @param	string		$themeModulePosition
	 * @param	string		$title
	 * @param	string		$cssID
	 * @param	string		$cssClasses
	 * @param	integer		$showOrder
	 * @return	ArticleEditor
	 */
	public static function create($contentItemID, $themeModulePosition, $title, $cssID, $cssClasses, $showOrder) {
		// get show order
		if ($showOrder == 0) {
			// get next number in row
			$sql = "SELECT	MAX(showOrder) AS showOrder
				FROM	moxeo".MOXEO_N."_article
				WHERE	contentItemID = ".$contentItemID;
			$row = WCF::getDB()->getFirstRow($sql);
			if (!empty($row)) $showOrder = intval($row['showOrder']) + 1;
			else $showOrder = 1;
		}
		else {
			$sql = "UPDATE	moxeo".MOXEO_N."_article
				SET 	showOrder = showOrder + 1
				WHERE 	showOrder >= ".$showOrder."
					AND contentItemID = ".$contentItemID;
			WCF::getDB()->sendQuery($sql);
		}

		// save article
		$sql = "INSERT INTO	moxeo".MOXEO_N."_article
					(contentItemID, themeModulePosition, title, cssID, cssClasses, showOrder)
			VALUES		(".$contentItemID.", '".escapeString($themeModulePosition)."', '".escapeString($title)."', '".escapeString($cssID)."', '".escapeString($cssClasses)."', ".$showOrder.")";
		WCF::getDB()->sendQuery($sql);

		$articleID = WCF::getDB()->getInsertID("moxeo".MOXEO_N."_article", 'articleID');
		return new ArticleEditor($articleID);
	}

	/**
	 * Deletes all articles with the given article ids.
	 *
	 * @param	string		$articleIDs
	 */
	public static function deleteAll($articleIDs) {
		if (empty($articleIDs)) return;

		// get all article section ids
		$articleSectionIDs = '';
		$sql = "SELECT	articleSectionID
			FROM	moxeo".MOXEO_N."_article_section
			WHERE	articleID IN (".$articleIDs.")";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			if (!empty($articleSectionIDs)) $articleSectionIDs .= ',';
			$articleSectionIDs .= $row['articleSectionID'];
		}
		if (!empty($articleSectionIDs)) {
			// delete article sections
			require_once(MOXEO_DIR.'lib/data/article/section/ArticleSectionEditor.class.php');
			ArticleSectionEditor::deleteAll($articleSectionIDs);
		}

		// update show order
		$sql = "SELECT	contentItemID, showOrder
			FROM	moxeo".MOXEO_N."_article
			WHERE	articleID IN (".$articleIDs.")";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$sql = "UPDATE	moxeo".MOXEO_N."_article
				SET 	showOrder = showOrder - 1
				WHERE 	showOrder >= ".$row['showOrder']."
					AND contentItemID = ".$row['contentItemID'];
			WCF::getDB()->sendQuery($sql);
		}

		// delete article sections
		$sql = "DELETE FROM	moxeo".MOXEO_N."_article_section
			WHERE		articleID IN (".$articleIDs.")";
		WCF::getDB()->sendQuery($sql);

		// delete article
		$sql = "DELETE FROM	moxeo".MOXEO_N."_article
			WHERE		articleID IN (".$articleIDs.")";
		WCF::getDB()->sendQuery($sql);
	}
}
?>