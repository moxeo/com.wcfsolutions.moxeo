<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents an article section.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.article.section
 * @category	Infinite Site
 */
class ArticleSection extends DatabaseObject {
	/**
	 * list of article section types
	 * 
	 * @var	array
	 */
	public static $articleSectionTypes = null;
	
	/**
	 * list of available article section types
	 * 
	 * @var	array<ArticleSectionType>
	 */
	public static $availableArticleSectionTypes = null;
	
	/**
	 * list of article section options
	 * 
	 * @var	array
	 */
	protected $articleSectionOptions = null;
	
	/**
	 * Creates a new ArticleSection object.
	 * 
	 * @param 	integer		$articleSectionID
	 * @param 	array		$row
	 */
	public function __construct($articleSectionID, $row = null) {
		if ($articleSectionID !== null) {
			$sql = "SELECT	*
				FROM 	wsis".WSIS_N."_article_section
				WHERE 	articleSectionID = ".$articleSectionID;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		parent::__construct($row);
	}
	
	/**
	 * Returns the article section type of this article section.
	 * 
	 * @return	ArticleSection
	 */
	public function getArticleSectionType() {
		return self::getArticleSectionTypeObject($this->articleSectionType);
	}
	
	/**
	 * Returns the value of the article section option with the given name.
	 * 
	 * @param	string		$name
	 * @return	mixed
	 */
	public function getArticleSectionOption($name) {
		if ($this->articleSectionOptions === null) {
			$this->articleSectionOptions = array();
			if ($this->data['articleSectionData']) {
				$this->articleSectionOptions = unserialize($this->data['articleSectionData']);
			}
		}
		
		if (isset($this->articleSectionOptions[$name])) {
			return $this->articleSectionOptions[$name];
		}
		
		return null;
	}
	
	/**
	 * @see	DatabaseObject::__get()
	 */
	public function __get($name) {
		$value = parent::__get($name);
		if ($value === null) $value = $this->getArticleSectionOption($name);
		return $value;
	}
	
	/**
	 * Returns an commmentable object object for this article section.
	 *
	 * @return	ArticleSectionCommentableObject
	 */
	public function getCommentableObject() {
		require_once(WSIS_DIR.'lib/data/article/section/ArticleSectionCommentableObject.class.php');
		return new ArticleSectionCommentableObject(null, $this->data);
	}
	
	/**
	 * Returns the object of an article section type.
	 * 
	 * @param	string			$articleSectionType
	 * @return	ArticleSectionType
	 */
	public static function getArticleSectionTypeObject($articleSectionType) {
		$types = self::getAvailableArticleSectionTypes();
		if (!isset($types[$articleSectionType])) {
			throw new SystemException("Unknown article section type '".$articleSectionType."'", 11000);
		}	
		return $types[$articleSectionType];
	}
	
	/**
	 * Returns a list of article section types.
	 * 
	 * @return	array
	 */
	public static function getArticleSectionTypes() {
		if (self::$articleSectionTypes === null) {
			WCF::getCache()->addResource('articleSectionTypes', WSIS_DIR.'cache/cache.articleSectionTypes.php', WSIS_DIR.'lib/system/cache/CacheBuilderArticleSectionTypes.class.php');
			self::$articleSectionTypes = WCF::getCache()->get('articleSectionTypes');
		}
		return self::$articleSectionTypes;
	}
	
	/**
	 * Returns a list of available article section types.
	 * 
	 * @return	array<ArticleSectionType>
	 */
	public static function getAvailableArticleSectionTypes() {
		if (self::$availableArticleSectionTypes === null) {
			$types = self::getArticleSectionTypes();
			foreach ($types as $type) {
				// get path to class file
				$path = WSIS_DIR.$type['classFile'];
				
				// include class file
				if (!class_exists($type['className'])) {
					if (!file_exists($path)) {
						throw new SystemException("Unable to find class file '".$path."'", 11000);
					}
					require_once($path);
				}
				
				// instance object
				if (!class_exists($type['className'])) {
					throw new SystemException("Unable to find class '".$type['className']."'", 11001);
				}
				self::$availableArticleSectionTypes[$type['articleSectionType']] = new $type['className'];
			}
		}
		return self::$availableArticleSectionTypes;
	}
	
	/**
	 * Returns the article section type options.
	 * 
	 * @return	array
	 */
	public static function getArticleSectionTypeOptions() {
		$options = array();
		
		$types = self::getArticleSectionTypes();
		foreach ($types as $type) {
			$category = WCF::getLanguage()->get('wsis.article.section.type.category.'.$type['category']);
			
			if (!isset($options[$category])) {
				$options[$category] = array();
			}
			
			$options[$category][$type['articleSectionType']] = WCF::getLanguage()->get('wsis.article.section.type.'.$type['articleSectionType']);
		}
		
		return $options;
	}
}