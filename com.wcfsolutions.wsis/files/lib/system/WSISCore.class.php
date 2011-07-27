<?php
// wsis imports
require_once(WSIS_DIR.'lib/system/request/ContentItemRequestHandler.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/theme/ThemeLayoutManager.class.php');

/**
 * This class extends the main WCF class by cms specific functions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system
 * @category	Infinite Site
 */
class WSISCore extends WCF {	
	/**
	 * @see WCF::initLanguage()
	 */
	protected function initLanguage() {
		$languageID = ContentItemRequestHandler::getInstance()->getLanguageID();
		self::$languageObj = new Language($languageID);
	}
	
	/**
	 * @see WCF::initTPL()
	 */
	protected function initTPL() {
		// init theme layout to get template pack id
		$this->initThemeLayout();
		
		global $packageDirs;
		require_once(WCF_DIR.'lib/system/template/StructuredTemplate.class.php');
		self::$tplObj = new StructuredTemplate(self::getThemeLayout()->getTheme()->templatePackID, self::getLanguage()->getLanguageID(), ArrayUtil::appendSuffix($packageDirs, 'templates/'));
		$this->assignDefaultTemplateVariables();
		
		// init cronjobs
		$this->initCronjobs();
	}
	
	/**
	 * Initialises the cronjobs.
	 */
	protected function initCronjobs() {
		self::getTPL()->assign('executeCronjobs', WCF::getCache()->get('cronjobs-'.PACKAGE_ID, 'nextExec') < TIME_NOW);
	}
	
	/**
	 * @see WCF::loadDefaultCacheResources()
	 */
	protected function loadDefaultCacheResources() {
		parent::loadDefaultCacheResources();
		self::loadDefaultWSISCacheResources();
	}
	
	/**
	 * Loads default cache resources of content management system.
	 * Can be called statically from other applications or plugins.
	 */
	public static function loadDefaultWSISCacheResources() {
		WCF::getCache()->addResource('contentItem', WSIS_DIR.'cache/cache.contentItem.php', WSIS_DIR.'lib/system/cache/CacheBuilderContentItem.class.php');
		WCF::getCache()->addResource('contentItemAlias', WSIS_DIR.'cache/cache.contentItemAlias.php', WSIS_DIR.'lib/system/cache/CacheBuilderContentItemAlias.class.php');
		WCF::getCache()->addResource('contentItemStructure', WSIS_DIR.'cache/cache.contentItemStructure.php', WSIS_DIR.'lib/system/cache/CacheBuilderContentItemStructure.class.php');
		WCF::getCache()->addResource('contentItemArticles', WSIS_DIR.'cache/cache.contentItemArticles.php', WSIS_DIR.'lib/system/cache/CacheBuilderContentItemArticles.class.php');
		WCF::getCache()->addResource('cronjobs-'.PACKAGE_ID, WCF_DIR.'cache/cache.cronjobs-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderCronjobs.class.php');
		WCF::getCache()->addResource('newsArchive', WSIS_DIR.'cache/cache.newsArchive.php', WSIS_DIR.'lib/system/cache/CacheBuilderNewsArchive.class.php');
		WCF::getCache()->addResource('theme-'.PACKAGE_ID, WCF_DIR.'cache/cache.theme-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderTheme.class.php');
		WCF::getCache()->addResource('themeLayout-'.PACKAGE_ID, WCF_DIR.'cache/cache.themeLayout-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderThemeLayout.class.php');
		WCF::getCache()->addResource('themeModule-'.PACKAGE_ID, WCF_DIR.'cache/cache.themeModule-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderThemeModule.class.php');
	}
	
	/**
	 * @see WCF::getOptionsFilename()
	 */
	protected function getOptionsFilename() {
		return WSIS_DIR.'options.inc.php';
	}
	
	/**
	 * Initialises the theme layout system.
	 */
	protected function initThemeLayout() {
		ThemeLayoutManager::changeThemeLayout();
	}
	
	/**
	 * Returns the active theme layout object.
	 * 
	 * @return	ThemeLayout
	 */
	public static final function getThemeLayout() {
		return ThemeLayoutManager::getThemeLayout();
	}
	
	/**
	 * @see WCF::initSession()
	 */
	protected function initSession() {
		// start session
		require_once(WSIS_DIR.'lib/system/session/WSISSessionFactory.class.php');
		$factory = new WSISSessionFactory();
		self::$sessionObj = $factory->get();
		self::$userObj = self::getSession()->getUser();
	}
}
?>