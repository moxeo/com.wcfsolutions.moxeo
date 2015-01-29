<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/type/ViewableArticleSectionType.class.php');

/**
 * Represents the comments article section type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section.type
 * @category	Moxeo Open Source CMS
 */
class CommentsArticleSectionType extends ViewableArticleSectionType {
	/**
	 * @see	ViewableArticleSectionType::getPageElement()
	 */
	public function getPageElement() {
		return 'comments';
	}
}
?>