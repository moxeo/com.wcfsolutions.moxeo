<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/ArticleSection.class.php');

/**
 * Provides functions to manage article sections.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section
 * @category	Moxeo Open Source CMS
 */
class ArticleSectionEditor extends ArticleSection {
	/**
	 * Updates this article section.
	 *
	 * @param	string		$articleSectionType
	 * @param	array		$articleSectionData
	 * @param	integer		$showOrder
	 */
	public function update($articleSectionType, $articleSectionData, $cssID, $cssClasses, $showOrder) {
		// update show order
		if ($this->showOrder != $showOrder) {
			if ($showOrder < $this->showOrder) {
				$sql = "UPDATE	moxeo".MOXEO_N."_article_section
					SET 	showOrder = showOrder + 1
					WHERE 	showOrder >= ".$showOrder."
						AND showOrder < ".$this->showOrder."
						AND articleID = ".$this->articleID;
				WCF::getDB()->sendQuery($sql);
			}
			else if ($showOrder > $this->showOrder) {
				$sql = "UPDATE	moxeo".MOXEO_N."_article_section
					SET	showOrder = showOrder - 1
					WHERE	showOrder <= ".$showOrder."
						AND showOrder > ".$this->showOrder."
						AND articleID = ".$this->articleID;
				WCF::getDB()->sendQuery($sql);
			}
		}

		// update article section
		$sql = "UPDATE	moxeo".MOXEO_N."_article_section
			SET	articleSectionType = '".escapeString($articleSectionType)."',
				articleSectionData = '".escapeString(serialize($articleSectionData))."',
				cssID = '".escapeString($cssID)."',
				cssClasses = '".escapeString($cssClasses)."',
				showOrder = ".$showOrder."
			WHERE	articleSectionID = ".$this->articleSectionID;
		WCF::getDB()->sendQuery($sql);
	}

	/**
	 * Updates the show order of this article section.
	 *
	 * @param	integer		$showOrder
	 */
	public function updateShowOrder($showOrder) {
		$sql = "UPDATE	moxeo".MOXEO_N."_article_section
			SET 	showOrder = ".$showOrder."
			WHERE 	articleSectionID = ".$this->articleSectionID;
		WCF::getDB()->sendQuery($sql);
	}

	/**
	 * Deletes this article section.
	 */
	public function delete() {
		self::deleteAll($this->articleSectionID);
	}

	/**
	 * Creates a new article section.
	 *
	 * @param	integer			$articleID
	 * @param	string			$articleSectionType
	 * @param	array			$articleSectionData
	 * @param	integer			$showOrder
	 * @return	ArticleSectionEditor
	 */
	public static function create($articleID, $articleSectionType, $articleSectionData, $cssID, $cssClasses, $showOrder) {
		// get show order
		if ($showOrder == 0) {
			// get next number in row
			$sql = "SELECT	MAX(showOrder) AS showOrder
				FROM	moxeo".MOXEO_N."_article_section
				WHERE	articleID = ".$articleID;
			$row = WCF::getDB()->getFirstRow($sql);
			if (!empty($row)) $showOrder = intval($row['showOrder']) + 1;
			else $showOrder = 1;
		}
		else {
			$sql = "UPDATE	moxeo".MOXEO_N."_article_section
				SET 	showOrder = showOrder + 1
				WHERE 	showOrder >= ".$showOrder."
					AND articleID = ".$articleID;
			WCF::getDB()->sendQuery($sql);
		}

		// save article section
		$sql = "INSERT INTO	moxeo".MOXEO_N."_article_section
					(articleID, articleSectionType, articleSectionData, cssID, cssClasses, showOrder)
			VALUES		(".$articleID.", '".escapeString($articleSectionType)."', '".escapeString(serialize($articleSectionData))."', '".escapeString($cssID)."', '".escapeString($cssClasses)."', ".$showOrder.")";
		WCF::getDB()->sendQuery($sql);

		$articleSectionID = WCF::getDB()->getInsertID("moxeo".MOXEO_N."_article_section", 'articleSectionID');
		return new ArticleSectionEditor($articleSectionID);
	}

	/**
	 * Deletes all article sections with the given article section ids.
	 *
	 * @param	string		$articleSectionIDs
	 */
	public static function deleteAll($articleSectionIDs) {
		if (empty($articleSectionIDs)) return;

		// get all comment ids
		$commentIDs = '';
		$sql = "SELECT	commentID
			FROM	moxeo".MOXEO_N."_comment
			WHERE	articleSectionID IN (".$articleSectionIDs.")";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			if (!empty($commentIDs)) $commentIDs .= ',';
			$commentIDs .= $row['commentID'];
		}
		if (!empty($commentIDs)) {
			// delete comments
			require_once(MOXEO_DIR.'lib/data/comment/CommentEditor.class.php');
			CommentEditor::deleteAll($commentIDs);
		}

		// update show order
		$sql = "SELECT	articleID, showOrder
			FROM	moxeo".MOXEO_N."_article_section
			WHERE	articleSectionID IN (".$articleSectionIDs.")";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$sql = "UPDATE	moxeo".MOXEO_N."_article_section
				SET 	showOrder = showOrder - 1
				WHERE 	showOrder >= ".$row['showOrder']."
					AND articleID = ".$row['articleID'];
			WCF::getDB()->sendQuery($sql);
		}

		// delete article section
		$sql = "DELETE FROM	moxeo".MOXEO_N."_article_section
			WHERE		articleSectionID IN (".$articleSectionIDs.")";
		WCF::getDB()->sendQuery($sql);
	}
}
?>